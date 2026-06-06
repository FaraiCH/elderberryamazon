<?php namespace Bt\Production\Models;

use Bt\Sales\Models\Quoteitems;
use Model;
use BackendAuth;
use Bt\Production\Models\Jobcard;
use phpDocumentor\Reflection\Types\Self_;

/**
 * Schedule Model
 */
class Schedule extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_schedules';
     use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'production_days' => 'required',
        'production_date' => 'required',
    ];


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

    protected $jsonable = ['extrapipe'];
    public $hasOne = [

    ];
    public $hasMany = [
        'usedmaterials' => ['Bt\Production\Models\MaterialUsed','key'=>'schedule_id'],
        'btaccount' => ['Bt\Production\Models\BtAccount','key'=>'fromschedule_id'],
    ];
    public $belongsTo = [
        'assignedto' => ['Bt\Maintenance\Models\Staff','key'=>'assignedto_id'],
        'controlsheet' => ['Bt\Production\Models\ControlSheet','key'=>'controlsheet_id'],
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [
        'scrapcodes' => ['Bt\Production\Models\ScrapCodes','table'=>'bt_prod_scrap_shedule','key'=>'schedule_id','otherKey'=>'scrapcode_id'],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {

        $user = BackendAuth::getUser();
        if (!$user) return;
        if ($user->id) {
            $this->created_by = $user->id;
        } else {
            $this->created_by = 1;
        }
    }
    public function beforeUpdate()
    {

        $this->getOrderedLimit();
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }

    public function scopeActive($query)
    {
        return $query->where('scheduled', 1);
    }

    public function getControlsheetOptions()
    {

        ##get all jobcard that belong to a pipe
        $listData = Jobcard::where("pipe_id", $this->pipe_id)->get();
        $obj = array();
        foreach ($listData as $key => $value) {
            foreach ($value->controlsheets as $key_c => $value_c) {
                if (isset($value_c->btline)) {
                    $obj[$value_c->id] = "Jobcard ".$value->id." > CS ".$value_c->id." > SHIFT :".$value_c->shift." > LINE : ".$value_c->btline->name;
                } else {
                    $obj[$value_c->id] = "Jobcard ".$value->id." > CS ".$value_c->id." > SHIFT :".$value_c->shift;
                }
            }
        }
        return $obj;
    }

    public function getReasonExtraOptions()
    {
        return Schedule::lists('reason_extra', 'reason_extra');
    }

    public function getReasonOverweightOptions()
    {
        return Schedule::lists('reason_overweight', 'reason_overweight');
    }

    public function getReasonDeviationProcessedOptions()
    {
        return Schedule::lists('reason_deviation_processed', 'reason_deviation_processed');
    }
    static function getReasonQcFailOptions()
    {
        return Schedule::lists('reason_qc_Fail', 'reason_qc_Fail');
    }

    public function getRecoveryPlanOptions()
    {
        return Schedule::lists('recovery_plan', 'recovery_plan');
    }

    public function getMaintenanceOptions()
    {
        return Schedule::lists('maintenance', 'maintenance');
    }

    public function getWhyonholdOptions()
    {
        return Schedule::lists('whyonhold', 'whyonhold');
    }


    public function getOrderedLimit()
    {
        if (isset($this->pipe->quoteitems->quote_id)) {
            $quote = $this->pipe->quoteitems->quote_id;
            $sche = self::where('pipe_id', $this->pipe->id)->get();
            $quoteitems = Quoteitems::where('quote_id', $quote)->get();
            $totalitmes = array();
            $totalprod = array();

            $difference = 0;
            foreach ($quoteitems as $q) {
                if ($q->id == $this->pipe->quoteitems->id) {
                    $totalitmes[] = $q->units;
                }
            }
            foreach ($sche as $s) {
                $totalprod[] = $s->total_units_produced;
            }

            $difference = array_sum($totalitmes);
            return $difference;
        } else {
            return null;
        }
    }

    public function getDataTableOptions()
    {
        $obj = array();
        if (isset($this->pipe->quoteitems)) {
            $obj[$this->pipe->quoteitems->unitlength] = $this->pipe->quoteitems->unitlength." m / DEFAULT";
            for ($i=1; $i <= 200; $i++) {
                if (!isset($obj[$i])) {
                    $obj[$i] = "$i m";
                }
            }
            return $obj;
        }

        return false;
    }

    public function scopeFilterByClient($query, $filter)
    {
        return $query->whereHas('pipe', function ($pipe) use ($filter) {

            $pipe->whereHas('qpush', function ($qpush) use ($filter) {
                     $qpush->whereHas('quote', function ($quote) use ($filter) {
                        $quote->where('client_id', $filter);
                     });
            });
        });
    }

    public function filterFields($fields, $context = null)
    {
        if(isset($this->controlsheet_id))
        {
            if($this->total_units_produced > 0)
            {
                if(!empty($this->controlsheet->pipestickeritem))
                {
                    $fields->total_units_passed_qc->comment="<h5 style='color:red'>Total Pipes Passed Qc Scanned Are: <b>" . $this->controlsheet->pipestickeritem->where('qcstatus_id', "!=", 2)->count() . "</b></h5>";
                }
            }
        }

    }
}
