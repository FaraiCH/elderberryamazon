<?php namespace Bt\Hr\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\HR\Models\Department;
use Bt\Hr\Models\Weeklyhour as hourmodel;
use Carbon\Carbon;
use FontLib\Table\Type\post;
use October\Rain\Support\Facades\Input;
use Renatio\DynamicPDF\Classes\PDF;
use System\Helpers\DateTime;
use Bt\HR\Models\Employee;
use Bt\HR\Models\Leavetype;
use Bt\Hr\Models\Wagebill as WagebBillModel;

/**
 * Wagebill Backend Controller
 */
class Wagebill extends Controller
{
    public $employeed = 0;
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        #Add CSS
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap4.css', "1.0.0");
        $this->addCss('/plugins/bt/hr/assets/css/style.css', "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/backlaout.css", "1.0.0");
        #Add JS
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addJs('/plugins/bt/hr/assets/js/wagebill.js', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        BackendMenu::setContext('Bt.HR', 'hr', 'wagebill');
    }

    public function hoursinput()
    {
        $this->pageTitle ="Weekly Wages";
        BackendMenu::setContext('Bt.HR', 'hr', 'hoursinput');
        $employee = Employee::where('is_user_active', 1)->get();
        $allemployees = array();
        foreach($employee as $emp){
            $allemployees[$emp->firstname. ' ' . $emp->lastname] =  $emp->id . ' ' . $emp->firstname. ' ' . $emp->lastname;
        }
        $this->vars['employee'] = $employee;
        $this->vars['employeeall'] =  array_values($allemployees);
    }

    public function onWages()
    {
        $this->employeed = (int) filter_var(Input::get('employeedrop'), FILTER_SANITIZE_NUMBER_INT);
        if(empty($this->employeed)){
            $this->employeed = Input::get('employee');
        }
        $commentObj = Leavetype::all();
        $employ = Employee::find($this->employeed);
        $empObj = array();
        $no_weeks = post('weekno');
        $startdate = post('startdate');
        $newshift = Input::get('newshift');
        $normally = Input::get('normally');
        if(!isset($employ->firstname)) {
            \Flash::error('No user name given');
            return false;
        }
        $empObj['name'] = $employ->firstname . ' '. $employ->lastname;
        $this->vars['rate'] = $employ->rate;
        for($i = 0; $i < $no_weeks; $i++){
            $datebefore = date('Y-m-d', strtotime($startdate. ' + ' . $i . ' days'));
            $wagebill = WagebBillModel::where('date', $datebefore)->where('employee_id', $this->employeed)->first();
            if(isset($wagebill)) {
                $empObj['date'][$i] = $wagebill->date;
                $empObj['first'][$i] = $wagebill->start_time;
                $empObj['second'][$i] = $wagebill->end_time;
                $empObj['shift'][$i] = $wagebill->shift;
                $empObj['total'][$i] = $wagebill->hours_worked;
                $empObj['normal'][$i] = $wagebill->normal;
                $empObj['over'][$i] = $wagebill->hours_over;
                $empObj['double'][$i] = $wagebill->double;
                $empObj['cancel'][$i] = $wagebill->cancel;
                $empObj['comment'][$i] = $wagebill->comments;
                $empObj['status'][$i] = 1;
            }else
            {
                $empObj['shift'][$i] = $newshift;
                if($empObj['shift'][$i] == 0){
                    $empObj['first'][$i] = '';
                    $empObj['second'][$i] = '';
                }
                else{
                    $empObj['first'][$i] = '';
                    $empObj['second'][$i] = '';
                }
                $empObj['total'][$i] = 0;
                $empObj['normal'][$i] = 0;
                $empObj['over'][$i] = 0;
                $empObj['double'][$i] = 0;
                $empObj['cancel'][$i] = 0;
                $empObj['status'][$i] = 0;
            }
        }
        $this->vars['shifthours'] = $normally;
        $this->vars['empObj'] = $empObj;
        $weekNum = (int) filter_var($no_weeks, FILTER_SANITIZE_NUMBER_INT);
        $weeks = array();
        for($i=0;$i < $weekNum; $i++) {
            $weeks[$i]['Date'] = date('Y-m-d', strtotime($startdate. ' + ' . $i . ' days'));
            $weeks[$i]['Day'] = date('D', strtotime($startdate. ' + ' . $i . ' days'));
        }
        $this->vars['commentObj'] = $commentObj;
        $this->vars['weeks'] =  $weeks;
        $this->vars['noweeks'] =  $weekNum;
        $this->vars['employee'] = $this->employeed;
        $this->vars['start_date'] = $startdate;
        return [
            '#wages' => $this->makePartial('wages')
        ];
    }
    public function onSubmit()
    {
        $date = Input::get('week');
        $start_time = Input::get('start_time');
        $end_time = Input::get('end_time');
        $employee = Input::get('employee');
        $normalObj = Input::get('normal');
        $overObj = Input::get('over');
        $shiftObj = Input::get('shift');
        $commentObj = Input::get('comment');
        $totalObj = Input::get('total');
        $cancelObj = Input::get('cancel');
        $doubleObj = Input::get('double');
        $shifthours = Input::get('shifthours');
        $rate = Input::get('rate');
        foreach ($start_time as $key => $value) {
            $wagebill = WagebBillModel::where('employee_id', $employee)->
            where('date', $date[$key])->first();
            if(isset($wagebill)){
                $updateWage = WagebBillModel::find($wagebill->id);
                $updateWage->employee_id = $employee;
                $updateWage->start_time = $start_time[$key];
                $updateWage->shift = $shiftObj[$key];
                $updateWage->shifthours = $shifthours;
                $updateWage->rate = $rate;
                $updateWage->end_time = $end_time[$key];
                $updateWage->normal = $normalObj[$key];
                $updateWage->hours_worked = $totalObj[$key];
                if(!empty($overObj[$key])){
                    $updateWage->hours_over = $overObj[$key];
                }else{
                    $updateWage->hours_over = 0;
                }
                if(!empty($doubleObj[$key]))
                    $updateWage->double = $doubleObj[$key];
                else
                    $updateWage->double = 0;
                $updateWage->comments = $commentObj[$key];
                $updateWage->cancel = $cancelObj[$key];
                $updateWage->save();
                \Flash::success('Items Saved and Updated');
            }
            else {
                $wagebill = new WagebBillModel();
                $wagebill->date = $date[$key];
                $wagebill->employee_id = $employee;
                $wagebill->start_time = $start_time[$key];
                $wagebill->shift = $shiftObj[$key];
                $wagebill->shifthours = $shifthours;
                $wagebill->rate = $rate;
                $wagebill->end_time = $end_time[$key];
                $wagebill->normal = $normalObj[$key];
                $wagebill->hours_worked = $totalObj[$key];
                if(isset($overObj[$key])){
                    $wagebill->hours_over = $overObj[$key];
                }else{
                    $wagebill->hours_over = 0;
                }
                if(isset($doubleObj[$key]))
                    $wagebill->double = $doubleObj[$key];
                else
                    $wagebill->double = 0;
                $wagebill->comments = $commentObj[$key];
                $wagebill->cancel = $cancelObj[$key];
                $wagebill->save();
                \Flash::success('Items Saved');
            }
        }
    }


