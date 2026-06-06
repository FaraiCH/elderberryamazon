<?php namespace Bt\Maintenance\Models;

use Model;
use BackendAuth;
use Bt\Maintenance\Models\Staff;
/**
 * JobCard Model
 */
class JobCard extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_job_cards';

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
      'jobcardapprove' => ['Bt\Maintenance\Models\JobCardApprove','key'=>'jobcard_id'],
      'breakdown' => ['Bt\Production\Models\Breakdown','key'=>'breakdown_id'],
    ];
    public $hasMany = [];
    public $belongsTo = [

        'department' => ['Bt\Maintenance\Models\Department','key'=>'department_id'],
        'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
        'assignedto' => ['Bt\Maintenance\Models\Staff','key'=>'assignedto_id'],
        'supervisor' => ['Bt\Maintenance\Models\Staff','key'=>'supervisor_id'],
        'jobtype' => ['Bt\Maintenance\Models\JobType','key'=>'jobtype_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
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
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;

    }

    public function getSupervisorIdOptions(){
        $fullarray = array();
        $staff = Staff::where('is_supervisor', 1)->get();
        foreach($staff as $sta){
            $fullarray[$sta->id] = $sta->name;
        }
        return $fullarray;
    }

    
}
