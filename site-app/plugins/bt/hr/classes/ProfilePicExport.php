<?php namespace Bt\Hr\Classes;

use Bt\Sales\Models\Srn;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Bt\HR\Models\Employee;

class ProfilePicExport implements FromArray, ShouldAutoSize
{
    public function array(): array
    {
        $employees = Employee::where('is_user_active', 1)->get();
        return [$this->EmployeeDetails($employees)];
    }

    public function EmployeeDetails($employees)
    {
        $employeeObj = [];

        //Insert the Header for the export
        $employeeObj[0] = $this->header();

        foreach ($employees as $employee){
            $employeeObj[$employee->id]['name'] = $employee->firstname;
            $employeeObj[$employee->id]['surname'] = $employee->lastname;
            $employeeObj[$employee->id]['department'] = $employee->department->name;
            if(!empty($employee->profilepic)){
                $employeeObj[$employee->id]['picture'] = $employee->profilepic->getPath()?? 'No Pictures';
            }

        }
        return $employeeObj;
    }

    public function header() : array
    {
        // Create the export header
        return [
            'name' => "Name",
            'surname' => 'surname',
            'department' => 'Department',
            'picture' => 'Has Pictures?',
        ];
    }
}
