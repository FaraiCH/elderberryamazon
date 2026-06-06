<?php


namespace Bt\Inventory\Models;


use Backend\Models\ExportModel;
use Backend\Models\User;
use RainLab\Location\Models\Country;

class SupplierExport extends ExportModel
{
    public $table = 'bt_inventory_suppliers';

    protected $appends = [
        'category_name',
        'country_name',
        'updatedby_name',
        'createdby_name'
    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }

    public function getCategoryNameAttribute()
    {
        $category = MaterialCat::find($this->cat_id);
        if(!empty(isset($category)))
        {
            return $category->name;
        }

    }

    public function getCountryNameAttribute()
    {
        $country = Country::find($this->country_id);
        if(!empty(isset($country)))
        {
            return $country->name;
        }

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



}
