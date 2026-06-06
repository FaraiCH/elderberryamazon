<?php


namespace Bt\Production\Models;

use Backend\Models\ExportModel;
use Backend\Models\User;
use Bt\Sales\Models\Newquote;
use Bt\Sales\Models\Product;
use function Matrix\trace;

class PushExport extends ExportModel
{
    public $table = 'bt_production_pushes';
    public $hasOne = [
        'approved' => ['Bt\Production\Models\Pushapprove','key'=>'push_id'],
    ];
    public $hasMany = [
        'pipes' => ['Bt\Production\Models\Pipe','key'=>'push_id'],
        'productiondelay' => ['Bt\Production\Models\ProductionDelay','key'=>'push_id'],
    ];
    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id'],
        'status' => ['Bt\Production\Models\Status','key'=>'status_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    protected $appends = [

        'quote_no',
        'client',
        'progress',
        'delivery',
        'invoiced',
        'payment',
        'status',
        'updated_by',
        'created_by'
    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }

    public function getQuoteNoAttribute()
    {
        $quote = Newquote::find($this->quote->id);
        return $quote->id;
    }
    public function getClientAttribute()
    {
        if (!empty($this->quote->company_name)) {
            return $this->quote->company_name;
        }
    }

    public function getProgressAttribute()
    {

        $count = 0;
        foreach ($this->quote->items as $key => $value) {
            if (!empty($value->product_id)) {
                $product = Product::find($value->product_id);
                if (isset($product)) {
                    if ($product->value > 0 && $value->unitlength > 0) {
                        $count = $count + $value->units;
                    }
                }
            }
        }

        $vs = 0;
        $mypush = Push::find($this->id);

        foreach ($mypush->pipes as $pkey) {
            if (isset($pkey->schedules)) {
                $vs = $vs + $pkey->schedules()->sum('total_units_passed_qc');
            }
        }

        if ($count == 0) {
            return 0 . "%";
        } else {
            $per = 0;
            if ($vs > 0) {
                $per = ($vs/$count) * 100;
            }
            if ($per > 100) {
                $per = 100;
            }

            if ($this->status_id == 3) {
                $per = 100;
            }
        }

        return number_format($per, 0). "%";
    }

    public function getDeliveryAttribute()
    {
        $count = 0;
        foreach ($this->quote->items as $key => $value) {
            if (!empty($value->product_id)) {
                $product = Product::find($value->product_id);
                if (isset($product)) {
                    if ($product->value > 0 && $value->unitlength > 0) {
                        $count = $count + $value->units;
                    }
                }
            }
        }

        $vs = 0;
        if (isset($this->quote)) {
            if (isset($this->quote->srn)) {
                foreach ($this->quote->srn as $pkey => $pvalue) {
                    if (isset($pvalue->items)) {
                        $vs = $vs + $pvalue->items()->sum('units');
                    }
                }
            }
        }
        if ($count == 0) {
            return 0 . "%";
        } else {
            $per = 0;
            if ($vs > 0) {
                $per = ($vs/$count) * 100;
            }
            if ($per > 100) {
                $per = 100;
            }

            if ($this->status_id == 3) {
                $per = 100;
            }
        }

        return number_format($per, 0). "%";
    }

    public function getInvoicedAttribute()
    {
        $total = $this->quote->totalincvat;
        $amount = $this->quote->invoice()->sum('amount');

        $per = ($amount/$total) * 100;
        if ($per > 100) {
            $per = 100;
        }
        return number_format($per, 0). "%";
    }

    public function getPaymentAttribute()
    {
        $total = $this->quote->totalincvat;
        $amount = $this->quote->paymenttracker()->sum('amount');
        $per = ($amount/$total) * 100;
        if ($per > 100) {
            $per = 100;
        }
        return number_format($per, 0). "%";
    }

    public function getStatusAttribute()
    {
        $push = Push::find($this->id);
        if ($push->status->id == 1) {
            return $push->status->name;
        } elseif ($push->status->id == 2) {
            return $push->status->name;
        } elseif ($push->status->id == 3) {
            return $push->status->name;
        } elseif ($push->status->id == 4) {
            return $push->status->name;
        }
    }

    public function getCreatedByAttribute()
    {
        $push = Push::find($this->id);
        $user = User::find($push->created_by);
        if (!empty(isset($user))) {
            return $user->first_name . " " . $user->last_name;
        }
    }
    public function getUpdatedByAttribute()
    {
        $push = Push::find($this->id);
        $user = User::find($push->updated_by);
        if (!empty(isset($user))) {
            return $user->first_name . " " . $user->last_name;
        }
    }
}
