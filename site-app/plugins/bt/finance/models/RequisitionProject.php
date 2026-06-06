<?php namespace Bt\Finance\Models;

use Model;
use Bt\Finance\Models\Requisition as ReqModel;

/**
 * RequisitionProject Model
 */
class RequisitionProject extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_finance_requisition_projects';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [
        'requisition' => ['Bt\Finance\Models\Requisition', 'key' => 'req_project_id']
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function sumApprovedAmount()
    {
        $sum = 0;
        foreach ($this->requisition as $requisitions) {
            if (
                ($requisitions->managerapprove && $requisitions->managerapprove->status_id == 1) ||
                ($requisitions->lineapprove && $requisitions->lineapprove->status_id == 1) ||
                ($requisitions->financeapprove && $requisitions->financeapprove->status_id == 1)
            ) {
                $sum += $requisitions->amount;
            }
        }

        return $sum;
    }

}
