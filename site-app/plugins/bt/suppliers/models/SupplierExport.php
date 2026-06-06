<?php


namespace Bt\Suppliers\Models;


use Backend\Models\ExportModel;
use Backend\Models\User;


class SupplierExport extends ExportModel
{
    public $table = 'bt_suppliers_materialsuppliers';

    protected $appends = [
        'updatedby_name',
        'createdby_name',
        'category',
        'vendor',
    ];

    public $belongsTo = [
        'category' => ['Bt\Suppliers\Models\Category'],
        'vendor' => ['Bt\Suppliers\Models\Vendor','key'=>'vendor_type_id'],
        'country' =>['RainLab\Location\Models\Country','key'=>'country_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = Materialsupplier::orderBy('name', 'ASC')->get();
        $query->each(function($records) use ($columns) {
            $records->addVisible($columns);
        });
        return $query->toArray();
    }

    public function getUpdatedbyNameAttribute()
    {

        $user = User::find($this->updated_by);
        if(!empty(isset($user)))
        {
            return $user->first_name . " " . $user->last_name;
        }

    }

    public function getCreatedbyNameAttribute()
    {
        $user = User::find($this->created_by);
        if(!empty(isset($user)))
        {
            return $user->first_name . " " . $user->last_name;
        }
    }
    public function getCategoryAttribute()
    {
        if(isset ($this->category_id)){
            $category = Category::find($this->category_id);
            return $category->name;
        }

    }
    public function getVendorAttribute()
    {
        if(isset ($this->vendor_id)){
            $vendor = Vendor::find($this->vendor_id);
            return $vendor->name;
        }
    }
}
