<?php

namespace Bt\Sales\Models;

use Backend\Models\ExportModel;
use Carbon\Carbon;
use Session;
class QuoteExport extends ExportModel
{
    public $table = 'bt_sales_newquote';

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
    public $hasOne = [
        'qpush' => ['Bt\Production\Models\Push','key'=>'quote_id'],
    ];
    public $hasMany = [
        'pickslip' => ['Bt\Sales\Models\Pickslip','key'=>'quote_id'],
        'invoice' => ['Bt\Sales\Models\Invoice','key'=>'quote_id'],
        'requestqc' => ['Bt\QC\Models\Reqcertificate', 'key' => 'quote_id'],
        'paymenttracker' => ['Bt\Sales\Models\PaymentTracker','key'=>'quote_id'],
        'srn' => ['Bt\Sales\Models\Srn','key'=>'quote_id'],
        'items' => ['Bt\Sales\Models\Quoteitems','key'=>'quote_id'],
        'itemscat' => ['Bt\Sales\Models\QuoteItemCatalogue','key'=>'quote_id'],
        'emails' => ['Bt\Sales\Models\QuoteEmail','key'=>'quote_id'],
        'responses' => ['Bt\Sales\Models\QuoteReponse','key'=>'quote_id'],
        'productionplan' => ['Bt\Sales\Models\QuoteProductionPlan','key'=>'quote_id'],
        'dispatch' => ['Bt\Sales\Models\DispatchItem', 'key' => 'quote_id'],
    ];
    public $belongsTo = [
        'client' => ['Bt\Sales\Models\Client','key'=>'client_id', 'order'=>'company_name asc'],
        'status' => ['Bt\Sales\Models\QuoteStatus','key'=>'quote_status_id'],
        'isactive' => ['Bt\Maintenance\Models\YesNo','key'=>'active'],
        'reason' => ['Bt\Sales\Models\ReasonForQuote','key'=>'reason_for_quote_id'],
        'nonreceived' => ['Bt\Sales\Models\ReceivedNonReceived','key'=>'received_non_received_order_id'],
        'user' => 'RainLab\User\Models\User',
        'deliverytype' => ['Bt\Sales\Models\DeliveryType']
    ];

    public $appends = [
        "client_name",
        "active_name",
        "status_name",
        "production_name",
        "user_name",
        "paymenttracker_name",
        "reason_name",
        "nonreceived_name",
        "randperkg",
        "show_invoiced",
        "transport_cost",
        "destination",
        "km",
        "intend_weight",
        "trip_qty",
        "rate"

    ];

    public function exportData($columns, $sessionKey = null){
        $query = self::make();
        if(Session::has('quotestart') && Session::get('quotestart') > 0){
            return $query->whereBetween('created_at', [Session::get('quotestart'), Session::get('quoteend')])->orderBy('id','desc')->get()->toArray();
        }else{
            $starter = Carbon::now()->subDays(30);
            $ender = Carbon::now();
            return $query->whereBetween('created_at',[$starter, $ender])->orderBy('id','desc')->get()->toArray();
        }
    }

    public function getClientNameAttribute(){
        if(!empty($this->client))
            return $this->company_name;
    }

    public function getActiveNameAttribute(){
        if($this->active == 1){
             return 'Active';
        }else{
            return 'No';
        }
    }
    public function getStatusNameAttribute(){
        if(!empty($this->status))
            return $this->status->name;
    }
    public function getProductionNameAttribute(){
        if(!empty($this->qpush)) {
            if (isset($this->qpush->status) && $this->qpush->status) {
                if($this->qpush->status->id == 1) {
                    return $this->qpush->status->name;
                } elseif ($this->qpush->status->id == 2) {
                    return $this->qpush->status->name;
                } elseif ($this->qpush->status->id == 3) {
                    return $this->qpush->status->name;
                } elseif ($this->qpush->status->id == 4) {
                    return $this->qpush->status->name;
                } else {
                    return $this->qpush->status->name;
                }
            }
        }

    }
    public function getUserNameAttribute(){
        if(!empty($this->user))
            return $this->user->name;
    }
    public function getPaymenttrackerNameAttribute(){
         if(!empty($this->paymenttracker)){
	        return number_format($this->paymenttracker->sum('amount'),2, '.', ',');
        }
	}
    public function getReasonNameAttribute(){
        if(!empty($this->reason))
          return $this->reason->name;
    }
    public function getNonreceivedNameAttribute(){
        if(!empty($this->nonreceived))
            return $this->nonreceived->name;
    }

    public function getRandperkgAttribute(){
        $randperkg =  $this->items->pluck("priceperkg")->first();
        if(!empty($randperkg)){
            return $randperkg;
        }else{
            $randperkg = $this->itemscat->pluck("priceperkg")->first();
            if(!empty($randperkg)){
                return $randperkg;
            }
        }

    }

    public function getShowInvoicedAttribute(){
        if(!empty($this->invoice))
            return $this->invoice->sum('amount');
        else
            return 0;
    }
    public function getTransportCostAttribute()
    {
        $total = 0;
        if (isset($this->deliveryamounthidden))
        {
            if($this->deliveryamounthidden > 0)
            {
                $total += $this->deliveryamounthidden;
            }
        }
        if (isset($this->deliveryamount))
        {
            if($this->deliveryamount > 0)
            {
                $total += $this->deliveryamount;
            }
        }
        if(!empty($this->dispatch))
        {
            if($this->dispatch->sum('total') > 0)
            {

                $total = $this->dispatch->sum('total');
            }
        }
        return $total;
    }

    public function getDestinationAttribute()
    {
        $arrDestination = [];

        if(!empty($this->dispatch))
        {
            foreach ($this->dispatch as $dispatch)
            {
                $arrDestination[$dispatch->id] = $dispatch->destination->name;
            }
        }

        return implode(',', $arrDestination);
    }

    public function getKmAttribute()
    {
        $arrDestination = [];

        if(!empty($this->dispatch))
        {
            foreach ($this->dispatch as $dispatch)
            {
                $arrDestination[$dispatch->id] = $dispatch->destination->kilometers;
            }
        }

        return implode(',', $arrDestination);
    }

    public function getIntendWeightAttribute()
    {
        return optional($this->dispatch)->sum('vihicle_load_weight') ?? 0;
    }

    public function getTripQtyAttribute()
    {
        return optional($this->dispatch)->sum('qty') ?? 0;
    }

    public function getRateAttribute()
    {
        return number_format(optional($this->dispatch)->sum('rate_per_transport') ?? 0, 2);
    }
}
