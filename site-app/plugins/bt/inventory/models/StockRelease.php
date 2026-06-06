<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;
use Flash;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceivingModel;

/**
 * StockRelease Model
 */
class StockRelease extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_stock_releases';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'datecaptured' => 'required',
        'kg' => 'required',
        'reason' => 'required',
        
    ];


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'usedmaterial' =>['Bt\Production\Models\MaterialUsed','key'=>'raw_material_release_id'], 
    ];
    public $belongsTo = [
        'reason' =>['Bt\Inventory\Models\ReleaseReason','key'=>'release_reason_id'],
        'recieve' =>['Bt\Inventory\Models\RawMaterialReceiving','key'=>'raw_material_receivings_id'],
        'productname' =>['Bt\Inventory\Models\PartNames','key'=>'part_name_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

     public function beforeCreate()
    {        
        if($this->checkkg($this->kg,$this->raw_material_receivings_id)){
           $user = BackendAuth::getUser();
        if (!$user) return;
            $this->created_by = $user->id; 
        }else{
            return false;
        }        
    }
    public function beforeUpdate()
    {
       
        if($this->checkkg($this->kg,$this->raw_material_receivings_id)){
            $user = BackendAuth::getUser();
        if (!$user) return;
            $this->updated_by = $user->id;
        }else{
            return false;
        }
    }

    private function checkkg($kg,$mre){

        if($kg > 0){
            $obj = RawMaterialReceivingModel::find($mre); 
            $countweight = 0;

            foreach ($obj->release as $key => $value) {
                $countweight += $value->kg;
            }
            $total = $countweight;
            $countweight += $kg;

            
            if($kg > 0 && $obj->weight >= $countweight){
                return true;
            }else{
                Flash::error("Invalid weight $kg kg (Max ".($obj->weight - $total)." kg)");
                return false;
            }
        }else{
            return true;
        }
        
    }
}
