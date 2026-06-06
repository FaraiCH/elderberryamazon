<?php namespace Bt\PLCommon\Models;

use Model;
use Backend\Models\User as bkuser;
/**
 * Task Model
 */
class Settings  extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = '`pl_task_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    public $testing = 'fields.yaml'; 

    static function listLookParent(){
        

        $obj = bkuser::all();


       // dd(bkuser::all()->toArray());

        $permissions = array();
        foreach ($obj as $key => $value) {
                if(is_array($value->permissions)){
                   // dd($value->permissions);
                    #$permissions = array_merge($permissions, $value->permissions);    
                    foreach ($value->permissions as $up => $upv){
                        $permissions[$up] = -1;
                    }
                }
                
        }


        foreach ($obj as $key => $value){
            foreach ($permissions as $p => $pv){
                $found = 0;
                if(is_array($value->permissions)){
                   foreach ($value->permissions as $up => $upv){
                        if($up == $p){
                            $found = $upv;
                        }
                    }

                    if($found==0){
                       
                    
                        $u = bkuser::find($value->id);
                        $paarray =  $u->permissions;
                        $paarray[$p] = -1;
                        $u->permissions = $paarray;
                        $u->save();
                       //dd(json_encode($paarray));
                    }

                }
            }
        }
                                
                            
                       

        return array("permissions"=>$permissions,"users"=>bkuser::all());
        
    }

}
