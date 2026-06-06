<?php namespace Bt\HR\Models;

use Model;
use BackendAuth;

/**
 * Employee Model
 */
class Employee extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_hr_employees';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [
//         'idno'    => 'required',
//         'employeenumber'    => 'required',
//         'firstname'    => 'required',
//         'lastname'    => 'required',
//         'ethnicity'    => 'required',
//         'company'    => 'required',
//         'email'    => 'required|email|unique:users,email',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'leave' =>['Bt\HR\Models\AbsenceLeave','key'=>'employee_id'],
        'incidents' =>['Bt\HR\Models\Incidents','key'=>'employee_id'],
        'training' =>['Bt\HR\Models\Training','key'=>'employee_id'],

    ];
    public $belongsTo = [
         'company' => ['Bt\Finance\Models\Project','key'=>'company_id','other'=>'id'],
        'designation' =>['Bt\HR\Models\Designation','key'=>'designation_id'],
        'type' =>['Bt\HR\Models\EmploymentType','key'=>'employmenttype_id'],
        'department' =>['Bt\HR\Models\Department','key'=>'department_id'],
        'ethnicity' =>['Bt\HR\Models\Ethnicity','key'=>'ethnicity_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'job_description' => ['Bt\Hr\Models\Jobdescription', 'key'=>'jobdescription_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'profilepic' => 'System\Models\File',
        'signature' => 'System\Models\File',
        'id_copy' => 'System\Models\File',
    ];
    public $attachMany = [
        'employmentfiles' => 'System\Models\File',
        'terminationfiles' => 'System\Models\File',
        'certificates' => 'System\Models\File',
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
     public function scopeTv($query)
    {
        return $query->where('showontv', 1)->where('is_user_active', 1);
    }
    public function scopeActive($query)
    {
        return $query->where('pay_roll', 1);
    }

    public function scopeDisabled($query)
    {
        return $query->where('is_user_active', 1);
    }

     public function getEmployeeOptions(){

            $obj = Employee::all();
            $name = array();
            foreach ($obj as $key => $value) {
                $name[$value->id] = $value->employeenumber.": ".$value->firstname." ".$value->surname;
             }
            return $name;

    }
    public static $pay_roll = array(1=>'BT',0 =>"EXPRESS");

    public function getPayRollOptions()
    {
         return self::$pay_roll;
    }

    public function onEmpOptions(){
        $employees = Employee::all();
        $emp = array();
        foreach ($employees as $employee){
            $emp[$employee->id] = $employee->firstname . ' '. $employee->lastname;
        }

        return $emp;
    }

    public function filterFields($fields, $context = null)
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        if ($user->hasPermission('bt.hr.rates')) {
            $fields->rate->hidden = false;
        } else {
            $fields->rate->hidden = true;
        }
    }
}
