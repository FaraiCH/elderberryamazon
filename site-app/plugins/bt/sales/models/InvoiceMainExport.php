<?php


namespace Bt\Sales\Models;


use Backend\Models\ExportModel;
use Backend\Models\User;
use Carbon\Carbon;

class InvoiceMainExport extends ExportModel
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_invoices';
    public $belongsTo = [
        'srn' => ['Bt\Sales\Models\Srn','key'=>'srn_id','orderby'=>'id, desc'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    protected $appends = [
        'srn_name',
        'srn_date',
        'quote_no',
        'client_name',
        'amount_made',
        'sales_name',
        'created_by_name',
        'updated_by_name',
    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->orderBy('id','desc')->get()->toArray();
    }

    public function getSrnNameAttribute() {
        if(!empty(isset($this->srn)))
        {
            return $this->srn->id;
        }
    }
    public function getSrnDateAttribute() {
        if(!empty(isset($this->srn)))
        {
            return $this->srn->schedule_date;
        }
    }

    public function getAmountMadeAttribute() {
        if(!empty(isset($this->amount)))
        {
            return number_format($this->amount, 2, ',', ' ');
        }
    }

    public function getClientNameAttribute() {
        if(!empty(isset($this->quote->client)))
        {
            return $this->quote->client->company_name;
        }
    }
    public function getSalesNameAttribute() {
        if(!empty(isset($this->quote->user)))
        {
            return $this->quote->user->name . " " .$this->quote->user->surname;
        }
    }
    public function getQuoteNoAttribute() {
        if(!empty(isset($this->quote)))
        {
            return $this->quote->id;
        }
    }

    public function getCreatedByNameAttribute() {
        $user = User::find($this->created_by);
        if(!empty(isset($user)))
        {
            return $user->first_name . " " . $user->last_name;
        }
    }
    public function getUpdatedByNameAttribute() {
        $user = User::find($this->updated_by);
        if(!empty(isset($user)))
        {
            return $user->first_name . " " . $user->last_name;
        }
    }
}
