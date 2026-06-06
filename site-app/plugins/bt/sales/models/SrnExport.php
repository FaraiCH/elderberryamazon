<?php namespace Bt\Sales\Models;

use Backend\Models\User;
use Bt\Sales\Controllers\Srn as SrnController;
use Carbon\Carbon;
use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Sales\Models\Srn;
use \Bt\Sales\Models\Invoice;

class SrnExport extends ExportModel
{

    /**
     * @var array Fillable fields
     */

    public $table = 'bt_sales_srns';

    public $hasOne = [
        'srnapprove' => ['Bt\Sales\Models\Srnapprove','key'=>'srn_id'],
        'srnpayment'=>['Bt\Sales\Models\SrnPayment','key'=>'srn_id'],
    ];

    public $hasMany = [
        'srninvoice' => ['Bt\Sales\Models\Invoice','key'=>'srn_id'],
        'items' => ['Bt\Sales\Models\SrnItem','key'=>'srn_id'],
        'itemscat' => ['Bt\Sales\Models\SrnCatalogue','key'=>'srn_id'],
        'returnnote' => ['Bt\Sales\Models\ReturnNote','key'=>'srn_id','order'=>'id desc'],
    ];

    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'type' => ['Bt\Sales\Models\DeliveryType','key'=>'type_id'],
        'client' => ['Bt\Sales\Models\Client','key'=>'client_id'],
        'linkaltinvoice' => ['Bt\Sales\Models\Invoice','key'=>'altinvoice'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];

    protected $appends = [
        'quote_name',
        'doc_status',
        'type_name',
        'client_name',
        'invoice_name',
        'linkaltinvoice_name',
        'updated_by_name',
        'created_by_name',
        'srnapprove_name',
        'ponumber_name',
        'active_name',
        'invoiceqt_name',
        'client2_name',
        'client3_name',
        'items_name',
        'stock_value',
        'stock_weight',
        'stock_value_cat',
        'amount',
        'amount_invoiced',
        'delivery_request',
        'srn_pay',
        'srn_logistics',
        'logistic_invoice',
        'deliveryamounthidden',
        'deliveryamount',
        'additionalamount'

    ];

    public $attachMany = [
        'files_srn' => 'System\Models\File',
        'qc_srn' => 'System\Models\File',
        'files_delivery' => 'System\Models\File',
        'files_collection' => 'System\Models\File',
        'images_weight_bridge' => 'System\Models\File',
        'images_delivery' => 'System\Models\File',
        'images_collection' => 'System\Models\File',

    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        if (!empty($_SESSION['startsrn'])) {
            $datePeriod = [$_SESSION['startsrn'], $_SESSION['endsrn']];
            return $query->whereBetween('created_at', $datePeriod)->orderBy('id', 'desc')->get()->toArray();
        } else {
            $starter = Carbon::now()->subDays(30);
            $ender = Carbon::now();
            return $query->whereBetween('created_at', [$starter, $ender])->orderBy('id', 'desc')->get()->toArray();
        }
    }

    public function getCreatedByNameAttribute()
    {
        $user = $this->createdby;
        if (!empty(isset($user))) {
            return $user->first_name . " " . $user->last_name;
        }
    }
    public function getUpdatedByNameAttribute()
    {
        $user = $this->updatedby;
        if (!empty(isset($user))) {
            return $user->first_name . " " . $user->last_name;
        }
    }
    public function getQuoteNameAttribute()
    {
        if (!empty(isset($this->quote))) {
            return $this->quote->id;
        }
    }
    public function getTypeNameAttribute()
    {
        if (!empty(isset($this->type))) {
            return $this->type->name;
        }
    }

    public function getClientNameAttribute()
    {
        if (!empty(isset($this->client))) {
            return $this->client->company_name;
        }
    }

