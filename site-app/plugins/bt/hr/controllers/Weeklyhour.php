<?php namespace Bt\HR\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
use Bt\Hr\Models\Weeklyhour as hourmodel;
use BT\Hr\Models\Department;
use Illuminate\Support\Facades\Session;
use October\Rain\Support\Facades\Flash;
use October\Rain\Support\Facades\Input;
use Renatio\DynamicPDF\Classes\PDF;
use DateTime;
/**
 * Weeklyhour Backend Controller
 */
class Weeklyhour extends Controller
{
    ##Name: Katlego Phala
    ##Description: Weekly Hour graph display
    ##link:https://bailaerp.bt-industrial.co.za/backend/bt/hr/weeklyhour/graph


    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',

    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.HR', 'hr', 'weeklyhour');

       if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function graph()
    {

        BackendMenu::setContext('Bt.HR', 'hr', 'weeklyhourgraph');
        $this->pageTitle = "Labour Weekly Hours ";
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");
        $data = array();
        $counter = 0;
        $lineDep = null;
        $enddate = null;
        $startdate = null;

        $dep = Department::all();
        $otherdep = null;

        if(\Input::has('enddate')){
            $enddate = \Input::get('enddate');
        }else{
            $enddate = Carbon::now()->setTime(00, 00, 00);;
        }

        if(\Input::has('startdate')){
            $startdate = \Input::get('startdate');
        }else{
            $current = Carbon::now();
            $startdate = $current->addDays(-10)->setTime(00, 00, 00);;
        }
        if(\Input::has('department')){
            $otherdep = \Input::get('department');
        }

        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;

        $_SESSION["makestart"] = $startdate;
        $_SESSION["makeend"] = $enddate;


        if($otherdep >= 1){
           $whour = hourmodel::whereBetween('date', array($startdate, $enddate))->where('department_id', $otherdep)
            ->orderby("department_id")

            ->get();
        }else{
            $whour = hourmodel::whereBetween('date', array($startdate, $enddate))
                ->orderby("department_id")

                ->get();
        }

        $arrAhours = [];
        $totals = [];
        $sumOT = [];
        $totalsOT = [];
        $totalsatOT = [];
        $totalsunOT = [];
        $ot =[];
        $satOT =[];
        $sunOT =[];
        $averages = [];
        foreach ($whour as $mykey => $value){

            if(!optional($value->department)->short_name) {
                continue;
            }

            $combinedDT = date('Y-m-d H:i:s', strtotime("$value->date "));
            $createdAt = Carbon::parse($combinedDT);
            $datetri = $createdAt->format('Y-m-d');
            $date_ =  $datetri;

            //$lineAvr = $value->department->emps_in_department;
            $line = $value->department->short_name;
            $lineDep = $line. ' Department';
            $data[$line][$date_] = (double)$value->total_hours_weekly;
            $totals[$line]['Total'] = (isset($totals[$line]['Total'])? $totals[$line]['Total']: 0) + (double)$value->total_hours_weekly;

            $ot[$line][$date_] = (double)$value->total_overtime_weekly;
            $totalsOT[$line]['TotalOT'] = (isset($totalsOT[$line]['TotalOT'])? $totalsOT[$line]['TotalOT']: 0) + (double)$value->total_overtime_weekly;

            $satOT[$line][$date_] = (double)$value->sat_overtime_weekly;
            $totalsatOT[$line]['satOT'] = (isset($totalsatOT[$line]['satOT'])? $totalsatOT[$line]['satOT']: 0) + (double)$value->sat_overtime_weekly;

            $sunOT[$line][$date_] = (double)$value->sund_overtime_weekly;
            $totalsunOT[$line]['sunOT'] = (isset($totalsunOT[$line]['sunOT'])? $totalsunOT[$line]['sunOT']: 0) + (double)$value->sund_overtime_weekly;

            $sumOT[$line]['sumsOT'] = (isset($sumOT[$line]['sumsOT'])? $sumOT[$line]['sumsOT']: 0) + (double)$value->total_overtime_weekly  + (double)$value->sat_overtime_weekly + (double)$value->sund_overtime_weekly + (double)$value->total_hours_weekly;



            $averages[$line]['Average'] = $sumOT[$line]['sumsOT'] / count($data);

            $arrAhours[$date_] = $date_;
            $counter++;

        }
        $stats = array();
        $piechart = array();
        $avg = array();

        foreach ($data as $name => $arrdata) {
            $content = array();
            $total = 0;
            $count = 0;

            foreach ($arrdata as $key => $value) {
                $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $value );
                $total += $value;
                $count++;
            }

            $avgs = $total / $count;

            $stats[] = array('name' =>  $name , 'data' => $content);
            $avg[] = array('name' => $name, 'y' => $avgs);
        }

