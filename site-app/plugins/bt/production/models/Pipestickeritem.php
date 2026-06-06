<?php namespace Bt\Production\Models;

use Bt\Logistics\Models\Binarea;
use Bt\Qc\Models\Qcreason;
use Bt\Sales\Models\Pickslip;
use Bt\Sales\Models\PickslipItem;
use Bt\Production\Models\ControlSheet as ControlSheetModel;
use Model;
use RainLab\User\Models\UserGroup;
use Session;
/**
 * Pipestickeritem Model
 */
class Pipestickeritem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_production_pipestickeritems';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = ['id', 'pickslip_id', 'dispatch_date'];

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

    public $timestamps = true;

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'controlsheets' => ['Bt\Production\Models\ControlSheet','key'=>'controlsheet_id','order'=>'id desc'],
        'binarea' => ['Bt\Logistics\Models\Binarea', 'key' => 'binarea_id'],
        'qcstatus' => ['Bt\Production\Models\QCStatus', 'key' => 'qcstatus_id'],
        'reason' => ['Bt\Qc\Models\Qcreason', 'key' => 'reason_id'],
        'pickslip' => ['Bt\Sales\Models\Pickslip', 'key' => 'pickslip_id'],
        'srn' => ['Bt\Sales\Models\Srn', 'key' => 'srn_id'],
        'product' => ['Bt\Sales\Models\Product','key'=>'product_id'],
        'prod_updated_by' => ['RainLab\User\Models\User','key' => 'prod_updated_by_id'],
        'qc_updated_by' => ['RainLab\User\Models\User', 'key' => 'qc_updated_by_id'],
        'quote_item' => ['Bt\Sales\Models\Quoteitems', 'key' => 'quote_item_id'],
        'batch' => ['Bt\Production\Models\JobCardBatch', 'key' => 'batch_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'weight_pic' => 'System\Models\File',
        'fail_pic' => 'System\Models\File',
    ];
    public $attachMany = [];

    public function getQcstatusIdOptions()
    {
        $sticks = array();
        $allstatus = QCStatus::all();

        foreach ($allstatus as $st) {
            $sticks[$st->id] = $st->name;
        }
        return $sticks;
    }

    public function getBinareaIdOptions()
    {
        $sticks = array();
        $allstatus = Binarea::all();

        foreach ($allstatus as $st) {
            $sticks[$st->id] = $st->area;
        }
        return $sticks;
    }

    public function getReasonIdOptions()
    {
        $sticks = array();
        $allstatus = Qcreason::all();

        foreach ($allstatus as $st) {
            $sticks[$st->id] = $st->reason;
        }
        return $sticks;
    }

    public function getControlsheetIdOptions()
    {
        $controlObj = array();
        $cs = ControlSheetModel::with('jobcard')->where('created_at', '>', '2022-01-01')->orderBy('id', 'desc')->get();

        foreach ($cs as $key => $value) {
            if (isset($value->jobcard)
                && isset($value->jobcard->pipe)
                && isset($value->jobcard->pipe->quoteitems)
                && isset($value->jobcard->pipe->quoteitems->description)) {
                $controlObj[$value->id] = $value->id;
            }
        }
        return $controlObj;
    }

    public function getBatchIdOptions()
    {
        $options = [];

        if ($this->controlsheet_id) {
            $controlsheet = ControlSheetModel::find($this->controlsheet_id);
            
            if ($controlsheet && $controlsheet->jobcard && $controlsheet->jobcard->pipe) {
                $jobcard_id = $controlsheet->jobcard->id;
                $batches = JobCardBatch::where('jobcard_id', $jobcard_id)->pluck('id')->toArray();
                foreach ($batches as $id) {
                    $options[$id] = "{$jobcard_id} - {$id}";
                }
            }
        }

        return $options;
    }





    public function beforeUpdate()
    {
        $task = Pipestickeritem::find($this->id);
        Session::put('before_controlsheet_id', ($task->controlsheet_id??0));
        Session::put('before_qcstatus_id', $task->qcstatus_id??0);
        Session::put('before_binarea_id', $task->binarea_id??0);
        Session::put('before_pickslip_id', $task->pickslip_id??0);
        Session::put('before_srn_id', $task->srn_id??0);
        Session::put('before_batch_id', $task->batch_id??0);
    }
    public function afterUpdate()
    {
        $makesave = 0;

        if (Session::has('before_controlsheet_id') && $this->controlsheet_id > 0 && Session::get('before_controlsheet_id') != $this->controlsheet_id) {
            $this->production_date = $this->updated_at;
            $makesave = 1;
            Session::forget('before_controlsheet_id');
        }
        if (Session::has('before_batch_id') && $this->before_batch_id > 0 && Session::get('before_batch_id') != $this->before_batch_id) {
            $this->production_date = $this->updated_at;
            $makesave = 1;
            Session::forget('before_batch_id');
        }
        if (Session::has('before_qcstatus_id') && $this->qcstatus_id  > 0 && Session::get('before_qcstatus_id') != $this->qcstatus_id) {
            $this->qcdate = $this->updated_at;
            $makesave = 1;
            if ($this->qcstatus_id == 2) {
                $groupusers = UserGroup::where('id', 37)->first();
                if (!empty($groupusers->users)) {
                    foreach ($groupusers->users as $key => $value) {
                        $data = [];
                        $data['name'] = $value->name;
                        $data['to_name'] = $value->name;
                        $data['to_email'] = $value->email;
                        $data['printpipe'] = self::where('counter', $this->counter)->where('sticker_id', $this->sticker_id)->first();
                        \Mail::send('BT.qc.notify.pipefailed', $data, function ($message) use ($data) {
                            $message->subject("BT Pipe Has Failed Quality Check");
                            $message->to($data['to_email'], $data['name']);
                        });
                        \Flash::success('Notification has been sent to the QC and Production Team');
                    }
                }
            }
            Session::forget('before_qcstatus_id');
        }

        if (Session::has('before_binarea_id') && $this->binarea_id > 0 && Session::get('before_binarea_id') != $this->binarea_id) {
            $this->bin_date = $this->updated_at;
            $makesave = 1;
            Session::forget('before_binarea_id');
        }

        if (Session::has('before_pickslip_id') && $this->pickslip_id > 0 && Session::get('before_pickslip_id') != $this->pickslip_id) {
            $this->dispatch_date = $this->updated_at;
            $makesave = 1;
            Session::forget('before_pickslip_id');
        }

        if (Session::has('before_srn_id') && $this->srn_id > 0 && Session::get('before_srn_id') != $this->srn_id) {
            $this->srn_date = $this->updated_at;
            $makesave = 1;
            Session::forget('before_srn_id');
        }

        if ($makesave == 1) {
            $this->save();
        }
    }

    public function makeThumb($src_file_name)
    {
        $supported_image = array('gif','jpg','jpeg','png');
        $supported_pdf = array('pdf');
        $ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
        if (in_array($ext, $supported_image)) {
            return ' <img src="'.$src_file_name.'" style="width: 100%; "  > ';
        } elseif (in_array($ext, $supported_pdf)) {
            return ' <embed src="'.$src_file_name.'" width="100%"  height="100%" /> ';
        }
        return '';
    }
}
