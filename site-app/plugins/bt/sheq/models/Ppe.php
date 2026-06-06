<?php namespace Bt\Sheq\Models;

use Bt\HR\Models\Department;
use Bt\HR\Models\Employee;
use Model;

/**
 * ppe Model
 */
class Ppe extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sheq_ppes';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'surname',
        'crew',
        'shoe_cover',
        'mop_caps',
        'beard_cover',
        'boats',
        'overall',
        'gloves',
    ];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'ppetype' => ['Bt\Sheq\Models\Ppetype'],
        'employee' => ['Bt\HR\Models\Employee', 'key'=>'employee_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function scopeFilterByDepartment($query, $filter){
        return $query->whereHas('employee', function($group) use ($filter) {
            $group->whereIn('department_id', $filter);
        });
    }

    public function getEmployeeIdOptions(){
        $employeeObj = array();
        $employees = Employee::where('is_user_active', 1)->get();
        foreach ($employees as $employee){
            $employeeObj[$employee->id] = $employee->firstname . " " . $employee->lastname;
        }

        return $employeeObj;
    }

}
