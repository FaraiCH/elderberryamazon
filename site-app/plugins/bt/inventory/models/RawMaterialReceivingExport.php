<?php namespace Bt\Inventory\Models;

use Backend\Models\ExportModel;
use Backend\Models\User;
use Model;
use BackendAuth;

/**
 * RawMaterialReceiving Model
 */
class RawMaterialReceivingExport extends ExportModel
{

    public $table = 'bt_inventory_raw_material_receivings';


    public $hasMany = [
        'release' =>['Bt\Inventory\Models\StockRelease','key'=>'raw_material_receivings_id'],
        'request' =>['Bt\Inventory\Models\RequestMaterial','key'=>'raw_material_receivings_id'],
        'used' =>['Bt\Production\Models\MaterialUsed','key'=>'raw_material_receivings_id'],
        'incage' =>['Bt\Inventory\Models\CageMaterial','key'=>'raw_material_receivings_id'],
    ];
    public $belongsTo = [
        'purchase' =>['Bt\Inventory\Models\Purchase','key'=>'purchase_id'],
        'productname' =>['Bt\Inventory\Models\PartNames','key'=>'part_name_id','orderby'=>'name'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];

    protected $appends = [
        'active_name',
        'productname_value',
        'supplier_name',
        'updated_by_name',
        'created_by_name',
        'used_name',
        'not_used',
        'released_n'

    ];

    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }

    public function getCreatedByNameAttribute() {
        $user = User::find($this->created_by);
        if(!empty(isset($user)))
        {
            return $user->first_name . " " . $user->last_name;
        }
    }
    public function getUpdatedByNameAttribute() {
        $user = User::find($this->updated_by);
        if(!empty(isset($user)))
        {
            return $user->first_name . " " . $user->last_name;
        }
    }

    public function getActiveNameAttribute()
    {
        if ($this->active == 1){
            return ' Active';
        }else{
            return 'Inactive';
        }
    }

    public function getProductnameValueAttribute()
    {   
        return $this->productname ? $this->productname->name : null; 
    }

    public function getSupplierNameAttribute()
    {
        if(isset($this->productname->supplier))
        {
            return $this->productname->supplier->name;
        }

    }

    public function getReleasedNAttribute(){
        return $this->release->sum('kg');
    }

    public function getUsedNameAttribute(){
        return $this->used->sum('kg');
    }

    public function getNotUsedAttribute(){
        return $this->release->sum('kg') - $this->used->sum('kg');
    }

}
