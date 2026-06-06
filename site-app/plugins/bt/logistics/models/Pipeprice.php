<?php namespace Bt\Logistics\Models;

use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\JobCardBatch;
use Bt\Production\Models\Schedule as ScheduleModel;
use Model;
/**
 * Pipeprice Model
 */
class Pipeprice extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_logistics_pipeprices';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = ['batch', 'qty', 'date', 'product', 'length', 'unitsproduce','quote','pn', 'sdr', 'unitprice', 'totalamount', 'totalproduceamount'];

    /**
     *
     * @var array rules for validation
     */
    public $rules = ['batch' => 'required'];

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
    public $hasMany = [];
    public $belongsTo = [
        'batch' => ['Bt\Production\Models\JobCardBatch'],
        'quote' => ['Bt\Sales\Models\Newquote'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeSave()
    {
//        $job_batch = JobCardBatch::find($this->batch_id);
//        if(isset($job_batch->id)) {
//            $controlsheets = ControlSheet::where('jobcard_id', $job_batch->jobcard_id)
//                ->get();
//            foreach ($controlsheets as $controlsheet) {
//                if (isset($controlsheet->id)) {
//                    $schedules = ScheduleModel::where('controlsheet_id', $controlsheet->id)->get();
//                    if($schedules->sum('total_units_passed_qc') == 0){
//                        return false;
//                    }
//
//
//                }
//            }
//        }
    }
}