    public function stats()
    {
        $this->pageTitle = "Wages Dashboard";
        BackendMenu::setContext('Bt.HR', 'hr', 'stats');
        $departments = Department::all();
        if(\Input::has('enddate')){
            $enddate = \Input::get('enddate');
        }else{
            $enddate = date('Y-m-d');
        }
        if(\Input::has('startdate')){
            $startdate = \Input::get('startdate');
        }else{
            $startdate = date('Y-m-d', strtotime(date('Y-m-d') . ' - ' . 13 . ' days'));
        }
        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;
        $this->vars['departments'] = $departments;
        $calldepartment = Input::get('department');
        $_SESSION["makestart"] = $startdate;
        $_SESSION["makeend"] = $enddate;
        $_SESSION["dep"] = $calldepartment;

        $actualDate = actualDateRangeArray($startdate, $enddate);
        //Create Main Headers for Table
        $alldata[] = array( 'field' => ' ', 'headerText' => ' ', 'colSpan' => 4,
            'columns' => [
                array( 'field' => 'Employee', 'headerText' => 'Employee', 'width' => 150),
                array('field' => 'Department', 'headerText' => 'Department', 'width' => 150),
                array('field' => 'Shifthours', 'headerText' => 'Shift Hours', 'width' => 150),
                array( 'field' => 'Payroll', 'headerText' => 'Pay Roll', 'width'  => 120),
                array( 'field' => 'Payroll Type', 'headerText' => 'Pay Roll Type', 'width'  => 120),
                array( 'field' => 'Rates', 'headerText' => 'Rates', 'width'  => 90, 'textAlign' => 'Right', 'format' => "N2")
            ]
        );
        $counter = 1;
        // Create Date Range Headers for Table
        foreach ($actualDate as $key => $date) {
            $day = new \DateTime($date);


            $mystyff[] = array('field' => $day->format('D') . ' (' . $date . ')', 'headerText'=> $day->format('D') . ' (' . $date . ')', 'textAlign' => 'Center', 'colSpan' => 4,
                'columns' => [
                    array( 'field' => 'Hrs' . $key, 'headerText' => 'Hours Worked', 'width'  => 150, 'textAlign' => 'Right', 'format' => "N1"),
                    array( 'field' => 'Start' . $key, 'headerText' => 'Start', 'width' => 150),
                    array( 'field' => 'End' . $key, 'headerText' => 'End', 'width' => 150),
                    array( 'field' => 'Normal' . $key, 'headerText' => 'Normal', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                    array( 'field' => 'Overtime' . $key, 'headerText' => 'Overtime', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                    array( 'field' => 'Double' . $key, 'headerText' => 'Double Time', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                    array( 'field' => 'ShiftAll' . $key, 'headerText' => 'Shift Allowance', 'width' => 150, 'textAlign' => 'Right', 'format' => "N"),
                    array( 'field' => 'Leave' . $key, 'headerText' => 'Leave/Holiday', 'width' => 150),
                    array( 'field' => 'Cancel' . $key, 'headerText' => 'Shift Cancellation', 'width' => 150, 'textAlign' => 'Right', 'format' => "N"),
                ]
            );
            if ($day->format('D') == 'Sun'){
                $mystyff[] = array('field' => 'Weeklyhours', 'headerText'=> 'Week ' .  $counter .  ' Hrs', 'textAlign' => 'Center', 'colSpan' => 4,
                    'columns' => [
                        array( 'field' => 'totalHrs' . $key, 'headerText' => 'Total Hours', 'width'  => 150, 'textAlign' => 'Right', 'format' => "N1"),
                        array( 'field' => 'totalNormal' . $key, 'headerText' => 'T', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                        array( 'field' => 'timeAndHalf' . $key, 'headerText' => 'T 1/2', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                        array( 'field' => 'totalDouble' . $key, 'headerText' => '2 T', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                        array( 'field' => 'totalPublic' . $key, 'headerText' => 'Public Holiday', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                        array( 'field' => 'totalAnualLeave' . $key, 'headerText' => 'Annual Leave', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                        array( 'field' => 'totalSickLeave' . $key, 'headerText' => 'Sick Leave', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                    ]
                );
                $mystyff[] = array('field' => 'Rand', 'headerText'=> 'Week ' . $counter . ' Rand', 'textAlign' => 'Center', 'colSpan' => 4,
                    'columns' => [
                        array( 'field' => 'randT' . $key, 'headerText' => 'T', 'width'  => 150, 'textAlign' => 'Right', 'format' => "N2"),
                        array( 'field' => 'randTandHalf' . $key, 'headerText' => 'T 1/2', 'width'  => 150, 'textAlign' => 'Right', 'format' => "N2"),
                        array( 'field' => 'rand2T' . $key, 'headerText' => '2T', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                        array( 'field' => 'randPublic' . $key, 'headerText' => 'Public Holiday Rand', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                        array( 'field' => 'shiftallowance' . $key, 'headerText' => 'Shift Allowance', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                        array( 'field' => 'randAnnual' . $key, 'headerText' => 'Annual Leave Rand', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                        array( 'field' => 'randSick' . $key, 'headerText' => 'Sick Leave Rand', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                        array( 'field' => 'fullAmount' . $key, 'headerText' => 'Total', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                    ]
                );


                if($counter >= 2){
                    $mystyff[] = array('field' => 'forthours', 'headerText'=> 'Fortnight Hrs', 'textAlign' => 'Center', 'colSpan' => 4,
                        'columns' => [
                            array( 'field' => 'fortNormal' . $key, 'headerText' => 'T', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                            array( 'field' => 'fortAndHalf' . $key, 'headerText' => 'T 1/2', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                            array( 'field' => 'fortDouble' . $key, 'headerText' => '2 T', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                            array( 'field' => 'fortPublic' . $key, 'headerText' => 'Public Holiday', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                            array( 'field' => 'fortAnnualLeave' . $key, 'headerText' => 'Annual Leave', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                            array( 'field' => 'fortSickLeave' . $key, 'headerText' => 'Sick Leave', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                            array( 'field' => 'fortTotal' . $key, 'headerText' => 'Total', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N1'),
                        ]
                    );
                    $mystyff[] = array('field' => 'fortrand', 'headerText'=> 'Fortnight Total Rand', 'textAlign' => 'Center', 'colSpan' => 4,
                        'columns' => [
                            array( 'field' => 'fortrandT' . $key, 'headerText' => 'T', 'width'  => 150, 'textAlign' => 'Right', 'format' => "N2"),
                            array( 'field' => 'fortrandTandHalf' . $key, 'headerText' => 'T 1/2', 'width'  => 150, 'textAlign' => 'Right', 'format' => "N2"),
                            array( 'field' => 'fortrand2T' . $key, 'headerText' => '2T', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                            array( 'field' => 'fortrandPublic' . $key, 'headerText' => 'Public Holiday Rand', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                            array( 'field' => 'fortshiftallowance' . $key, 'headerText' => 'Shift Allowance', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                            array( 'field' => 'fortAnnual' . $key, 'headerText' => 'Annual Leave Rand', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                            array( 'field' => 'fortSick' . $key, 'headerText' => 'Sick Leave Rand', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
//                            array( 'field' => 'fortfullAmount' . $key, 'headerText' => 'Total', 'width' => 150, 'textAlign' => 'Right', 'format' => 'N2'),
                        ]
                    );

                    $counter = 0;
                }

                $counter++;




            }

            $fullObj = array_merge($alldata, $mystyff);
        }

        $json_string = json_encode($fullObj);
        $column = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $json_string);
        $this->vars['columns'] = $column;

    }

    public function WagesPDF()
    {
        $weekly = array();
        $weeksMade = array();
        $startdate = $_SESSION['makestart'];
        $enddate = $_SESSION['makeend'];
        $calldepartment = $_SESSION['dep'];
        if(empty($calldepartment)) {
            $weekr = WagebBillModel::whereBetween('date', array($startdate, $enddate))
                ->orderby("date", 'ASC')
                ->get();
        }else{
            $weekr = WagebBillModel::whereBetween('date', array($startdate, $enddate))->orderBy('date', 'ASC')->whereHas('employee', function($q) use ($calldepartment){
                $q->where('department_id', $calldepartment);
            })->get();
        }
        $monthstart = date("d F Y",strtotime($startdate));
        $monthend = date("d F Y",strtotime($enddate));
        $dep = Department::all();

        foreach ($weekr as $mykey => $hours) {
            $dep_name = $hours->employee->department->name;
            $date =  new \DateTime($hours->date);
            $actual_week = $date->format("W");
            $day = $date->format("D");
            $weekly[$dep_name][$hours->date] = (isset($weekly[$dep_name][$hours->date])? $weekly[$dep_name][$hours->date]: 0) + $hours->hours_worked;
            $weekly[$dep_name]['Total'] = (isset($weekly[$dep_name]['Total'])? $weekly[$dep_name]['Total']: 0) + $hours->hours_worked;
            $weekly[$dep_name]['TotalOver'] = (isset($weekly[$dep_name]['TotalOver'])? $weekly[$dep_name]['TotalOver']: 0) + $hours->hours_over;
            if($day == 'Sat'){
                $weekly[$dep_name]['TotalSat'] = (isset($weekly[$dep_name]['TotalSat'])? $weekly[$dep_name]['TotalSat']: 0) + $hours->hours_worked;
            }
            if($day == 'Sun'){
                $weekly[$dep_name]['TotalSun'] = (isset($weekly[$dep_name]['TotalSun'])? $weekly[$dep_name]['TotalSun']: 0) + $hours->hours_worked;
            }

            $weeksMade[$hours->date] = $actual_week . ' / ' . $date->format('d-m-Y');
        }
        $pdf = PDF::loadView('bt.hr::pdfWeeklyHours',array('departments' => $dep, 'weeks'=> $weekr,'weekly' => $weekly, 'start'=> $monthstart, 'end' => $monthend, 'weeksHeader' => $weeksMade ));
        return $pdf->download("Weekly Hours-".$monthstart . "-" . $monthend .".pdf");

    }

    public function onCalculate(){

        $employee_id = (int) filter_var(\Input::get('value'), FILTER_SANITIZE_NUMBER_INT);
        $employee = Employee::find($employee_id);
        if(!empty($employee)){
            return json_encode($employee->shifthours);
        }
    }
    public function listExtendQuery($query)
    {
        if(!$this->user->hasAccess('bt.hr.developer'))
            $query->whereHas('employee', function ($q){
                $q->where('is_user_active', 1);
            });
    }
}
