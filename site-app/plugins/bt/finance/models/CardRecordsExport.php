<?php


namespace Bt\Finance\Models;

use Backend\Models\ExportModel;
use RainLab\User\Models\User;
use Bt\Finance\Models\CardRecords;

class CardRecordsExport extends ExportModel
{
    public $table = 'bt_finance_card_records';

    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'project' => ['Bt\Finance\Models\Project','key'=>'project_id','other'=>'id'],
        'purchasedby' => ['RainLab\User\Models\User','key'=>'purchasedby_id','other'=>'id'],
        'approvedby' => ['RainLab\User\Models\User','key'=>'approvedby_id','other'=>'id'],
        'pettycash' =>['Bt\Finance\Models\pettycash', 'key'=>'pettycash_id','other'=>'id'],
        
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'signed_requisition' => 'System\Models\File',
    ];
    public $attachMany = [
        'slips' => 'System\Models\File',
    ];
    public $appends = [
        'project',
        'approved',
        'Purchasedby',
        'createby',
        'updateby',
        'uploader'
    ];

    
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->orderBy('id', 'desc')->get()->toArray();
    }

    public function getProjectAttribute()
    {
        $p = Project::find($this->project_id);
        return $p->name;
    }


    public function getApprovedAttribute()
    {

        if (isset($this->approvedby->name)) {
            return $this->approvedby->name . ' ' . $this->approvedby->surname;
        } else {
            return null;
        }
    }

    public function getUploaderAttribute()
    {
        
        $cardrecords = CardRecords::find($this->id);
        $doccount = 0;
        if ($cardrecords->slips->count() > 0) {
            $doccount++;
        }
        return $doccount;
    }
    
    public function getPurchasedbyAttribute()
    {
        $user = User::find($this->purchasedby_id);
        if (isset($user->id)) {
            return $user->name . ' ' . $user->surname;
        } else {
            return null;
        }
    }


    public function getCreatebyAttribute()
    {
        if (isset($this->createdby->first_name)) {
            return $this->createdby->first_name . ' ' . $this->createdby->last_name;
        } else {
            return null;
        }
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
