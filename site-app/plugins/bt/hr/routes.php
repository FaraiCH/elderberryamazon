<?php

use Bt\Hr\Models\Wagebill as WagebBillModel;
use Bt\HR\Models\Employee;
use Bt\HR\Models\Leavetype;
use Carbon\Carbon;

Route::get('/home/hours/', [\Bt\Hr\Controllers\Weeklyhour::class, 'HoursPDF']);
Route::get('/home/wages/', [\Bt\Hr\Controllers\Wagebill::class, 'WagesPDF']);

Route::any('/update-weekly-graph/', function (){
    $data = array();
    $startdate =    $_SESSION["makestart"];
    $enddate = $_SESSION["makeend"];
    $calldepartment = $_SESSION["dep"];
    if(empty($calldepartment)){
        $filterwages = WagebBillModel::whereBetween('date', array($startdate, $enddate))->where('comments', 0)->orderBy('date')->get();
    }else{
        $filterwages = WagebBillModel::whereBetween('date', array($startdate, $enddate))->orderBy('date')->whereHas('employee', function($q) use ($calldepartment){
            $q->where('department_id', $calldepartment);
        })->where('comments', 0)->get();
    }
    $totals = array();
    foreach ($filterwages as $wage)
    {
        if(isset( $wage->employee->department->name)){
            $datetri = $wage->date;
            $date_ =  $datetri;

            $line = $wage->employee->department->name;

            if($wage->comments == 'null'){
                if((double)$wage->cancel > 0){
                    $data[$line][$date_] = (isset($data[$line][$date_])? $data[$line][$date_]: 0) + (double)$wage->cancel;
                    $totals[$line]['Total'] = (isset($totals[$line]['Total'])? $totals[$line]['Total']: 0) + (double)$wage->cancel;
                }else{
                    $data[$line][$date_] = (isset($data[$line][$date_])? $data[$line][$date_]: 0) + (double)$wage->hours_worked;
                    $totals[$line]['Total'] = (isset($totals[$line]['Total'])? $totals[$line]['Total']: 0) + (double)$wage->hours_worked;
                }
            }else{
                $data[$line][$date_] = (isset($data[$line][$date_])? $data[$line][$date_]: 0) + (double)$wage->cancel;
                $totals[$line]['Total'] = (isset($totals[$line]['Total'])? $totals[$line]['Total']: 0) + (double)$wage->cancel;
            }
        }

    }

    $stats = array();

    foreach ($data as $name => $arrdata) {
        $content = array();
        foreach ($arrdata as $key => $value) {
            $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $value );
        }
        $stats[] = array('name' =>  $name , 'data' => $content);
    }
    return $stats;

});

Route::any('/admin/bt/hr/export/wagebill', function (){
    return Excel::download(new \Bt\Hr\Models\ExportWageDepartment(), 'WageBill.xlsx');
});

Route::any('update-weekly-pie', function (){
    $data = array();
    $startdate =    $_SESSION["makestart"];
    $enddate = $_SESSION["makeend"];
    $calldepartment = $_SESSION["dep"];
    if(empty($calldepartment)){
        $filterwages = WagebBillModel::whereBetween('date', array($startdate, $enddate))->where('comments', 0)->orderBy('date')->get();
    }else{
        $filterwages = WagebBillModel::whereBetween('date', array($startdate, $enddate))->orderBy('date')->whereHas('employee', function($q) use ($calldepartment){
            $q->where('department_id', $calldepartment);
        })->where('comments', 0)->get();
    }
    $totals = array();
    foreach ($filterwages as $wage)
    {
        if(isset($wage->employee->department->name)){
            $datetri = $wage->date;
            $date_ =  $datetri;
            $line = $wage->employee->department->name;
            if($wage->comments == 'null'){
                if((double)$wage->cancel > 0){
                    $data[$line][$date_] = (isset($data[$line][$date_])? $data[$line][$date_]: 0) + (double)$wage->cancel;
                    $totals[$line]['Total'] = (isset($totals[$line]['Total'])? $totals[$line]['Total']: 0) + (double)$wage->cancel;
                }else{
                    $data[$line][$date_] = (isset($data[$line][$date_])? $data[$line][$date_]: 0) + (double)$wage->hours_worked;
                    $totals[$line]['Total'] = (isset($totals[$line]['Total'])? $totals[$line]['Total']: 0) + (double)$wage->hours_worked;
                }
            }else{
                $data[$line][$date_] = (isset($data[$line][$date_])? $data[$line][$date_]: 0) + (double)$wage->cancel;
                $totals[$line]['Total'] = (isset($totals[$line]['Total'])? $totals[$line]['Total']: 0) + (double)$wage->cancel;
            }
        }
    }
    $piechart = [];
    if($calldepartment >= 1)
    {
        foreach ($data as $hours){
            foreach ($hours as $key => $value){
                $newWeek = Carbon::parse($key);
                $week = $newWeek->format('d/M');
                $piechart[] = array('name' => 'Date '. $week, 'y' => $value );
            }
        }
    }else{
        foreach ($totals as $name => $hours){
            foreach ($hours as $value){
                $piechart[] = array('name' => ''. $name, 'y' => $value );
            }
        }
    }

    return $piechart;
});

