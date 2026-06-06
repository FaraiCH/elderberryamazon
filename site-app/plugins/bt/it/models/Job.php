<?php namespace Bt\IT\Models;

use Model;
use BackendAuth;
use Mail;
use Backend\Models\User as UserModel;
use RainLab\User\Models\UserGroup;

/**
 * Job Model
 */
class Job extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_it_jobs';

    use \October\Rain\Database\Traits\Validation;
    public $rules = [

        'name'                  => 'required',
        'description'                  => 'required'
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
        'approved' => ['Bt\IT\Models\Jobapprove','key'=>'job_id'],
    ];
    public $hasMany = [
        'responses' => ['Bt\IT\Models\TaskResponse','key'=>'job_id'],
    ];
    public $belongsTo = [
        'responder' =>['Backend\Models\User','key'=>'responder_id','other'=>'id'],
        'toemployee' =>['Backend\Models\User','key'=>'employee_id','other'=>'id'],
        'project' => ['Bt\Finance\Models\Project','key'=>'project_id','other'=>'id'],
        'type' => ['Bt\IT\Models\JobType','key'=>'type_id'],
        'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
        'department' =>['Bt\HR\Models\Department','key'=>'department_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'ticketstage' =>['Bt\IT\Models\TicketStage','key'=>'ticketstage_id'],
        'assignedto' => ['RainLab\User\Models\User','key'=>'assignedto_id']

    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'images' => 'System\Models\File',
        'files' => 'System\Models\File'
    ];

     public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        // $user = BackendAuth::getUser();
        if (!$user) return;
        // $this->updated_by = $user->id;
        // $data['job_task_status'] = $this->status->name;

        // $data['job_task_responder_email'] = $this->responder->email;
        // $data['job_task_responder_name'] = $this->responder->first_name;

        // $data['job_assigned_to_email'] = $this->assignedto->email;
        // $data['job_assigned_to_name'] = $this->assignedto->first_name;

        // $data['job_expected_date'] = $this->expected_date;

        // Mail::send('BT.it.tasks.notifyinvoice', $data, function ($message) use ($data) {
        //     $message->to([
        //         $data['job_task_responder_email'] => $data['job_task_responder_name'],
        //         $data['job_assigned_to_email'] => $data['job_assigned_to_name']
        //     ]);
        });

    }

    public function getITOptions(){
        $ITObj = array();
        $IT_group = UserGroup::where('id', 25)->first();
        foreach ($IT_group->users as $IT){
            $ITObj[$IT->id] = $IT->name.'  '.$IT->surname;
        }
        return $ITObj;
    }

}
