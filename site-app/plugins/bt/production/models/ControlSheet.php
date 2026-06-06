<?php namespace Bt\Production\Models;

use Model;
use BackendAuth;
use Bt\Production\Models\Jobcard as JobcardModel;
use Bt\Production\Models\JobCardBatch as JobCardBatchModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Bt\Production\Models\ScrapCodes;
use Bt\Production\Models\DelayReason;
/**
 * ControlSheet Model
 */
class ControlSheet extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_control_sheets';
    use \October\Rain\Database\Traits\Validation;

    public $rules = [


        'batch' => 'required',
        'btline'=>'required',
        'plan'=>'required',
        'planitem'=>'required',


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
    public $hasOne = [
            'scheduleday' => ['Bt\Production\Models\Schedule','key'=>'controlsheet_id']
    ];
    public $hasMany = [
        'controlmaterial' => ['Bt\Production\Models\Controlmaterial'],
        'citem' => ['Bt\Production\Models\ControlSheetItem','key'=>'controlsheet_id'],
        'cqcitem' => ['Bt\Production\Models\ControlSheetQcItem','key'=>'controlsheet_id'],
        'pipestickeritem' => ['Bt\Production\Models\Pipestickeritem','key'=>'controlsheet_id'],
        'production_daily_report_items' => ['Bt\Reporting\Models\ControlSheetMassData','key'=>'plan_id'],
        'assistant' => ['Bt\Production\Models\Assistant', 'key'=>'controlsheet_id'],
    ];
    public $belongsTo = [
        'batch' => ['Bt\Production\Models\JobCardBatch','key'=>'batch_id'],
        'jobcard' => ['Bt\Production\Models\Jobcard','key'=>'jobcard_id'],
        'assignedto' => ['Bt\Maintenance\Models\Staff','key'=>'assignedto_id'],
        'btline' => ['Bt\Production\Models\Line','key'=>'line_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'plan' => ['Bt\Production\Models\ProductionPlan', 'key' => 'plan_id'],
        'planitem' => ['Bt\Production\Models\ProductionPlanItem', 'key' => 'planitem_id'],
        'raw_plan' => ['Bt\Production\Models\RawProductionPlan', 'key' => 'raw_plan_id'],
        'operator_signature' => ['Bt\HR\Models\Employee','key'=>'operator_id'],
        'supervisor_signature' => ['Bt\HR\Models\Employee','key'=>'supervisor_id'],
        'qc_signature' => ['Bt\HR\Models\Employee','key'=>'qc_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'file' => 'System\Models\File',
        'fileinspection' => 'System\Models\File',
        'fileqcp' => 'System\Models\File',
        'fileinspectionreport' => 'System\Models\File',
        'operator_sign'  => 'System\Models\File',
        'qc_sign'  => 'System\Models\File',
        'super_sign'  => 'System\Models\File',

    ];
    public $attachMany = [
        'images_material' => 'System\Models\File',
        'images_delays' => 'System\Models\File',
        'images_product' => 'System\Models\File',

    ];

    public function beforeCreate()
    {
        $job = JobcardModel::find($this->jobcard_id);
        //trace_log("IN = ".$this->jobcard_id);

        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
        $this->standardweight = $job->pipe->quoteitems->product->production_value*$job->pipe->quoteitems->unitlength;
        #$this->mass = $job->pipe->quoteitems->totalweight;
        $this->mass = $job->pipe->quoteitems->product->production_value;
        $this->pipesize = $job->pipe->quoteitems->product->Diameter->name."mm";
        $this->pipelenght = $job->pipe->quoteitems->unitlength;


        $this->maxwall = $job->pipe->quoteitems->product->wt_max;
        $this->minwall = $job->pipe->quoteitems->product->wt_min;
        $this->avrwall = $job->pipe->quoteitems->product->wt_ave;
        $this->pipeod = $job->pipe->quoteitems->product->od_min . " - " . $job->pipe->quoteitems->product->od_max;
        $this->ovality = $job->pipe->quoteitems->product->ovality_max;
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }
    public function getBatchOptions()
    {
        $i = JobCardBatchModel::where('jobcard_id', $this->jobcard_id)->get();
        $arrayName = array();

        foreach ($i as $key_ => $value_) {
            $arrayName[$value_->id] = "Jobcard-".$value_->jobcard_id."-".$value_->id;
        }

        return $arrayName;
    }

    public function getItemValue($i, $field, $type = 'number')
    {

        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }

        $time = $i+$time;

        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);

       # return $t;


        foreach ($this->citem as $key => $value) {
            if ($t == $value->timeofreading) {
                return $value->$field;

                return $this->inputtype($value->$field, $field, $type);
            }

            // code...
        }

        return '';
    }

    public function getQcItemValue($i, $field, $type = 'number')
    {

        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }

        $time = $i+$time;

        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);

       # return $t;

        foreach ($this->cqcitem as $key => $value) {
            if ($t == $value->timeofreading) {
                return $value->$field;

                return $this->inputtype($value->$field, $field, $type);
            }

            // code...
        }

        return '';
    }

    public function getItemValueInputDownload($i, $field, $type = 'number', $option = 0) {
        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }
        $field_to_check = $field;

        $field_to_check_count = 0;




        // Works in PHP 5.2.2 and later.
        preg_match('/(?<name>\w+)(?<digit>\d+)/', $field, $matches);
        if (count($matches) > 0 && ($matches['name'] == 'barel_zone' || $matches['name'] == 'die_zone')) {
            $field_to_check = $matches['name'];
            $field_to_check_count = $matches['digit'];
        }




        $againstval = 0;
        switch ($field_to_check) {
            case "temperature_of_material":
                $againstval = 50;
                break;
            case "hopper_temperature":
                $againstval = 80;
                break;
            case "barel_zone":
                $fld = "BZ".$field_to_check_count;
                $againstval = $this->jobcard->$fld;
                break;
            case "die_zone":
                $fld = "DZ".$field_to_check_count;
                $againstval = $this->jobcard->$fld;
                break;

            case "motor_speed":
                $againstval = $this->jobcard->screw_speed;
                break;

            case "haul_off_speed":
                $againstval = $this->jobcard->haull_of_speed;
                break;

            case "machine_torque":
                $againstval = $this->jobcard->machine_torque;
                break;

            case "vacuum_1_reading":
                $againstval = $this->jobcard->vacuum_pressure1;
                break;

            case "vacuum_2_reading":
                $againstval = $this->jobcard->vacuum_pressure2;
                break;

            case "vacuum_3_reading":
                $againstval = $this->jobcard->vacuum_pressure3;
                break;

            case "max_wall_ne":
            case "max_wall_e":
            case "max_wall_se":
            case "max_wall_s":
            case "max_wall_sw":
                $againstval = $this->maxwall;
                break;

            case "min_wall_w":
            case "min_wall_nw":
                $againstval = $this->minwall;
                break;
            case "barel_zone_adaptor":
                $againstval = $this->jobcard->ADAPTOR;
                break;
            default:
                $againstval = 0;
        }

        //trace_log($field_to_check." = ".$againstval);


        $time = $i+$time;
        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);

        foreach ($this->citem as $key => $value) {
            if ($t == $value->timeofreading) {
                $v = $value->$field;

                if (isset($_SESSION['citem']) && $value->id == $_SESSION['citem'] && $type != 'text') {
                    if ($option == 2) {
                        return $this->selectscrap($value->$field, $field, $type, $value->id);
                    } elseif ($option == 3) {
                        return $this->selectdelay($value->$field, $field, $type, $value->id);
                    } elseif ($option == 4) {
                        return $this->selectminutes($value->$field, $field, $type, $value->id);
                    } elseif ($option == 5) {
                        return $this->selectwarm($value->$field, $field, $type, $value->id);
                    } elseif ($option == 1) {
                        return $this->selectgood($value->$field, $field, $type, $value->id);
                    } elseif ($option == 6) {
                        return $this->selectbreakdown($value->$field, $field, $type, $value->id);
                    } elseif ($option == 7) {
                        return $this->selectlinechange($value->$field, $field, $type, $value->id);
                    }elseif ($option == 8) {
                        return $this->selectcolour($value->$field, $field, $type, $value->id);
                    } else {
                        return $this->inputtype($value->$field, $field, $type, $value->id, '');
                    }
                } else {
                    if ($option == 2) {
                        if (!empty($value->reasonscrap)) {
                            return $value->reasonscrap->reason;
                        } else {
                            return '';
                        }
                    } elseif ($option == 3) {
                        if (!empty($value->delay)) {
                            return $value->delay->name;
                        } else {
                            return '';
                        }
                    } elseif ($option == 4) {
                        if ($v > 0) {
                            return $v." Minutes";
                        } else {
                            return '';
                        }
                    } elseif ($option == 5) {
                        if ($v > 0) {
                            return $v==1?"Warm" :"Cold";
                        } else {
                            return '-';
                        }
                    } elseif ($option == 6) {
                        if ($v > 0) {
                            return $v==1?"Yes" :"No";
                        } else {
                            return '-';
                        }
                    } elseif ($option == 7) {
                        if ($v > 0) {
                            return $v==1?"Yes" :"No";
                        } else {
                            return '-';
                        }
                    } elseif ($option == 1) {
                        if ($v > 0) {
                            return $v==1?"Good" :"Bad";
                        } else {
                            return '-';
                        }
                    }elseif ($option == 8) {
                        if ($v > 0) {
                             return $v == 1 ? "Black" : ($v == 2 ? "White" : "Orange");
                        } else {
                            return '-';
                        }
                    } else {
                        return $v;
                    }
                }
            }
        }


        return '';
    }
    public function getItemValueInput($i, $field, $type = 'number', $option = 0)
    {

        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }
        $field_to_check = $field;

        $field_to_check_count = 0;




        // Works in PHP 5.2.2 and later.
        preg_match('/(?<name>\w+)(?<digit>\d+)/', $field, $matches);
        if (count($matches) > 0 && ($matches['name'] == 'barel_zone' || $matches['name'] == 'die_zone')) {
            $field_to_check = $matches['name'];
            $field_to_check_count = $matches['digit'];
        }




        $againstval = 0;
        switch ($field_to_check) {
            case "temperature_of_material":
                $againstval = 50;
                break;
            case "hopper_temperature":
                $againstval = 80;
                break;
            case "barel_zone":
                $fld = "BZ".$field_to_check_count;
                $againstval = $this->jobcard->$fld;
                break;
            case "die_zone":
                $fld = "DZ".$field_to_check_count;
                $againstval = $this->jobcard->$fld;
                break;

            case "motor_speed":
                $againstval = $this->jobcard->screw_speed;
                break;

            case "haul_off_speed":
                $againstval = $this->jobcard->haull_of_speed;
                break;

            case "machine_torque":
                $againstval = $this->jobcard->machine_torque;
                break;

            case "vacuum_1_reading":
                $againstval = $this->jobcard->vacuum_pressure1;
                break;

            case "vacuum_2_reading":
                $againstval = $this->jobcard->vacuum_pressure2;
                break;

            case "vacuum_3_reading":
                $againstval = $this->jobcard->vacuum_pressure3;
                break;

            case "max_wall_ne":
            case "max_wall_e":
            case "max_wall_se":
            case "max_wall_s":
            case "max_wall_sw":
                $againstval = $this->maxwall;
                break;

            case "min_wall_w":
            case "min_wall_nw":
                $againstval = $this->minwall;
                break;
            case "barel_zone_adaptor":
                $againstval = $this->jobcard->ADAPTOR;
                break;
            default:
                $againstval = 0;
        }

        //trace_log($field_to_check." = ".$againstval);


        $time = $i+$time;
        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);

        foreach ($this->citem as $key => $value) {
            if ($t == $value->timeofreading) {
                $v = $value->$field;

                if (isset($_SESSION['citem']) && $value->id == $_SESSION['citem'] && $type != 'text') {
                    if ($option == 2) {
                        return $this->selectscrap($value->$field, $field, $type, $value->id);
                    } elseif ($option == 3) {
                        return $this->selectdelay($value->$field, $field, $type, $value->id);
                    } elseif ($option == 4) {
                        return $this->selectminutes($value->$field, $field, $type, $value->id);
                    } elseif ($option == 5) {
                        return $this->selectwarm($value->$field, $field, $type, $value->id);
                    } elseif ($option == 1) {
                        return $this->selectgood($value->$field, $field, $type, $value->id);
                    } elseif ($option == 6) {
                        return $this->selectbreakdown($value->$field, $field, $type, $value->id);
                    } elseif ($option == 7) {
                        return $this->selectlinechange($value->$field, $field, $type, $value->id);
                    } elseif ($option == 8) {
                        return $this->selectcolour($value->$field, $field, $type, $value->id);
                    }else {
                        return $this->inputtype($value->$field, $field, $type, $value->id, '').$this->addcheck($value->$field, $field, $value->id, $againstval, 1);
                    }
                } else {
                    if ($option == 2) {
                        if (!empty($value->reasonscrap)) {
                            return $value->reasonscrap->reason;
                        } else {
                            return '';
                        }
                    } elseif ($option == 3) {
                        if (!empty($value->delay)) {
                            return $value->delay->name;
                        } else {
                            return '';
                        }
                    } elseif ($option == 4) {
                        if ($v > 0) {
                            return $v." Minutes";
                        } else {
                            return '';
                        }
                    } elseif ($option == 5) {
                        if ($v > 0) {
                             return $v==1?"Warm" :"Cold";
                        } else {
                            return '-';
                        }
                    } elseif ($option == 6) {
                        if ($v > 0) {
                            return $v==1?"Yes" :"No";
                        } else {
                            return '-';
                        }
                    } elseif ($option == 7) {
                        if ($v > 0) {
                            return $v==1?"Yes" :"No";
                        } else {
                            return '-';
                        }
                    } elseif ($option == 1) {
                        if ($v > 0) {
                             return $v==1?"Good" :"Bad";
                        } else {
                            return '-';
                        }
                    }elseif ($option == 8) {
                        if ($v > 0) {
                             return $v == 1 ? "Black" : ($v == 2 ? "White" : "Orange");
                        } else {
                            return '-';
                        }
                    }  else {
                        return $v.$this->addcheck($value->$field, $field, $value->id, $againstval, 0);
                    }
                }
            }
        }


        return '';
    }


    public function getItemValueInputQc($i, $field, $type = 'number', $option = 0)
    {

        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }
        $field_to_check = $field;

        $field_to_check_count = 0;




        // Works in PHP 5.2.2 and later.
        preg_match('/(?<name>\w+)(?<digit>\d+)/', $field, $matches);
        if (count($matches) > 0 && ($matches['name'] == 'barel_zone' || $matches['name'] == 'die_zone')) {
            $field_to_check = $matches['name'];
            $field_to_check_count = $matches['digit'];
        }




        $againstval = 0;
        switch ($field_to_check) {
            case "max_wall_ne":
            case "max_wall_e":
            case "max_wall_se":
            case "max_wall_s":
            case "max_wall_sw":
                $againstval = $this->maxwall;
                break;

            case "min_wall_w":
            case "min_wall_nw":
                $againstval = $this->minwall;
                break;
            default:
                $againstval = 0;
        }


        $time = $i+$time;
        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);

        foreach ($this->cqcitem as $key => $value) {
            if ($t == $value->timeofreading) {
                $v = $value->$field;

                if (isset($_SESSION['cqcitem']) && $value->id == $_SESSION['cqcitem'] && $type != 'text') {
                    if ($option == 1) {
                        return $this->selectgood($value->$field, $field, $type, $value->id);
                    } elseif ($option == 2) {
                        return $this->selectqcpass($value->$field, $field, $type, $value->id);
                    }elseif ($option == 8) {
                        return $this->selectcolour($value->$field, $field, $type, $value->id);
                    }  else {
                        return $this->inputtype($value->$field, $field, $type, $value->id, '').$this->addcheck($value->$field, $field, $value->id, $againstval, 1);
                    }
                } else {
                }if ($option == 6) {
                    if ($v > 0) {
                        return $v==1?"Yes" :"No";
                    } else {
                        return '-';
                    }
                } elseif ($option == 7) {
                    if ($v > 0) {
                        return $v==1?"Yes" :"No";
                    } else {
                        return '-';
                    }
                } elseif ($option == 1) {
                    if ($v > 0) {
                         return $v==1?"Good" :"Bad";
                    } else {
                        return '-';
                    }
                } elseif ($option == 2) {
                    if ($v > 0) {
                        return $v==1?"Yes" :"No";
                    } else {
                        return '-';
                    }
                } elseif ($option == 8) {
                    if ($v > 0) {
                        return $v == 1 ? "Black" : ($v == 2 ? "White" : "Orange");
                    } else {
                        return '-';
                    }
                } else {
                    return $v.$this->addcheck($value->$field, $field, $value->id, $againstval, 0);
                }
            }
        }


        return '';
    }

    public function getItemValueInputMat($i, $mat, $type = 'number')
    {

        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }

        $time = $i+$time;
        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);

        foreach ($this->citem as $key => $value) {
            if ($t == $value->timeofreading) {
                $arrayMeasure = array('-',"Bag","Bucket","Cup");
                $label = '<div style="float:right; ">'.($arrayMeasure[$mat->measurement]).'</div>';
                foreach ($value->materials as $mym => $mymaterial) {
                    if ($mat->id == $mymaterial->material_id) {
                              $label = '<div style="float:right; padding-top: 2px">'.($arrayMeasure[$mat->measurement]).($mymaterial->kg_unit>1?"s":"").'</div>';
                        if (isset($_SESSION['citem']) && $value->id == $_SESSION['citem'] && $type != 'text') {
                            return '<div style="float:left; width:60%">'.$this->inputtype($mymaterial->kg_unit, 'new_kg_unit', 'number', $value->id, $mat->id).'</div> '.$label;
                        } else {
                            return '<div style="float:left;  padding-top: 2px;">'.$mymaterial->kg_unit."</div> $label";
                        }
                    }
                }

                if (isset($_SESSION['citem']) && $value->id == $_SESSION['citem'] && $type != 'text') {
                     return '<div style="float:left; width:70%">'.$this->inputtype('', 'new_kg_unit', 'number', $value->id, $mat->id).'</div> '.$label;
                }
            }
        }

        return '';
    }

    public function getItemValueInputMatQc($i, $mat, $type = 'number')
    {

        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }

        $time = $i+$time;
        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);

        foreach ($this->cqcitem as $key => $value) {
            if ($t == $value->timeofreading) {
                $arrayMeasure = array('-',"Bag","Bucket","Cup");
                $label = '<div style="float:right; ">'.($arrayMeasure[$mat->measurement]).'</div>';
                foreach ($value->materialsqc as $mym => $mymaterial) {
                    if ($mat->id == $mymaterial->material_id) {
                              $label = '<div style="float:right; padding-top: 2px">'.($arrayMeasure[$mat->measurement]).($mymaterial->kg_unit>1?"s":"").'</div>';
                        if (isset($_SESSION['cqcitem']) && $value->id == $_SESSION['cqcitem'] && $type != 'text') {
                            return '<div style="float:left; width:60%">'.$this->inputtype($mymaterial->kg_unit, 'new_kg_unit', 'number', $value->id, $mat->id).'</div> '.$label;
                        } else {
                            return '<div style="float:left;  padding-top: 2px;">'.$mymaterial->kg_unit."</div> $label";
                        }
                    }
                }

                if (isset($_SESSION['cqcitem']) && $value->id == $_SESSION['cqcitem'] && $type != 'text') {
                     return '<div style="float:left; width:70%">'.$this->inputtype('', 'new_kg_unit', 'number', $value->id, $mat->id).'</div> '.$label;
                }
            }
        }

        return '';
    }

    public function inputtype($v, $field, $type, $id, $mat_id = '')
    {

        return '<input  data-id="'.$id.'" data-mat_id="'.$mat_id.'"  class="form-control " type="'.$type.'" value="'.$v.'" name="'.$field.'" id="'.$field.'_'.$id.'">';
    }
    function addcheck($v, $field, $id, $againstval = 0, $show = 0)
    {
        if ($againstval != 0 && $v > 0 && is_numeric($v) && is_numeric($againstval)) {
            $per = intval(((($v - $againstval) / $againstval) * 100) * ($v < $againstval ? -1 : 1));
            if ($per > 5) {
                $maketooltip = ($show == 1) ? "maketooltip" : "";

                if ($per > 5 && $per < 15) {
                    return '<span title="Your input is almost out of threshold by ' . $per . '%" class="' . $maketooltip . ' bg_yellow" id="for_fiels_' . $field . '_' . $id . '"></span>';
                } else {
                    return '<span title="Your input is out of threshold by ' . $per . '%" class="' . $maketooltip . ' bg_red" id="for_fiels_' . $field . '_' . $id . '"></span>';
                }

            }
        }
        return '';
    }
    public function selectwarm($v, $field, $type, $id, $mat_id = '')
    {
        $sel = '<select data-id="'.$id.'" data-mat_id="'.$mat_id.'"  class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        $sel .= '<option value="1" '.($v==1?"selected":"").'>Warm</option>';
        $sel .= '<option value="2" '.($v==2?"selected":"").'>Cold</option>';
        $sel .= '<select>';
        return $sel;
    }


    public function selectgood($v, $field, $type, $id, $mat_id = '')
    {


        $sel = '<select data-id="'.$id.'" data-mat_id="'.$mat_id.'"  class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        $sel .= '<option value="1" '.($v==1?"selected":"").'>Good</option>';
        $sel .= '<option value="2" '.($v==2?"selected":"").'>Bad</option>';
        $sel .= '<select>';
        return $sel;
    }

    public function selectminutes($v, $field, $type, $id, $mat_id = '')
    {


        $sel = '<select data-id="'.$id.
            '" data-mat_id="'.$mat_id.'"
        class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        $sel .= '<option value="15" '.($v==15?"selected":"").'>15 Minutes</option>';
        $sel .= '<option value="30" '.($v==30?"selected":"").'>30 Minutes</option>';
        $sel .= '<option value="45" '.($v==45?"selected":"").'>45 Minutes</option>';
        $sel .= '<option value="60" '.($v==60?"selected":"").'>60 Minutes</option>';
        $sel .= '<select>';
        return $sel;
    }

    public function selectdelay($v, $field, $type, $id, $mat_id = '')
    {

        $codes = DelayReason::all();


        $sel = '<select data-id="'.$id.'" data-mat_id="'.$mat_id.'"  class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        foreach ($codes as $key => $value) {
            $sel .= '<option value="'.$value->id.'" '.($v==$value->id?"selected":"").'>'.$value->name.'</option>';
        }

        $sel .= '<select>';
        return $sel;
    }

    public function selectscrap($v, $field, $type, $id, $mat_id = '')
    {

        $codes = ScrapCodes::all();


        $sel = '<select data-id="'.$id.'" data-mat_id="'.$mat_id.'"  class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        foreach ($codes as $key => $value) {
            $sel .= '<option value="'.$value->id.'" '.($v==$value->id?"selected":"").'>'.$value->reason.'</option>';
        }

        $sel .= '<select>';
        return $sel;
    }

    public function selectcolour($v, $field, $type, $id, $mat_id = '')
    {


        $sel = '<select data-id="'.$id.
            '" data-mat_id="'.$mat_id.'"
        class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        $sel .= '<option value="1" '.($v==1?"selected":"").'>Black</option>';
        $sel .= '<option value="2" '.($v==2?"selected":"").'>White</option>';
        $sel .= '<option value="3" '.($v==3?"selected":"").'>Orange</option>';
        $sel .= '<select>';
        return $sel;
    }


    public function getButton($i)
    {

        $user = BackendAuth::getUser();
        if (!$user) return;

        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }

        $time = $i+$time;

        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);
        foreach ($this->citem as $key => $value) {
            if ($t == $value->timeofreading) {
                  return  '<a   data-request-data="cid: '.$this->id.',time: '.$i.',citem: '.$value->id.'"  data-request="onUpdateCSItem" style="padding-right:8px; font-size: 16px;" href="" type="button" class=" pull-right" data-request-flash data-request-validate data-attach-loading><i class="icon-pencil"></i></a>';
            }
        }

            return '<a  data-request-data="cid: '.$this->id.',time: '.$i.'"  data-request="onCreateCSItem" style="padding-right:8px;; font-size: 16px" type="button" class=" pull-right" href="" data-request-flash data-request-validate data-attach-loading><i class="icon-plus"></i></a>';
    }

    public function getButtonQc($i)
    {

        $user = BackendAuth::getUser();
        if (!$user) return;

        $time = 6;
        if ($this->shift == "NIGHT") {
            $time = 18;
        }

        $time = $i+$time;

        $t = Carbon::parse($this->opendate)->setTime($time, 00, 00);

        foreach ($this->cqcitem as $key => $value) {
            if ($t == $value->timeofreading) {
                return  '<a   data-request-data="cqcid: '.$this->id.',time: '.$i.',cqcitem: '.$value->id.'"  data-request="onUpdateCSQCItem" style="padding-right:8px; font-size: 16px;" href="" type="button" class=" pull-right" data-request-flash data-request-validate data-attach-loading><i class="icon-pencil"></i></a>';
            }
        }

            return '<a  data-request-data="cqcid: '.$this->id.',time: '.$i.'"  data-request="onCreateCSQCItem" style="padding-right:8px;; font-size: 16px" type="button" class=" pull-right" href="" data-request-flash data-request-validate data-attach-loading><i class="icon-plus"></i></a>';
    }

    public function selectbreakdown($v, $field, $type, $id, $mat_id = '')
    {
        $sel = '<select data-id="'.$id.'" data-mat_id="'.$mat_id.'"  class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        $sel .= '<option value="1" '.($v==1?"selected":"").'>Yes</option>';
        $sel .= '<option value="2" '.($v==2?"selected":"").'>No</option>';
        $sel .= '<select>';
        return $sel;
    }

    public function selectqcpass($v, $field, $type, $id, $mat_id = '')
    {
        $sel = '<select data-id="'.$id.'" data-mat_id="'.$mat_id.'"  class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        $sel .= '<option value="1" '.($v==1?"selected":"").'>Yes</option>';
        $sel .= '<option value="2" '.($v==2?"selected":"").'>No</option>';
        $sel .= '<select>';
        return $sel;
    }


    public function selectlinechange($v, $field, $type, $id, $mat_id = '')
    {
        $sel = '<select data-id="'.$id.'" data-mat_id="'.$mat_id.'"  class="form-control" name="'.$field.'" id="'.$field.'_'.$id.'">';
        $sel .= '<option>select</option>';
        $sel .= '<option value="1" '.($v==1?"selected":"").'>Yes</option>';
        $sel .= '<option value="2" '.($v==2?"selected":"").'>No</option>';
        $sel .= '<select>';
        return $sel;
    }

    public function getPlanOptions(){
        $planOptions = [];
        $obj = [];
        if(isset($this->jobcard->pipe->quoteitems->quote_id)){
            $quote_id = $this->jobcard->pipe->quoteitems->quote_id;
            if($quote_id == 284){
                if(isset($this->btline->id))
                    $obj = ProductionPlan::where('line_id', $this->btline->id)->orderBy('id', 'DESC')->get();
            }else{
                if(isset($this->btline->id))
                    $obj = ProductionPlan::where('line_id', $this->btline->id)
                        ->whereHas('planitems', function ($query) use ($quote_id){
                            $query->where("quote_id", $quote_id);
                        })
                        ->orderBy('id', 'DESC')->get();
            }
            foreach ($obj as $item){
                if(!empty($item->planitems)){
                    $client = [];
                    foreach ($item->planitems as $planitem){
                        if(isset($planitem->item->quote_id)){
                            $client[$planitem->item->quote_id] = $planitem->item->quote_id;
                        }
                    }
                }
                if(isset($this->btline->name )){
                    $planOptions[$item->id] = $item->id . " : " . $item->btline->name . " : Size : " . $item->size . ": Quotes: " . implode(',', $client) .": Start Date: " . date('Y-m-d', strtotime($item->startdate ));
                }
            }
        }

        return $planOptions;
    }

    public function getPlanitemOptions(){
        $planItemOptions = [];

        if(isset($this->jobcard->pipe->quoteitems->quote_id)){
            $quote_id = $this->jobcard->pipe->quoteitems->quote_id;
            if($quote_id == 284){
                $obj = ProductionPlan::find($this->plan_id);
            }else{
                $obj = ProductionPlan::where("id",$this->plan_id)->whereHas('planitems', function ($query) use ($quote_id){
                    $query->where('quote_id', $quote_id);
                })->first();
            }
            if(!empty($obj)){
                foreach ($obj->planitems as $planitem){
                    $planItemOptions[$planitem->id] = $planitem->id . ' : ' . $planitem->item->description. '>' . $planitem->item->quote->company_name.'>' . $planitem->item->quote_id;
                }
            }
        }

        return $planItemOptions;
    }

    public function getRawPlanOptions(){
        $planOptions = [];

        $obj = [];
        if(isset($this->btline->id))
            $obj = RawProductionPlan::where('line_id', $this->btline->id)->orderBy('id', 'DESC')->get();

        foreach ($obj as $item){
            if(isset($this->btline->name )) {
                $planOptions[$item->id] = $item->id . " : " . $item->btline->name . " : Date: " . $item->date;
            }

        }

        return $planOptions;
    }

    public function getTotalProduced()
    {
        if(!empty($this->scheduleday))
            if(!empty($this->scheduleday->btaccount->sum('units')) > 0)
            {
                return $this->scheduleday->total_units_passed_qc + $this->scheduleday->btaccount->sum('units');
            }else
            {
                return $this->scheduleday->total_units_passed_qc;
            }

        else
            return null;
    }

    public function  getTotalScanned()
    {
        if(!empty($this->pipestickeritem))
            return $this->pipestickeritem->where('qcstatus_id', "!=", 2)->count();
        else
            return null;
    }
}