Route::any('/update-employees/', function (){
    $dataObj = array();
    $payroll = "None";
    $payrollname = "None";
    if(isset($_SESSION["dep"])){
        $calldepartment = $_SESSION["dep"];
    }else{
        $calldepartment = 0;
    }

    $startdate =    $_SESSION["makestart"];
    $enddate = $_SESSION["makeend"];
    $actualDate = actualDateRangeArray($startdate, $enddate);
    if(empty($calldepartment)){
        $emplyeeObj = Employee::where('is_user_active', 1)->get();
    }else{
        $emplyeeObj = Employee::where('is_user_active', 1)->where('department_id', $calldepartment)->get();
    }
    // Create Date Range Headers for Table
    foreach ($actualDate as $date) {
        $names[] = $date;
    }
    //Create Data to show in Table
    foreach($emplyeeObj as $key => $name) {
        //dataObj array will be pushed with additional data

        if(isset($name->designation->name)){
            $designation = $name->designation->name;
        }
        else{
            $designation = '';
        }
        if(isset($name->department->name)){
            $department = $name->department->name;
        }else{
            $department = '';
        }
        if(isset( $name->rate)){
            $rate = $name->rate;
        }else{
            $rate = 0.00;
        }
        if(isset($name->shifthours)){

            $shifthours = $name->shifthours;
        }else{
            $shifthours = 0.00;
        }
        if(isset($name->pay_roll_type)){
            if($name->pay_roll_type == 0){
                $payroll = "None";
            }
            if($name->pay_roll_type == 1){
                $payroll = "Monthly";
            }
            elseif ($name->pay_roll_type == 2)
            {
                $payroll = "Fortnight";
            }
        }else{
            $payroll = "None";
        }

        if(isset($name->pay_roll))
        {
            if($name->pay_roll == 1){
                $payrollname = "BT";
            }
            if($name->pay_roll == 0){
                $payrollname = "Express";
            }
        }
        $counter = 1;

        $public_holiday = 0;
        $public_holiday_full = 0;
        $total_hours_worked = 0;
        $total_normal_hours = 0;
        $total_normal_hours_full = 0;
        $total_over_time = 0;
        $total_over_time_full = 0;
        $total_double_time = 0;
        $total_double_time_full = 0;
        $total_shift_allowance = 0;
        $total_shift_allowance_full = 0;

        $total_rand_time = 0;
        $total_rand_timeHalf = 0;
        $total_rand_double = 0;
        $total_rand = 0;
        $rand_public_holiday = 0;
        $rand_public_holiday_full = 0;
        $total_sick_leave = 0;
        $total_sick_leave_full = 0;
        $sick_leave_rand = 0;
        $total_annual_leave = 0;
        $annual_leave_rand = 0;
        $total_annual_leave_full = 0;
        $total_hours_full = 0;

        $tempover = 0;
        $dataObj[] = array('Employee' => $name->firstname . " " . $name->lastname, 'Department' => $department, 'Shifthours' => $shifthours, 'Payroll' => $payrollname, 'Payroll Type' => $payroll, 'Rates' => $rate);
        foreach ($names as $vkey => $value){
            $user = WagebBillModel::where('date', $value)->where('employee_id', $name->id)->first();
            if(!empty($user)){
                $total_hours_worked =  $total_hours_worked + $user->hours_worked;
                $total_over_time = $total_over_time + $user->hours_over;
                $total_normal_hours = $total_normal_hours + $user->normal + $user->hours_over;
                $total_double_time = $total_double_time + $user->double;

                $total_shift_allowance = $total_shift_allowance + ($user->hours_worked * $user->shift);

                if(!isset($user->leavetype->id)){

                    //This will be all the hours and calculations to show on the table
                    //Here we are doing something similar to array_push
                    $dataObj[$key] += ['Hrs'. $vkey => $user->hours_worked];
                    $dataObj[$key] += ['Start'. $vkey => $user->start_time];
                    $dataObj[$key] += ['End'. $vkey => $user->end_time];
                    $dataObj[$key] += ['Normal'. $vkey => $user->normal];
                    $dataObj[$key] += ['Cancel'. $vkey => $user->cancel];
                    $dataObj[$key] += ['Overtime'. $vkey => $user->hours_over];
                    $dataObj[$key] += ['Double'. $vkey => $user->double];
                    if($user->shift == 0){
                        $dataObj[$key] += ['ShiftAll'. $vkey => 0];
                    }else {
                        $dataObj[$key] += ['ShiftAll'. $vkey => 1];
                    }
                    $dataObj[$key] += ['Leave'. $vkey => 'None'];
                }else{

                    //Annual Leave
                    if($user->leavetype->id == 1 ||  $user->leavetype->id == 9 || $user->leavetype->id == 10){
                        $total_annual_leave = $total_annual_leave + 9;

                        $total_annual_leave_full = $total_annual_leave_full + 9;
                    }
                    if($user->leavetype->id == 2){
                        $total_sick_leave = $total_sick_leave + 9;

                        $total_sick_leave_full = $total_sick_leave_full + 9;
                    }

                    $dataObj[$key] += ['Hrs'. $vkey => $user->hours_worked];
                    $dataObj[$key] += ['Start'. $vkey => $user->start_time];
                    $dataObj[$key] += ['End'. $vkey => $user->end_time];
                    $dataObj[$key] += ['Normal'. $vkey => $user->normal];
                    $dataObj[$key] += ['Cancel'. $vkey => $user->cancel];
                    $dataObj[$key] += ['Overtime'. $vkey => $user->hours_over];
                    $dataObj[$key] += ['Double'. $vkey => $user->double];
                    if($user->shift == 0){
                        $dataObj[$key] += ['ShiftAll'. $vkey => 0];
                    }else {
                        $dataObj[$key] += ['ShiftAll'. $vkey => 1];
                    }
                    $dataObj[$key] += ['Leave'. $vkey => $user->leavetype->name];
                    if($user->leavetype->id == 7)
                    {
                        $public_holiday += $user->double + 9;
                        $total_double_time -= $public_holiday - 9;
                        $total_hours_worked += 9;
                    }
                    if($user->leavetype->id == 6)
                    {
                        $public_holiday += 9;
                        $total_hours_worked += 9;
                    }
                }
                $getDate = new DateTime($user->date);
                $myDay = $getDate->format('D');

                if($myDay == 'Sun'){

                    if($total_normal_hours >= 45){
                        $total_over_time = $total_normal_hours - 45;
                        $total_normal_hours = 45;
                    }else{
                        $total_over_time = 0;

                        if($total_double_time > 0)
                        {
                            $total_normal_hours += $total_double_time;

                            if($total_normal_hours >= 45)
                            {
                                $total_double_time = $total_normal_hours - 45;
                                $total_normal_hours = 45;
                            }else
                            {
                                $total_double_time = 0;
                            }
                        }
                    }

                    $public_holiday_full += $public_holiday;


                    $total_normal_hours_full = $total_normal_hours_full + $total_normal_hours + $total_over_time;
                    $total_over_time_full = $total_over_time_full + $total_over_time;


                    $total_double_time_full = $total_double_time_full + $total_double_time;
                    $total_hours_full = $total_normal_hours_full + $total_double_time_full + $public_holiday_full;

                    if($counter >= 2) {
                        if($total_normal_hours_full >= 90){
                            $total_over_time_full = $total_normal_hours_full - 90;
                            $total_normal_hours_full = 90;
                        }else{
                            $total_over_time_full = 0;

                            if($total_double_time_full > 0)
                            {
                                $total_normal_hours_full += $total_double_time_full;

                                if($total_normal_hours_full >= 90)
                                {
                                    $total_double_time_full = $total_normal_hours_full - 90;
                                    $total_normal_hours_full = 90;
                                }else
                                {
                                    $total_double_time_full = 0;
                                }
                            }
                        }
                    }

                    $total_shift_allowance_full = $total_shift_allowance_full + ($total_shift_allowance * $name->rate * 0.1);
                    $total_rand_time = $total_rand_time + $name->rate * $total_normal_hours;
                    $total_rand_timeHalf = $total_rand_timeHalf +  ($name->rate * $total_over_time * 1.5);
                    $total_rand_double = $total_rand_double + ($name->rate * $total_double_time * 2);
                    if($counter >= 2) {
                        if($total_normal_hours_full >= 90)
                        {
                            $total_rand_time = ($name->rate * $total_normal_hours_full);
                            $total_rand_timeHalf = ($name->rate * $total_over_time_full * 1.5);
                            $total_rand_double = ($name->rate * $total_double_time_full * 2);
                        }
                        else
                        {
                            $total_rand_double = 0;
                            $total_rand_timeHalf = 0;
                        }
                    }


                    $sick_leave_rand = $sick_leave_rand + ($total_sick_leave * $name->rate);
                    $annual_leave_rand = $annual_leave_rand + ($total_annual_leave * $name->rate);
                    $rand_public_holiday += ($public_holiday * $name->rate);

                    $tolalWeeklyRand = ($name->rate * $total_normal_hours) + (($total_annual_leave + $total_sick_leave) * $name->rate) + ($name->rate * $total_over_time * 1.5) + ($name->rate * $total_double_time * 2) + ($total_shift_allowance * $name->rate * 0.1) + ($name->rate * $public_holiday);
                    $total_rand = $total_rand + $tolalWeeklyRand;

                    $dataObj[$key] += ['totalHrs'. $vkey => $total_hours_worked + $total_sick_leave + $total_annual_leave];
                    $dataObj[$key] += ['totalNormal'. $vkey => $total_normal_hours];
                    $dataObj[$key] += ['timeAndHalf'. $vkey => $total_over_time];
                    $dataObj[$key] += ['totalDouble'. $vkey => $total_double_time];
                    $dataObj[$key] += ['totalPublic'. $vkey => $public_holiday];
                    $dataObj[$key] += ['totalAnualLeave'. $vkey => $total_annual_leave];
                    $dataObj[$key] += ['totalSickLeave'. $vkey => $total_sick_leave];

                    $dataObj[$key] += ['randT'. $vkey => $name->rate * $total_normal_hours];
                    $dataObj[$key] += ['randTandHalf'. $vkey => $name->rate * $total_over_time * 1.5];
                    $dataObj[$key] += ['rand2T'. $vkey => $name->rate * $total_double_time * 2];
                    $dataObj[$key] += ['randPublic'. $vkey => $name->rate * $public_holiday];
                    $dataObj[$key] += ['randAnnual'. $vkey => $name->rate * $total_annual_leave];
                    $dataObj[$key] += ['randSick'. $vkey => $name->rate * $total_sick_leave];
                    $dataObj[$key] += ['shiftallowance'. $vkey => $total_shift_allowance * $name->rate * 0.1];
                    $dataObj[$key] += ['fullAmount'. $vkey => $tolalWeeklyRand];

                    $total_shift_allowance_full = $total_shift_allowance_full + ($total_shift_allowance * $name->rate * 0.1);


                    $sick_leave_rand = $sick_leave_rand + ($total_sick_leave * $name->rate);
                    $annual_leave_rand = $annual_leave_rand + ($total_annual_leave * $name->rate);
                    $total_rand = $total_rand + $tolalWeeklyRand;

                    $total_hours_worked = 0;
                    $total_normal_hours = 0;
                    $total_over_time = 0;
                    $total_double_time = 0;
                    $total_shift_allowance = 0;
                    $total_annual_leave = 0;
                    $total_sick_leave = 0;
                    $public_holiday = 0;

                    if($counter >= 2){
                        $tolalWeeklyRandFulll = ($name->rate * $total_normal_hours_full) + (($total_annual_leave_full + $total_sick_leave_full) * $name->rate) + ($name->rate * $total_over_time_full * 1.5) + ($name->rate * $total_double_time_full * 2) + ($total_shift_allowance_full * $name->rate * 0.1) + ($public_holiday_full * $name->rate);


                        $dataObj[$key] += ['fortNormal'. $vkey => $total_normal_hours_full];
                        $dataObj[$key] += ['fortAndHalf'. $vkey => $total_over_time_full];
                        $dataObj[$key] += ['fortDouble'. $vkey => $total_double_time_full];
                        $dataObj[$key] += ['fortPublic'. $vkey => $public_holiday_full];
                        $dataObj[$key] += ['fortTotal'. $vkey => $total_hours_full + $total_annual_leave_full + $total_sick_leave_full];
                        $dataObj[$key] += ['fortAnnualLeave'. $vkey => $total_annual_leave_full];
                        $dataObj[$key] += ['fortSickLeave'. $vkey => $total_sick_leave_full];

                        $dataObj[$key] += ['fortrandT'. $vkey => $total_rand_time];
                        $dataObj[$key] += ['fortrandTandHalf'. $vkey => $total_rand_timeHalf];
                        $dataObj[$key] += ['fortrand2T'. $vkey => $total_rand_double] ;
                        $dataObj[$key] += ['fortrandPublic'. $vkey => $rand_public_holiday];
                        $dataObj[$key] += ['fortshiftallowance'. $vkey => $total_shift_allowance_full];
                        $dataObj[$key] += ['fortAnnual'. $vkey => $annual_leave_rand];
                        $dataObj[$key] += ['fortSick'. $vkey => $sick_leave_rand];
                        $dataObj[$key] += ['fortfullAmount'. $vkey => $tolalWeeklyRandFulll];
                    }
                    $counter++;
                }


            }else{
                $dataObj[$key] += ['Hrs'. $vkey => 0.0];
                $dataObj[$key] += ['Start'. $vkey => 'Not Set'];
                $dataObj[$key] += ['End'. $vkey => 'Non Set'];
                $dataObj[$key] += ['Normal'. $vkey => 0.0];
                $dataObj[$key] += ['Cancel'. $vkey => 0.0];
                $dataObj[$key] += ['Overtime'. $vkey => 0.0];
                $dataObj[$key] += ['Double'. $vkey => 0.0];
                $dataObj[$key] += ['ShiftAll'. $vkey => 0];
                $dataObj[$key] += ['Leave'. $vkey => 'None'];

                $dataObj[$key] += ['totalHrs'. $vkey => 0.0];
                $dataObj[$key] += ['totalNormal'. $vkey => 0.0];
                $dataObj[$key] += ['timeAndHalf'. $vkey => 0.0];
                $dataObj[$key] += ['totalDouble'. $vkey => 0.0];
                $dataObj[$key] += ['totalPublic'. $vkey => 0.0];
                $dataObj[$key] += ['randT'. $vkey => 0.0];
                $dataObj[$key] += ['randTandHalf'. $vkey => 0.0];
                $dataObj[$key] += ['rand2T'. $vkey => 0.0];
                $dataObj[$key] += ['randPublic'. $vkey => 0.0];
                $dataObj[$key] += ['shiftallowance'. $vkey => 0.0];
                $dataObj[$key] += ['fullAmount'. $vkey => 0.0];
                $dataObj[$key] += ['totalAnualLeave'. $vkey => 0.0];
                $dataObj[$key] += ['totalSickLeave'. $vkey => 0.0];
                $dataObj[$key] += ['fortNormal'. $vkey => $total_normal_hours_full];
                $dataObj[$key] += ['fortAndHalf'. $vkey => $total_over_time_full];
                $dataObj[$key] += ['fortDouble'. $vkey => $total_double_time_full];
                $dataObj[$key] += ['fortPublic'. $vkey => $public_holiday_full];
                $dataObj[$key] += ['fortTotal'. $vkey => $total_hours_full + $total_annual_leave_full + $total_sick_leave_full];
                $dataObj[$key] += ['fortAnnualLeave'. $vkey => $total_annual_leave_full];
                $dataObj[$key] += ['fortSickLeave'. $vkey => $total_sick_leave_full];
                $dataObj[$key] += ['randAnnual'. $vkey => $name->rate * $total_annual_leave];
                $dataObj[$key] += ['randSick'. $vkey => $name->rate * $total_sick_leave];
                $dataObj[$key] += ['fortrandT'. $vkey => $total_rand_time];
                $dataObj[$key] += ['fortrandTandHalf'. $vkey => $total_rand_timeHalf];
                $dataObj[$key] += ['fortrand2T'. $vkey => $total_rand_double];
                $dataObj[$key] += ['fortrandPublic'. $vkey => $rand_public_holiday];
                $dataObj[$key] += ['fortshiftallowance'. $vkey => $total_shift_allowance_full];
                $dataObj[$key] += ['fortAnnual'. $vkey => $annual_leave_rand];
                $dataObj[$key] += ['fortSick'. $vkey => $sick_leave_rand];
                $dataObj[$key] += ['fortfullAmount'. $vkey => $total_rand];

            }
        }
    }
    return $dataObj;
});

function actualDateRangeArray($strDateFrom,$strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    // could test validity of dates here but I'm already doing
    // that in the main script
    $aryRange = [];
    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

Route::any('/admin/hr/employee/profile',function () {
    return Excel::download(new \Bt\Hr\Classes\ProfilePicExport(), 'Profile-Pic.xlsx');
});
