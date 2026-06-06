<?php namespace Bt\Production\Models;

use Bt\HR\Models\Employee;
use Model;
/**
 * Assistant Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Assistant extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'bt_production_assistants';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    public $belongsTo = [
        'employee' => ['Bt\HR\Models\Employee','key'=>'employee_id'],
        'employee_name' => ['Bt\HR\Models\Employee','key'=>'employee_id']
    ];

    public function getEmployeeOptions()
    {
        $emp = [];
        $fullname = null;
        $employees = Employee::all();

        foreach ($employees as $employee)
        {
            $fullname =  $employee->firstname . " " . $employee->lastname;
            if(isset($employee->department->name))
            {
                $fullname .= " > " . $employee->department->name;
            }
            $emp[$employee->id] = $fullname;
        }
        return $emp;
    }
}
