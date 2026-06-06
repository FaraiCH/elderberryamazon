<?php namespace RW\PLProperties\Components;

use Cms\Classes\ComponentBase;

use RW\PLProperties\Models\Property as PropertyModule;
use RainLab\User\Models\User as UserModel;
use Flash;      
use Auth;
use Input;

class ClientList extends ComponentBase
{
    public $nprop;
    public $propcount;
    public $compprop;
    public $user;

    public function componentDetails()
    {
        return [
            'name'        => 'ClientList Component',
            'description' => 'No description provided yet...'
        ];
    }



    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $user = Auth::getUser();
        $this->user = UserModel::find($user->id);
      
        if(!empty($this->user->client->properties) && count($this->user->client->properties)> 0){
           // dd($this->user->client->properties);
            
            $this->nprop = $this->user->client;
        }

        $compprop = [];

        $count = 0;
        if( isset($this->nprop->properties) && !empty($this->nprop->properties) ){
            $count = count($this->nprop->properties);            
        }

                       
        if(!empty($this->user->companies)){
            foreach ($this->user->companies as $c => $cval) {
                if(!empty($cval->client->properties) && count($cval->client->properties) > 0){
                    $compprop[$cval->bankref]["company"] = $cval;
                    $compprop[$cval->bankref]["client"] = $cval->client;
                    $compprop[$cval->bankref]["clientid"] = $cval->client->id;
                    $count += count($cval->client->properties);
                }
            }   
        }
        $this->compprop = $compprop;
        $this->propcount = $count;

    }

}
