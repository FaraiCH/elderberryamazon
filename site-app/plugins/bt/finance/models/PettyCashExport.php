<?php


namespace Bt\Finance\Models;

use Backend\Models\ExportModel;
use RainLab\User\Models\User;

class PettyCashExport extends ExportModel
{
    public $table = 'bt_finance_petty_cashes';

    public $hasOne = [
        'pettycashapprove' => ['Bt\Finance\Models\PettyCashApprove','key'=>'pettycash_id'],
    ];
    public $hasMany = [
        'cardrecords'=>['Bt\Finance\Models\CardRecords','key'=>'pettycash_id'],
    ];
    public $belongsTo = [
        'requestby' =>['Backend\Models\User','key'=>'requestedby_id','other'=>'id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'approvedby' => ['RainLab\User\Models\User','key'=>'approvedby_id','other'=>'id'],
        'requestedtomanager' => ['RainLab\User\Models\User','key'=>'requested_to','other'=>'id'],
        'paymenttype' =>['Bt\Finance\Models\PaymentType','key'=>'paymenttype_id'],
        'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'slips' => 'System\Models\File',
    ];
    public $appends = [
        'uploader',
        'reqer',
        'request_to_j',
        'completed',
        'approved',
        'payment_type',
        'createby',
        'updateby'
    ];
    public function exportData($columns, $sessionKey = null)
    {
        $startdate = null;
        $enddate = null;
        $query = self::make();
        if (isset($_SESSION['starter'])) {
            $startdate = $_SESSION['starter'];
            $enddate = $_SESSION['ender'];
            return $query->where('cancel', 0)->whereBetween('created_at', array($startdate, $enddate))->orderBy('id', 'desc')->get()->toArray();
        } else {
            return $query->orderBy('id', 'desc')->get()->toArray();
        }
    }

    public function getUploaderAttribute()
    {
        $count = 0;
        foreach ($this->cardrecords as $card) {
            if (isset($card->slips)) {
                $count += $card->slips->count();
            }
        }
        return $count;
    }

    public function getReqerAttribute()
    {
        $count = 0;
        foreach ($this->cardrecords as $card) {
            if (isset($card->signed_requisition)) {
                $count += 1;
            }
        }
        return $count;
    }

    public function getRequestToJAttribute()
    {
        if (isset($this->requestedtomanager->name)) {
            return $this->requestedtomanager->name . ' ' . $this->requestedtomanager->surname;
        } else {
            return null;
        }
    }

    public function getPaymentTypeAttribute()
    {
        $pay = PaymentType::find($this->paymenttype_id);
        return $pay->name;
    }
    public function getCompletedAttribute()
    {
        if (isset($this->is_completed) && $this->is_completed == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
        return null;
    }

    public function getApprovedAttribute()
    {
        if (isset($this->pettycashapprove->status_id) && $this->pettycashapprove->status_id == 1) {
            return 'Yes';
        } elseif (isset($this->pettycashapprove->status_id) && $this->pettycashapprove->status_id == 2) {
            return 'Rejected';
        } else {
            return 'No';
        }
        return null;
    }

    public function getCreatebyAttribute()
    {
        return $this->createdby->first_name . ' ' . $this->createdby->last_name;
    }

    public function getUpdatebyAttribute()
    {
        if (isset($this->updatedby->first_name)) {
            return $this->updatedby->first_name . ' ' . $this->updatedby->last_name;
        } else {
            return null;
        }
    }
}