        if($otherdep >= 1)
        {
            foreach ($data as $name => $hours){
                $content = array();
                foreach ($hours as $key => $value){
                    $newWeek = Carbon::parse($key);
                    $week = $newWeek->format('W');
                    $piechart[] = array('name' => 'Week '. $week, 'y' => $value );
                }
            }
        }else{
            foreach ($totals as $key => $value)
            {
                $piechart[] = array('name' => $key, 'y' => $value['Total']);
            }
            $lineDep = "All Departments";
        }




        $this->vars['schedules'] = $data;
        $this->vars['stats'] = $stats;
        $this->vars['departments'] = $dep;
        $this->vars['hours'] = $arrAhours;
        $this->vars['averages'] = $averages;
        $this->vars['totals'] = $totals;
        $this->vars['totalsOT'] = $totalsOT;
        $this->vars['totalsatOT'] = $totalsatOT;
        $this->vars['sumOT'] = $sumOT;
        $this->vars['TotalsunOT'] = $totalsunOT;
        $this->vars['lineDep'] = $lineDep;
        $this->vars['pie'] = $piechart;
        $this->vars['avgs'] = $avg;

    }


    public function HoursPDF()
    {
        $weekly = array();
        $total = array();
        $aver = array();
        $weeksMade = array();
        $startdate = $_SESSION['makestart'];
        $enddate = $_SESSION['makeend'];
        $departments = [];


        $weekr = hourmodel::whereBetween('date', array($startdate, $enddate))
                ->orderby("department_id")->orderby("date", 'ASC')
                ->get();
        $monthstart = date("d F Y",strtotime($startdate));
        $monthend = date("d F Y",strtotime($enddate));

        foreach ($weekr as $mykey => $hours) {

            //$dep_no = optional($hours->department)->emps_in_department;

            $dep_name = optional($hours->department)->name ?? 'Hello';
            $date =  new DateTime($hours->date);
            $actual_week = $date->format("W");

            $weekly[$dep_name][$hours->date] = $hours->total_hours_weekly;

            $weekly[$dep_name]['Total'] = (isset($weekly[$dep_name]['Total'])? $weekly[$dep_name]['Total']: 0) + $hours->total_hours_weekly;

            $weekly[$dep_name]['TotalOT'] = (isset($weekly[$dep_name]['TotalOT'])? $weekly[$dep_name]['TotalOT']: 0) + $hours->total_overtime_weekly;

            $weekly[$dep_name]['satOT'] = (isset($weekly[$dep_name]['satOT'])? $weekly[$dep_name]['satOT']: 0) + $hours->sat_overtime_weekly;

            $weekly[$dep_name]['sunOT'] = (isset($weekly[$dep_name]['sunOT'])? $weekly[$dep_name]['sunOT']: 0) + $hours->sund_overtime_weekly;

            $weekly[$dep_name]['sumsOT'] = (isset($weekly[$dep_name]['sumsOT'])? $weekly[$dep_name]['sumsOT']: 0) + $hours->total_overtime_weekly  + $hours->sat_overtime_weekly + $hours->sund_overtime_weekly + $hours->total_hours_weekly;

            $aver[$dep_name]['Averaged'] = $weekly[$dep_name]['sumsOT'] /  count($weekly);

            $weeksMade[$hours->date] = $actual_week . '/' . $date->format("M Y");
        }

        $pdfData = array(
            'departments' => Department::all(),
            'weeks'=> $weekr,
            'weekly' => $weekly,
            'averages' => $aver,
            'start'=> $monthstart,
            'end' => $monthend,
            'weeksHeader' => $weeksMade
        );

        return PDF::loadView('bt.hr::pdfWeeklyHours', $pdfData)->download("Weekly Hours-".$monthstart . "-" . $monthend .".pdf");
    }

    function compareByTimeStamp($a, $b)
    {
        return strtotime($a) - strtotime($b);
    }
}
