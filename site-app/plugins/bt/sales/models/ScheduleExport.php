<?php

namespace Bt\Sales\Models;

use Backend\Models\ExportModel;
use Carbon\Carbon;
use Session;
class ScheduleExport extends ExportModel
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_delivery_plans';

    public $hasOne = [
    ];
    public $hasMany = [
        'items' => ['Bt\Sales\Models\DeliveryItem','key'=>'plan_id'],
        'itemscat' => ['Bt\Sales\Models\Deliverycatalogue','key'=>'plan_id'],
    ];
    public $belongsTo = [
        'client' => ['Bt\Sales\Models\Client','key'=>'client_id','order'=>'company_name'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id',],
        'invoice' => ['Bt\Sales\Models\Invoice','key'=>'invoice_id'],
        'type' => ['Bt\Sales\Models\DeliveryType','key'=>'type_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];

    public $appends = [
        'clientname',
        'invoiceno',
        'typename',
        'createdbyname',
        'updatedbyname',
        'ponumbername'
    ];
    public function exportData($columns, $sessionKey = null){
        $query = self::make();
        if(Session::has('schedulestart') && Session::get('schedulestart') > 0){
            return $query->whereBetween('schedule_date', [Session::get('schedulestart'), Session::get('scheduleend')])->orderBy('id','desc')->get()->toArray();
        }else{
            $starter = Carbon::now()->subDays(30);
            $ender = Carbon::now();
            return $query->whereBetween('created_at',[$starter, $ender])->orderBy('id','desc')->get()->toArray();
        }
    }

    public function getClientnameAttribute(){
        if(!empty($this->quote)){
            return $this->quote->company_name;
        }
    }

    public function getInvoicenoAttribute(){
        if(!empty($this->quote->invoice)){
           return 'Yes';
        }else{
            return 'No';
        }
    }

    public function getTypenameAttribute(){
        if(!empty($this->type)){
            return $this->type->name;
        }
    }
    public function getCreatedbynameAttribute(){
        if(isset($this->createdby->first_name)){
            return $this->createdby->first_name . " " . $this->createdby->last_name;
        }
    }

    public function getUpdatedbynameAttribute(){
        if(isset($this->updatedby->first_name)){
            return $this->updatedby->first_name . " " . $this->updatedby->last_name;
        }
    }
    public function getPonumbernameAttribute(){
        if(!empty($this->quote)){
            return $this->quote->ponumber;
        }
    }
}