    public function getInvoiceNameAttribute()
    {
        $allinv = null;
        if (!empty($this->srninvoice)) {
            foreach ($this->srninvoice as $invoice) {
                $allinv .= $invoice->name. " ";
            }
        }
        return $allinv;
    }
    public function getLinkaltinvoiceNameAttribute()
    {
        $newArray = null;
        if (isset($this->quote->invoice) && count($this->quote->invoice) > 0) {
            $inv = array();

            foreach ($this->quote->invoice as $value) {
                $inv[] = $value->name;
            }
            $newArray =  implode(", ", $inv);
        }
        return $newArray;
    }
    public function getSrnapproveNameAttribute()
    {
        if (!empty(isset($this->srnapprove)) && $this->srnapprove->status_id == 1) {
            return 'Yes';
        }
        return 'No';
    }
    public function getPonumberNameAttribute()
    {
        if (!empty(isset($this->quote))) {
            return $this->quote->ponumber;
        }
    }

    public function getActiveNameAttribute()
    {
        if ($this->active == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public function getInvoiceqtNameAttribute()
    {
        if ($this->srninvoice->sum('id') > 0) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public function getDocStatusAttribute()
    {
        $srn = Srn::find($this->id);
        $doccount = 0;
        if ($srn->files_srn->count() > 0) {
            $doccount++;
        }
        if ($srn->files_delivery->count() > 0) {
            $doccount++;
        }

        if ($srn->files_collection->count() > 0) {
            $doccount++;
        }

        if ($doccount >= 1) {
            return 'COMPLETED';
        } else {
            return 'INCOMPLETE';
        }
    }

    public function getClient3NameAttribute()
    {
        return $this->client->contact_name . ' '. $this->client->contact_email;
    }

    public function getClient2NameAttribute()
    {
        return $this->client->contact_name;
    }

    public function getItemsNameAttribute()
    {
        return $this->items->count();
    }

    public function getStockValueAttribute()
    {
        return number_format($this->items->sum('stockvalue'), 2, '.', '');
    }

    public function getStockWeightAttribute()
    {
        return number_format($this->items->sum('stockweight'), 2, '.', '') . 'kg';
    }

    public function getStockValueCatAttribute()
    {
        return number_format($this->itemscat->sum('stockvalue'), 2, '.', '');
    }

    public function getAmountAttribute()
    {
        $itemamount = $this->srninvoice()->sum('amount');
        return number_format($itemamount, 2, '.', '');
    }
    public function getAmountInvoicedAttribute()
    {
        $itemsvalue = $this->items->sum('stockvalue') + $this->itemscat->sum('stockvalue');
        return number_format(($itemsvalue) + (($itemsvalue) * 0.15), 2, '.', '');
    }

    public function getDeliveryRequestAttribute()
    {
        if (!empty($this->quote->responses->where('quote_status_id', 3)->first())) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
    public function getDeliveryamounthiddenAttribute()
    {
        if (isset($this->quote->deliveryamounthidden)) {
            if($this->quote->deliveryamounthidden > 0)
            {
                return number_format($this->quote->deliveryamounthidden, 2, '.', '');
            }
        }

        if($this->quote->dispatch->where('hide', 1)->sum('total') > 0)
        {
            return $this->quote->dispatch->where('hide', 1)->sum('total');
        }
    }
    public function getSrnPayAttribute()
    {
        if (isset($this->srnpayment->supplier_amount)) {
            return number_format($this->srnpayment->supplier_amount, 2, '.', '');
        }
    }

    public function getSrnLogisticsAttribute()
    {
        if (isset($this->srnpayment->logistic_company_name)) {
            return $this->srnpayment->logistic_company_name;
        }
    }

    public function getLogisticInvoiceAttribute()
    {
        if (isset($this->srnpayment->logistic_invoice_number)) {
            return $this->srnpayment->logistic_invoice_number;
        }
    }

    public function getDeliveryamountAttribute()
    {
        if (isset($this->quote->deliveryamount)) {
            if($this->quote->deliveryamount > 0)
            {
                return number_format($this->quote->deliveryamount, 2, '.', '');
            }
        }

        if($this->quote->dispatch->where('hide', 0)->sum('total') > 0)
        {
            return $this->quote->dispatch->where('hide', 0)->sum('total');
        }
    }

    public function getAdditionalamountAttribute()
    {
        if (!empty($this->quote->responses->where('quote_status_id', 4)->first())) {
            return $this->quote->responses->where('quote_status_id', 4)->first()->additionalamount;
        } else {
            return 0;
        }

    }
}
