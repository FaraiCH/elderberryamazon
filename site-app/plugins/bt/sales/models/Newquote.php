<?php

namespace Bt\Sales\Models;

use Bt\Sales\Classes\SalesPrice;
use Model;
use Validator;
use ValidationException;
use BackendAuth;
use Hash;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\QuoteApprovalIntro;

/**
 * newqoute Model
 */
class Newquote extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_newquote';
    public $rules = [];
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
        'accept' => ['Bt\Sales\Models\QuoteAccept','key'=>'quote_id'],
        'quoteapproval' => ['Bt\Sales\Models\QuoteApproval','key'=>'quote_id'],
        'quote_approval_intro' => ['Bt\Sales\Models\QuoteApprovalIntro', 'key' => 'quote_id'],
    ];

    public $hasMany = [
        'pickslip' => ['Bt\Sales\Models\Pickslip', 'key' => 'quote_id'],
        'invoice' => ['Bt\Sales\Models\Invoice', 'key' => 'quote_id'],
        'requestqc' => ['Bt\QC\Models\Reqcertificate', 'key' => 'quote_id'],
        'paymenttracker' => ['Bt\Sales\Models\PaymentTracker', 'key' => 'quote_id'],
        'srn' => ['Bt\Sales\Models\Srn', 'key' => 'quote_id'],
        'items' => ['Bt\Sales\Models\Quoteitems', 'key' => 'quote_id'],
        'itemscat' => ['Bt\Sales\Models\QuoteItemCatalogue', 'key' => 'quote_id'],
        'emails' => ['Bt\Sales\Models\QuoteEmail', 'key' => 'quote_id'],
        'responses' => ['Bt\Sales\Models\QuoteReponse', 'key' => 'quote_id'],
        'productionplan' => ['Bt\Sales\Models\QuoteProductionPlan', 'key' => 'quote_id'],
        'dispatch' => ['Bt\Sales\Models\DispatchItem', 'key' => 'quote_id'],
        'quote_approval_activity_log' => ['Bt\Sales\Models\QuoteApprovalActivityLog', 'key' => 'quote_id'],
    ];

    public $belongsTo = [
        'client' => ['Bt\Sales\Models\Client', 'key' => 'client_id', 'order' => 'company_name asc'],
        'status' => ['Bt\Sales\Models\QuoteStatus', 'key' => 'quote_status_id'],
        'isactive' => ['Bt\Maintenance\Models\YesNo', 'key' => 'active'],
        'reason' => ['Bt\Sales\Models\ReasonForQuote', 'key' => 'reason_for_quote_id'],
        'nonreceived' => ['Bt\Sales\Models\ReceivedNonReceived', 'key' => 'received_non_received_order_id'],
        'user' => 'RainLab\User\Models\User',
        'deliverytype' => ['Bt\Sales\Models\DeliveryType']
    ];

    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public $morphToMany = [
        'pipesdeliver'  => [
            'Bt\Production\Models\Pipe',
            'table' => 'tbl_association',
            'name' => 'tbl_association',
            'key' => 'tbl_association__id',
            'otherKey' => 'association__id',
        ],
    ];

    public function beforeSave()
    {
//        if ($this->deliveryrequest > 0) {
//            if (($this->deliveryamounthidden == 0) && ($this->deliveryamount == 0)) {
//                $rules = [
//                    'deliveryamount' => 'required',
//                ];
//                $validation = Validator::make(post(), $rules);
//                if ($validation->fails()) {
//                    throw new ValidationException($validation);
//                }
//            }
//        }
    }

    public function beforeCreate()
    {
        $initial = Hash::make($this->id . '' . $this->company_name);
        $pattern = '/\//';
        $pattern2 = '/\$/';
        $replacement = '';
        $removedash = preg_replace($pattern, $replacement, $initial);
        $removedoller = preg_replace($pattern2, '', $removedash);
        $this->key_pass = $removedoller;
    }

    public function beforeUpdate()
    {
        // $initial = Hash::make($this->id . ''.$this->created_by);
        // $pattern = '/\//';
        // $pattern2 = '/\$/';
        // $replacement = '';
        // $removedash = preg_replace($pattern, $replacement, $initial);
        // $removedoller = preg_replace($pattern2, '', $removedash);
        // if (!isset($this->key_pass)) {
        //     $this->key_pass = $removedoller;
        // }
        // $user = BackendAuth::getUser();
        if (!$user) return;
        // if (isset($user->id)) {
        //     $this->user_id = $user->id;
        // }
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function fixTotal()
    {
        $iPrice = (!empty($this->items) ? $this->items->sum('price') : 0);
        $cPrice = (!empty($this->itemscat) ? $this->itemscat->sum('price') : 0);
        $discount = 0;
        $total_of_order = 0;
        foreach ($this->responses as $response) {
            if (!empty($response->status) && $response->status->id == 6) {
                $discount = $response->amountdiscount;
            }
        }
        if($this->deliveryamount > 0)
            $total = $iPrice + $cPrice + floatval($this->deliveryamount);
        else{
            if($this->items->count() > 0){
                foreach($this->items as $item){
                    $total_of_order += ($item->priceperkg + $this->dispatch->where('hide', 1)->sum('rate_per_transport')) * $item->totalweight;
                }
            }
            $total = $total_of_order + $cPrice + $this->dispatch->where('hide', 0)->sum('total');
        }

        $this->total = floatval($total);
        $this->totalvat = floatval($total * $this->vat);
        $this->totalincvat = $total + floatval($total * $this->vat) - $discount;
        $this->save();
    }



    public function FilterByQuote($query, $filter)
    {

        return [];
        return $query->whereHas('employee', function ($group) use ($filter) {
            $group->whereIn('department_id', $filter);
        });
    }

    public function getQuotes()
    {
        $quotes = ModelNewquote::whereNotNull("ponumber")->orderBy('id', 'desc')->get();
        $result = [];

        foreach ($quotes as $quote) {
            $result[$quote->id] = $quote->id . " - " . $quote->company_name;
        }

        return $result;
    }

    public function getProductionStatusAttribute(): string
    {
        if(!empty($this->responses->where('quote_status_id', 14)->first()->status->name)){
            $productionStatus = optional($this->responses->where('quote_status_id', 14)->first()->status)->name ?: '';
        }else{
            $productionStatus = 'Not In Production';
        }

        $productionAproval = optional(optional($this->qpush)->approved)->status_id ? ($this->qpush->approved->status_id === 1 ? 'Approved' : 'Declined') : 'Pending';

        if($productionStatus === 'In Production' && $productionAproval === 'Pending') {
            return 'In Production';
        }

        return $productionStatus;
    }

    public function getProductionAprovalAttribute(): string
    {
        if(!empty($this->responses->last()->status->name)){
            $productionStatus = optional($this->responses->last()->status)->name ?: '';
        }else{
            $productionStatus = '';
        }

        $productionAproval = optional(optional($this->qpush)->approved)->status_id ? ($this->qpush->approved->status_id === 1 ? 'Approved' : 'Declined') : 'Pending';

        if($productionStatus === 'Production Completed' && $productionAproval === 'Pending') {
            return 'Stock Pipes';
        }
        return $productionAproval;
    }

    public function getTotalKgProcessedAttribute(): int
    {
        return optional(optional($this)->qpush)->totalKgProcessed ?: 0;
    }

    public function getTotalPipeUnitsAttribute(): int
    {
        return optional(optional($this)->qpush)->totalPipeUnits ?: 0;
    }

    public function getShowInvoicedAttribute(){
        return 'R' . ' ' . $this->invoice->sum('amount');
    }

    public function getPONumberOptions(){
        $poOBJ = array();
        $quotes = self::whereNotNull('ponumber')->pluck('ponumber')->unique()->toArray();
        foreach ($quotes as $po) {
            $poOBJ[$po] = $po;
        }
        return $poOBJ;
    }

    public function getCashUpFront()
    {
        $cash_rate = 31.50;
        return SalesPrice::upFrontDiscount($this, $cash_rate);
    }

    public function getDeliveredKg($quote)
    {
        $total = 0;
        $srns = Srn::where('quote_id', $quote)->with(['items'])->get(['id']);

        if(!empty($srns))
        {
            foreach ($srns as $srn)
            {
                $total += $srn->items->sum('stockweight');
            }
        }

        return $total;
    }
    public function getBuyOutsDelivered($quote)
    {
        $total = 0;
        $srns = Srn::where('quote_id', $quote)->with(['itemscat'])->get(['id']);

        if(!empty($srns))
        {
            foreach ($srns as $srn)
            {
                $total += optional($srn->itemscat)->sum('units')?:0;
            }
        }

        return $total;
    }
}
