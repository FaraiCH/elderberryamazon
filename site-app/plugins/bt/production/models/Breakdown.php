<?php namespace Bt\Production\Models;

use Model;
use BackendAuth;
use Carbon\Carbon;
use Bt\Maintenance\Models\JobCard as JobcardModel;
use Bt\Production\Models\ControlSheet as ControlSheetModel;
// use Bt\Production\Models\Jobcard as Jobcard;
use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;

/**
 * Breakdown Model
 */
class Breakdown extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_production_breakdowns';

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
    public $rules = [
       'btline' => 'required',
       'startdate' => 'required',
       'breakdown' => 'required',
    ];

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
       'btline' => ['Bt\Production\Models\Line','key'=>'line_id'],
       'breakdown' => ['Bt\Production\Models\BreakdownReason','key'=>'breakdown_id'],
       'controlsheets' => ['Bt\Production\Models\ControlSheet','key'=>'controlsheet_id','order'=>'id desc'],
       'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
       'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
       'mainjobcard' => ['Bt\Maintenance\Models\JobCard', 'key' => 'jobcard_id'],

    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
      'file' => 'System\Models\File'
    ];
    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }

    public function afterCreate()
    {

        $jobcard = new JobcardModel;
        $jobcard->job_summary ="Breakdown on ".$this->btline->name.": ".$this->breakdown->name;
        $jobcard->opendate = $this->created_at;
        $jobcard->priority = 1;
        $jobcard->department_id = 1;
        $jobcard->save();

        $this->jobcard_id = $jobcard->id;
        $this->save();
        $this->onSend($jobcard);
    }

    public function onSend($jobcard)
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/maintenance/jobcard/update/'.$jobcard->id;
        $link = "
        * View Jobcard: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 34)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['Baila_breakdown'] = $this;
            $data['response_details'] =  $link;
            Mail::send('bt.notify.operator.breakdown', $data, function ($message) use ($data) {
                $message->subject("Baila Breakdown Notification: ");
                $message->to($data['to_email'], $data['name']);
            });
        }
        \Flash::success("Thank you, your request have been sent to $x users");
    }



    public function formAfterSave($model)
    {
        $this->onSend($model->id);
    }

    //get time when breakdown is been created until is closed stop time
    public function getTime()
    {

        $startTime = Carbon::parse($this->startdate);
        $endTime = null;

        if (!isset($mainjobcard->enddate)) {
            $diff = $startTime->diff(Carbon::now());
        } else {
            $endTime = Carbon::parse($mainjobcard->enddate);
            $diff = $startTime->diff($endTime);
        }

        if ($diff->days >= 1) {
            return $diff->format('%d days %h hours %i minutes');
        } elseif ($diff->h < 1) {
            return $diff->format('%i minutes');
        } else {
            return $diff->format('%h hours %i minutes');
        }
    }


  //display controll sheet
    public function getControlsheetsOptions()
    {
        $controlObj = array();
        $cs = ControlSheetModel::with('jobcard')->where('created_at', '>', '2023-01-01')->orderBy('id', 'desc')->get();

        foreach ($cs as $key => $value) {
            if (isset($value->jobcard)
                && isset($value->jobcard->pipe)
                && isset($value->jobcard->pipe->quoteitems)
                && isset($value->jobcard->pipe->quoteitems->description)) {
                $controlObj[$value->id] = $value->id . ">" . $value->jobcard->pipe->qpush->quote->company_name .
                    " : " . $value->jobcard->pipe->quoteitems->description;
            }
        }
        return $controlObj;
    }
}
