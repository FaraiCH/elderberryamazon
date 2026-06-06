<?php namespace Bt\Production\Models;

use Illuminate\Support\Facades\Request;
use Model;
use BackendAuth;
use Bt\Inventory\Models\RawMaterialReceiving;
use Bt\Inventory\Models\StockRelease;
use Flash;

/**
 * MaterialUsed Model
 */
class MaterialUsed extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_material_useds';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        // 'receivingid' => 'required',
        // 'released' => 'required',
        // 'kg' => 'required',
    ];

    public $attributes = ['size_backetsorbags'=>''];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['number_backetsorbags', 'backetsorbags','kg', 'size_backetsorbags'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'scheduleday' =>['Bt\Production\Models\Schedule','key'=>'schedule_id'],
        'receiving' =>['Bt\Inventory\Models\RawMaterialReceiving','key'=>'raw_material_receivings_id'],
        'labresults' =>['Bt\QC\Models\LabResults','key'=>'raw_material_receivings_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];

    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];



    public function beforeCreate()
    {
        $this->raw_material_receivings_id = $this->receivingid;
        $this->raw_material_release_id =   $this->released;


        if ($this->checkkg($this->kg, $this->raw_material_release_id)) {
            $user = BackendAuth::getUser();
        if (!$user) return;
            $this->created_by = $user->id;
            $myKg = (float) filter_var($this->getKGPicked(), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $this->kg = $myKg;
        } else {
            return false;
        }

         unset($this->receivingid);
        unset($this->released);
    }

    public function afterValidate()
    {
    }


    public function beforeUpdate()
    {
        if ($this->checkkg($this->kg, $this->raw_material_release_id)) {
            $user = BackendAuth::getUser();
        if (!$user) return;
            $this->updated_by = $user->id;
        } else {
            return false;
        }
    }

    private function checkkg($kg, $mre)
    {
        if (!$mre > 0.01) {
            return false;
        }
        $obj = StockRelease::find($mre);
        $used = 0.01;

        if (!empty($obj)) {
            if (!empty($obj->usedmaterial)) {
                foreach ($obj->usedmaterial as $key_ => $value_) {
                    if ($value_->raw_material_receivings_id == $obj->raw_material_receivings_id) {
                            $used += $value_->kg;
                    }
                }
            }
        }

        $ava = $obj->kg - $used;
        $totalleft = $ava - $kg;

        if ($kg > 0.01 && $totalleft >= 0.01) {
            return true;
        } else {
            Flash::error("Invalid weight $kg kg (Max ".($ava)." kg)");
            return false;
        }
    }



    public function getReceivingidOptions()
    {
        $obj = RawMaterialReceiving::active()->where("purchase_id", '>', 0)->get();
        $listarray = array();
        foreach ($obj as $key => $value) {
            if(isset($value->productname) ) {
                $listarray[$value->id] =  $value->productname->name." -> Date Recieved: ".\Carbon\Carbon::parse($value->date_of_receipt)->format('d/m/Y').", Batch: ".$value->supplier_batch.", Weight: ".$value->weight." kg, MFI: ".$value->mfi;
            }
        }

        return $listarray;
    }

    public function getReleasedOptions()
    {
        if ($this->receivingid) {
            $obj = StockRelease::where('raw_material_receivings_id', $this->receivingid)->get();
            // trace_log("In Here");

            $listarray = array();
            if (!empty($obj)) {
                foreach ($obj as $key => $value) {
                    $used = 0;
                    if (!empty($value->usedmaterial)) {
                        foreach ($value->usedmaterial as $key_ => $value_) {
                            if ($value_->raw_material_receivings_id == $this->receivingid) {
                                $used += $value_->kg;
                            }
                        }
                    }

                    $ava = $value->kg - $used;

                    if ($ava > 0) {
                        $listarray[$value->id] = " Available: $ava kg ->Date Released: ".\Carbon\Carbon::parse($value->datecaptured)->format('d/m/Y').", Weight: ".$value->kg." kg, Used: $used kg";
                    }
                }
                if (!empty($listarray)) {
                    return $listarray;
                } else {
                    return ['' => '-- Out Of Material --'];
                }
            } else {
                return ['' => '-- none --'];
            }
        } else {
            return ['' => '-- none --'];
        }
    }

    public function filterFields($fields, $context = null)
    {


        if (!empty($this->receivingid) && isset($fields->backet)) {
            $fields->backet->disabled = false;
        }
    }


    public function getNumberBacketsorbagsAttribute()
    {

        if (isset($this->backetsorbags)) {
            if ($this->backetsorbags == 1) {
                return 2;
            } else {
                return 3;
            }
        } else {
            return 0;
        }
    }

    public function getBacketsorbagsOptions()
    {
        if ($this->released) {
            return [1 => 'Backet', 2 => 'Bags'];
        }
        return array();
    }

    public function getNumberBacketsorbagsOptions()
    {
        $listarray = array();
        $listarray[''] = '-- none --';
        $opt = array(1 => 'Backet', 2 => 'Bags');

        if ($this->backetsorbags) {
            for ($i=1; $i <= 100; $i++) {
                $listarray[$i] = $i." ".$opt[$this->backetsorbags];
            }
        }
        return $listarray;
    }


    public function getSizeBacketsorbagsOptions()
    {
        $listarray = array();
        $listarray[''] = '-- none --';
        $opt = DataFiller::WeightPercentage();
//        $opt = [1 => '100%'];

        if ($this->released) {
            if ($this->released == 1) {
                return  $opt;
            } else {
                return $opt;
            }
        }
        return $listarray;
    }

    public function getMaterialInput()
    {
        $value = array_get($this->attributes, 'size_backetsorbags');

        if (!empty($value)) {
            return array_get($this->getSizeBacketsorbagsOptions(), $value);
        } else {
            return false;
        }
    }
    public function getKGPicked()
    {
        $value = array_get($this->attributes, 'kg');

        if (!empty($value)) {
            return array_get($this->getKgOptions(), $value);
        } else {
            return false;
        }
    }

    public function getKgOptions()
    {
        $listarray = array();
        $schedule = Schedule::find(Request::Segment(6));
        if (!empty($this->getMaterialInput())) {
            $matValue = $this->getMaterialInput();
            $floatMaterialinput = (float) filter_var($matValue, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            if ($this->size_backetsorbags) {
                if (is_numeric($floatMaterialinput)) {
                    $kg =  ($schedule->total_kg_processed + $schedule->weight_scrap_kg) * ($floatMaterialinput/ 100);
                    if ($kg >0.01) {
                        $listarray[$kg] = $kg." kg";
                    }
                }
            }
        }

        return $listarray;
    }
}
