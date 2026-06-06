<?php namespace Bt\Finance\Models;

use Model;
use BackendAuth;

/**
 * Requisition Model
 */
class Requisition extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_finance_requisitions';
    use \October\Rain\Database\Traits\Validation;

    public $rules = [

        'suppliername' => 'required',
        'req_date' => 'required',
        'amount' => 'required',
        'requestby' => 'required',
        'invoice' => 'required',
        'expense' => 'required'


    ];

    protected $with = ['project'];
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
        'financeapprove' => ['Bt\Finance\Models\ReqFinanceApprove','key'=>'requesition_id','other'=>'id'],
        'lineapprove' => ['Bt\Finance\Models\ReqLineApprove','key'=>'requesition_id','other'=>'id'],
        'managerapprove' => ['Bt\Finance\Models\ReqManagerApprove','key'=>'requesition_id','other'=>'id'],
    ];
    public $hasMany = [
    ];
    public $belongsTo = [
        'project' => ['Bt\Finance\Models\Project','key'=>'project_id','other'=>'id'],
        'linemanager' => ['RainLab\User\Models\User','key'=>'linemanager_id','other'=>'id'],
        'requestby' =>['Backend\Models\User','key'=>'requestedby_id','other'=>'id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'req_project' => ['Bt\Finance\Models\RequisitionProject', 'key' => 'req_project_id'],
        'currencytype' => ['Bt\Finance\Models\CurrencyType', 'key' => 'currencytype_id']
    ];

    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'invoice' => 'System\Models\File',
    ];
    public $attachMany = [
        'files' => 'System\Models\File',
    ];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
        if($this->amount_other_currency > 0) {
            $this->amount = $this->amount_other_currency;
        }
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;

        if ($this->cancelled == 1) {
            $this->archived = 1;
        }
        if($this->amount_other_currency > 0) {
            $this->amount = $this->amount_other_currency;
        }

    }

    public function filterFields($fields, $context = null)
    {
        if (($this->lineapprove && $this->lineapprove->status_id == 1)
        || ($this->financeapprove && $this->financeapprove->status_id == 1)
        || ($this->managerapprove && $this->managerapprove->status_id == 1)) {
               $fields->amount->disabled = true;
               $fields->project->disabled = true;
               $fields->suppliername->disabled = true;
               $fields->req_date->disabled = true;
               $fields->requestby->disabled = true;
               $fields->linemanager->disabled = true;
               $fields->description->disabled = true;
               $fields->invoice->disabled = true;
        }


        if(!isset($this->expense) || $this->expense == 1){
            $fields->expense_options->hidden = true;
            $fields->other->hidden = true;
        }else{
            if($this->expense_options == 9){
                $fields->other->hidden = false;
            }else{

                $fields->other->hidden = true;
            }
        }


    }
    public function getExpenseOptionsOptions(){
        $arrayObj = [];
        if($this->expense == 2){
            return $arrayObj = [
                1 => 'Baila Machine 1',
                2 => 'Baila Machine 2',
                3 => 'Baila Machine 3',
                4 => 'Baila Machine 4',
                5 => 'Baila Machine 5',
                6 => 'Baila Machine 6',
                7 => 'Auxiliary Equipment',
                8 => 'Office',
                9 => 'Other'
            ];
        }
        return $arrayObj;
    }



}
