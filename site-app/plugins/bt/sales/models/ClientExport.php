<?php namespace Bt\Sales\Models;

use Backend\Models\User;
use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Sales\Models\Client;

class ClientExport extends ExportModel {

    /**
     * @var array Fillable fields
     */
    // protected $fillable = [];
    public $table = 'bt_sales_clients';

//    public $attachMany = [
//        'contract' => 'System\Models\File',
//    ];

    protected $appends = [
        'contract_name',
        'is_blocked_name',
        'account',
        'category',
        'balance'
        ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }

    public function getISBlockedNameAttribute()
    {
        if($this->is_blocked == 1)
        {
            return 'Yes';
        }
        else
        {
            return 'No';
        }
    }
    public function getContractNameAttribute()
    {
        $myclient = \Bt\Sales\Models\Client::find($this->id);
        if(isset($myclient->contract))
        {
            return $myclient->contract->count();
        }

    }
    public function getAccountAttribute()
    {
        $myclient = \Bt\Sales\Models\Client::find($this->id);
        if(isset($myclient->user_id))
        {
            return $myclient->user_id;
        }

    }
    public function getCategoryAttribute()
    {
        $myclient = \Bt\Sales\Models\Client::find($this->id);
        if(isset($myclient->client_category->name))
        {
            return $myclient->client_category->name;
        }

    }

    public function getBalanceAttribute()
    {
        $count = $this->limit - $this->utilization;
        if ($count > 0) {
            return number_format($count, 2);
        } else {
            return number_format($count, 2);
        }
    }

}
