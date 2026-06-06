<?php namespace Bt\Sales\Models;

use Bt\Documents\Models\User;
use Bt\HR\Models\Employee;
use Bt\Sales\Models\DeliveryPlan;
use Carbon\Carbon;
use Model;
use BackendAuth;
use Bt\Sales\Models\Invoice;
use Bt\Production\Models\Push as PushModel;
use Bt\Sales\Controllers\Srn as SrnController;
use Bt\Sales\Models\StockOrder as StockOrderModel;

/**
 * Srn Model
 */
class Srn extends Model

{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_srns';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'quote'                  => 'required',
        'schedule_date' => 'required',
        'client' => 'required',
        'type' => 'required',
        'pickslip' => 'required',
    ];


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['id'];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'srnapprove' => ['Bt\Sales\Models\Srnapprove','key'=>'srn_id'],
        'logisticsignature' => ['Bt\Sales\Models\Logisticsignature','key'=>'srn_id'],
        'clientsignature' => ['Bt\Sales\Models\Clientsignature','key'=>'srn_id'],
        'srnpayment'=>['Bt\Sales\Models\SrnPayment','key'=>'srn_id'],

    ];
    public $hasMany = [
        'srninvoice' => ['Bt\Sales\Models\Invoice','key'=>'srn_id'],
        'items' => ['Bt\Sales\Models\SrnItem','key'=>'srn_id'],
        'stickeritems' => ['Bt\Production\Models\Pipestickeritem','key'=>'srn_id'],
        'itemscat' => ['Bt\Sales\Models\SrnCatalogue','key'=>'srn_id'],
        'returnnote' => ['Bt\Sales\Models\ReturnNote','key'=>'srn_id','order'=>'id desc'],
        'requestunapprove' => ['Bt\Sales\Models\RequestUnapproveSrn','key'=>'srn_id','order'=>'id desc'],


    ];
    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'type' => ['Bt\Sales\Models\DeliveryType','key'=>'type_id'],
        'schedule' => ['Bt\Sales\Models\DeliveryPlan','key'=>'linkschedule_id'],
        'client' => ['Bt\Sales\Models\Client','key'=>'client_id'],
        'linkaltinvoice' => ['Bt\Sales\Models\Invoice','key'=>'altinvoice'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'pickslip' => ['Bt\Sales\Models\Pickslip', 'key' => 'pickslip_id' ],
        'vehicle' =>   ['Bt\Maintenance\Models\Vehicle'],
        'trip_sheet' => ['Bt\Sales\Models\TripSheet'],
        'stock_order' => ['Bt\Sales\Models\StockOrder','key'=>'stock_order_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'files_srn' => 'System\Models\File',
        'qc_srn' => 'System\Models\File',
        'files_delivery' => 'System\Models\File',
        'files_collection' => 'System\Models\File',
        'images_weight_bridge' => 'System\Models\File',
        'images_delivery' => 'System\Models\File',
        'images_collection' => 'System\Models\File',

    ];
    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
        if($this->emailedtofinance != 1 && $this->active){

            $c = new SrnController();
            $c->onSendNotificationReturnNote($this->id);
            $this->emailedtofinance = 1;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFabrication($query)
    {
        return $query->where('fabrication', 0);
    }
    public function scopeReporting($query)
    {
        return $query->where('reporting', 1);
    }
    public static $fabrication = array(0=>"No", 1=>'Yes');
    public function getFabricationOptions()
    {
        return self::$fabrication;
    }

    public function listInvoiceitems($fieldName, $value, $formData)
    {
        $i =  PushModel::all();

        $arrayName = array();
        foreach ($i as $key_ => $value_) {
            if(!empty($value_->quote)){
                if($value_->quote->invoice){
                    $arrayName[$value_->quote->invoice->id] = $value_->quote->invoice->name." - ".$value_->quote->company_name;
                }
            }
        }

        return $arrayName;
    }


    public function getScheduleOptions(){
        $arrayName = array();


        if(isset($this->quote->id)){
            $obj =DeliveryPlan::where('quote_id', $this->quote->id)->orderby("schedule_date",'desc')->get();
            foreach ($obj as $key => $value) {
                $arrayName[$value->id] = $value->id.' # '.$value->client->company_name.' # '.$value->schedule_date." By ".$value->createdby->first_name.' '.$value->createdby->last_name;
            }
        }
        return $arrayName;
    }

    public function filterFields($fields, $context = null)
    {
        if($context == 'update'){
            if($this->items->sum('units') > 0 || $this->itemscat->sum('units') > 0) {
                if(isset($fields->quote)){
                    $fields->quote->disabled = true;
                    $fields->pickslip->disabled = true;
                }
            }else{
                if(isset($fields->quote)){
                    $fields->quote->disabled = false;
                    $fields->pickslip->disabled = false;
                }
            }
        }

        if(isset($fields->schedule->value)){
            $obj =DeliveryPlan::find($fields->schedule->value);
            if(!empty($obj)){
                $fields->delivery_address->value = $obj->address;
                $fields->notes_delivery->value = $obj->notes;
                $fields->schedule_date->value = $obj->schedule_date;
                $fields->client->value = $obj->client->id;
                $fields->type->value = $obj->type->id;
                $fields->quote->value = $obj->quote->id;

            }
        }

        if($this->type_id == 1){
            if(isset($fields->stops)) {
                $fields->stops->hidden = false;
                $fields->trip_sheet->hidden = false;
            }
        }else{
            if(isset($fields->stops)){
                $fields->stops->hidden = true;
                $fields->trip_sheet->hidden = true;
            }
        }
    }
    public function getPickslipOptions()
    {
        $allpick = array();

        if(isset($this->quote->id)){
            $pickobj = \Bt\Sales\Models\Pickslip::where("quote_id",$this->quote->id)->get();


            if(!empty($pickobj)){
                foreach ($pickobj as $pick)
                {
                    if(isset($pick->quote->company_name) && !empty($pick->quote->company_name)){

                        $allpick[$pick->id] = $pick->id . " > " . $pick->quote_id . "  " . $pick->quote->company_name;
                    }

                }
            }

        }
        return $allpick;
    }

    public function getFabrication(){
        return $this->fabrication;
    }

    public function getQuoteOptions(){


        $quoteObj = array();

        if(isset($this->type->id)){
            $quotes = Newquote::where('deliverytype_id', $this->type->id)->orderBy('id', 'desc')->get();
            foreach ($quotes as $quote){
                $quoteObj[$quote->id] = $quote->id . ' ' . $quote->company_name;
            }
        }

        return $quoteObj;
    }

    public function getStopsOptions(){
        return [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10];
    }

    public function getTripSheetOptions(){
        $trips = TripSheet::orderBy('id', 'desc')->get();

        $tripObj = array();

        foreach ($trips as $trip){
            $tripObj[$trip->id] = $trip->id . ' > Driver Name: ' . $trip->driver_name . ' > Vehicle Reg Number: ' . $trip->truck_reg_number . ' > Transporter: ' . $trip->transporter;
        }
        return $tripObj;
    }
    public function beforeValidate()
    {
        if(($this->created_at > '2023-08-24') || empty($this->created_at))  {
            if($this->type_id == 1){
                $this->rules['stops'] = [
                    'required'
                ];
                $this->rules['trip_sheet'] = [
                    'required'
                ];
            }
            if($this->type_id == 1){
                $this->rules['schedule'] = [
                    'required'
                ];
            }
        }
    }

    public function getStockOrderOptions() {
        // return StockOrderModel::all()->map(function($item) {
        //     return $item->quote->company_name . '; ' . 'Deadline date: ' . $item->deadline_date;
        });

        $arrObj = [];

        $stockorders = StockOrderModel::where('quote_id', $this->quote_id)->get();
        if(!empty($stockorders)){
            foreach($stockorders as $stockorder){
                $arrObj[$stockorder->id] = $stockorder->quote->company_name . '; ' . 'Deadline date: ' . $stockorder->deadline_date;
            }
        }
        return $arrObj;
    }
}
