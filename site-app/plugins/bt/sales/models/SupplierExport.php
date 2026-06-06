<?php


namespace Bt\Sales\Models;


use Backend\Models\ExportModel;
use Backend\Models\User;

class SupplierExport extends ExportModel
{
    public $table = 'bt_sales_suppliers';

    protected $appends = [
        'updatedby_name',
        'createdby_name'
    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
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
