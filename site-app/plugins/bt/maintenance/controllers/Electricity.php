<?php namespace Bt\Maintenance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\Line;
use Carbon\Carbon;
use Bt\Maintenance\Models\Electricity as ElecModel;
use Bt\Maintenance\Models\ElecMeter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Renatio\DynamicPDF\Classes\PDF;
use System\Helpers\DateTime;
use Bt\Maintenance\Models\Schedule;
use Bt\Maintenance\Models\Tarrif;
/**
 * Electricity Backend Controller
 */
class Electricity extends Controller
{

    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\ImportExportController::class
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    public $importExportConfig = 'config_import_export.yaml';
    public $start = null;
    /**
     * __construct the controller
     */
    public function __construct()
    {

        parent::__construct();

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'electricity');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        //Have classes access to baila machine
        $this->vars['meter_baila'] = ElecMeter::all();
    }
    public function graph()
    {

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'electricity');
        $this->pageTitle = "Electricity Meter Reading Ekurhuleni";
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");
        $data = array();
        $lineData = array();
        $lineData2 = array();
        $kva = array();
        $kvarh = array();
        $kwh = array();
        $pf = array();
        $total_kva = 0;
        $total_kwh = 0;
        $total_kvarh = 0;
        $total_pf = 0;
        $counter = 0;
        $datacounter = array();
        $enddate = null;
        $startdate = null;
        $monthly = null;
        $weekly = null;
        $daily = null;

        $tabledata = array();
        if(\Input::has('enddate')){
            $enddate = \Input::get('enddate');
        }else{
            $enddate = Carbon::now()->setTime(00, 00, 00);
        }

        if(\Input::has('startdate')){
            $startdate = \Input::get('startdate');

        }else{
            $current = Carbon::now();
            $startdate = $current->addDays(-10)->setTime(00, 00, 00);;
        }

        if(\Input::has('monthly')){
            $startdate = \Input::get('monthly');
        }else{
            $current = Carbon::now();
            $monthly = $current->addMonths(11)->setTime(00, 00, 00);;
        }

        if(\Input::has('weekly')){
            $startdate = \Input::get('weekly');
        }else{
            $current = Carbon::now();
            $weekly = $current->addWeeks(4)->setTime(00, 00, 00);;
        }

        if(\Input::has('daily')){
            $startdate = \Input::get('daily');
        }else{
            $current = Carbon::now();
            $daily = $current->addDays(30)->setTime(00, 00, 00);;
        }

        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;
        $this->vars['monthly'] = $monthly;
        $this->vars['weekly'] = $monthly;
        $this->vars['daily'] = $daily;

        $_SESSION["makestart"] = $startdate;
        $_SESSION["makeend"] = $enddate;

        $meterreading = ElecModel::whereBetween('rdate', array($startdate, $enddate, $monthly,$weekly,$daily))->orderBy('rdate')->get();
        $reading2021 = ElecModel::whereDate('rdate', '>', '2020-12-31 23:59:00')->whereDate('rdate', '<', '2021-12-31 23:59:00')->orderBy('rdate')->get();
        $reading2022 = ElecModel::whereDate('rdate', '>', '2021-12-31 23:59:00')->whereDate('rdate', '<', '2022-12-31 23:59:00')->orderBy('rdate')->get();

        foreach ($meterreading as $mykey => $value)
        {
            $combinedDT = date('Y-m-d H:i:s', strtotime("$value->rdate $value->rtime"));
            $createdAt = Carbon::parse($combinedDT);
            $datetri = $createdAt->format('d-m-Y H').":0";#date("d/m/Y", $dates);
            $date_ =  $datetri;#     "".(($test *1000) + (2*3600*1000));

            $line = "kwh";
            $data[$line][$date_] = (double)$value->kwh;
            $total_kwh += $value->kwh;
            $kwh[] = $value->kwh;

            $line = "kVArh";
            $data[$line][$date_] = (double)$value->kVArh;
            $total_kvarh += $value->kVArh;
            $kvarh[] = $value->kVArh;

            $line = "kva";
            $data[$line][$date_] = (double)$value->kva;
            $total_kva += $value->kva;
            $kva[] = $value->kva;

            $line = "pf";
            $data[$line][$date_] = (double)$value->pf;
            $total_pf += $value->pf;
            $pf[] = $value->pf;
            $counter++;

        }

        $average_pf = $counter != 0 ? $total_pf / $counter : 0;
        $average_kva = $counter != 0 ? $total_kva / $counter : 0;
        $average_kwh = $counter != 0 ? $total_kwh / $counter : 0;
        $average_kvarh = $counter != 0 ? $total_kvarh / $counter : 0;

        $stats = array();
        $lines = array();
        $lines2 = array();
        foreach ($data as $name => $arrdata) {
            $content = array();
            foreach ($arrdata as $key => $value) {
                $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $value );
            }
            $stats[] = array('name' =>  $name , 'data' => $content);
        }

        $electric = \Bt\Maintenance\Models\Electricbill::all();
        $bill = array();
        foreach ($electric as $ele){
            $datetouse = new \DateTime($ele->date);
            $month = $datetouse->format('M');
            $year = $datetouse->format('Y');
            if($year == '2021'){
                $bill[$month]["2021"] = $ele->bill;
            }
            else{
                $bill[$month]["2022"] = $ele->bill;
            }

        }
        foreach($reading2021 as $mykey => $value){
            $date_made = new \DateTime($value->rdate);
            $date_ =  $date_made->format('M');#     "".(($test *1000) + (2*3600*1000));

            $datacounter['2021'][$date_] =  (isset($datacounter['2021'][$date_])?$datacounter['2021'][$date_]:0) + 1;

            $line = "kwh 2021";
            $lineData["spline"][$line][$date_] = (isset($lineData["spline"][$line][$date_])? $lineData["spline"][$line][$date_]:0) + (double)$value->kwh;

            $line = "kVArh 2021";
            $lineData["spline"][$line][$date_] = (isset($lineData["spline"][$line][$date_])?$lineData["spline"][$line][$date_]:0) + (double)$value->kVArh;

            $line = "kva 2021";
            $lineData["spline"][$line][$date_] = (isset($lineData["spline"][$line][$date_])? $lineData["spline"][$line][$date_]:0) + (double)$value->kva;

            $line = "pf 2021";
            $lineData["spline"][$line][$date_] = (isset($lineData["spline"][$line][$date_])?$lineData["spline"][$line][$date_]:0)+(double)$value->pf;
        }

        foreach($reading2022 as $mykey => $value){
            $date_made = new \DateTime($value->rdate);
            $date_ =  $date_made->format('M');#     "".(($test *1000) + (2*3600*1000));
            $datacounter['2022'][$date_] =  (isset($datacounter['2022'][$date_])?$datacounter['2022'][$date_]:0) + 1;

            $line = "kwh 2022";
            $lineData2["spline"][$line][$date_] = (isset($lineData2["spline"][$line][$date_])? $lineData2["spline"][$line][$date_]:0) + (double)$value->kwh;

            $line = "kVArh 2022";
            $lineData2["spline"][$line][$date_] = (isset($lineData2["spline"][$line][$date_])?$lineData2["spline"][$line][$date_]:0) + (double)$value->kVArh;

            $line = "kva 2022";
            $lineData2["spline"][$line][$date_] = (isset($lineData2["spline"][$line][$date_])? $lineData2["spline"][$line][$date_]:0) + (double)$value->kva;

            $line = "pf 2022";
            $lineData2["spline"][$line][$date_] = (isset($lineData2["spline"][$line][$date_])?$lineData2["spline"][$line][$date_]:0)+(double)$value->pf;
        }

        foreach ($lineData as $type => $arrdata) {
            foreach ($arrdata as $name => $namevalue)
            {
                $content = array();
                if($name !== "kwh 2021"){
                    foreach ($namevalue as $key => $value) {
                        if(isset($datacounter['2021'][$key])){
                            $avg = $value/$datacounter['2021'][$key];

                            $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $avg);
                            $myname = $name;
                            str_replace("2021","", $myname);
                            $tabledata[$key][$myname] = $avg;
                        }
                    }
                    $lines[] = array('type'=> $type, 'name' =>  $name , 'data' => $content);
                }else{
                    foreach ($namevalue as $key => $value) {
                        $avg = $value;
                        $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $avg);
                        $myname = $name;
                        $tabledata[$key][$myname] = $avg;
                    }
                    $lines[] = array('type'=> $type, 'name' =>  $name , 'data' => $content);
                }


            }
        }
        foreach ($lineData2 as $type => $arrdata) {
            foreach ($arrdata as $name => $namevalue)
            {
                $content = array();
                if($name !== "kwh 2022"){
                    foreach ($namevalue as $key => $value) {
                        if(isset($datacounter['2022'][$key])){
                            $avg = $value/$datacounter['2022'][$key];

                            $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $avg);
                            $myname = $name;
                            str_replace("2022","", $myname);
                            $tabledata[$key][$myname] = $avg;
                        }
                    }
                    $lines[] = array('type'=> $type, 'name' =>  $name , 'data' => $content);
                }else{
                    foreach ($namevalue as $key => $value) {
                        $avg = $value;
                        $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $avg);
                        $myname = $name;
                        $tabledata[$key][$myname] = $avg;
                    }
                    $lines[] = array('type'=> $type, 'name' =>  $name , 'data' => $content);
                }

            }
        }
        $mon = array();
        $months = array();
        $deli = array();
        $enddate = Carbon::now();
        $current = Carbon::now();
        $startdate = "2021/01/01";
        $w =  \Bt\Production\Models\Schedule::select(
            DB::raw("sum(target_kg_processed) as target_kg_processed"),
            DB::raw("sum(total_kg_processed) as total_kg_processed"),
            DB::raw("sum(weight_scrap_kg) as weight_scrap_kg"),
            DB::raw("sum(over_weight_kg) as over_weight_kg"),
            DB::raw("sum(target_units_produced) as target_units_produced"),
            DB::raw("sum(total_units_produced) as total_units_produced"),
            DB::raw("sum(total_units_passed_qc) as total_units_passed_qc"),

            DB::raw("week(production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Monday'), '%x %v %W')  as outyear"))
            ->whereBetween('production_date', array($startdate, $enddate." 00:00:00"))
            ->groupBy("outweek","outyear")
            ->orderBy("outyear",'desc')
            ->orderBy("outweek",'desc')
            ->get();

        foreach ($w as $key => $value) {
            $myform = new \DateTime($value->outyear . " 00:00:00");
            $year = $myform->format('Y');
            $monther = $myform->format('M');
            $k =  $monther. $year;

            $mon[$k]["total_kg_processed"] = (isset($mon[$k]["total_kg_processed"])?$mon[$k]["total_kg_processed"]:0) + $value->total_kg_processed;
        }

        $this->vars['bill'] = $bill;
        $this->vars['schedules'] = $meterreading;
        $this->vars['kgs'] = $mon;
        $this->vars['stats'] = $stats;
        $this->vars['lines'] = $lines;
        $this->vars['tableData'] = $tabledata;
        $this->vars['averagekva'] = $average_kva;
        $this->vars['averagepf'] = $average_pf;
        $this->vars['averagekwh'] = $average_kwh;
        $this->vars['averagekvarh'] = $average_kvarh;


        $this->vars['maxpf'] = !empty($pf) ? max($pf) : 0;
        $this->vars['maxkva'] = !empty($kva) ? max($kva) : 0;
        $this->vars['maxkvarh'] = !empty($kvarh) ? max($kvarh) : 0;
        $this->vars['maxkwh'] = !empty($kwh) ? max($kwh) : 0;

        $this->vars['minpf'] = !empty($pf) ? min($pf) : 0;
        $this->vars['minkva'] = !empty($kva) ? min($kva) : 0;
        $this->vars['minkvarh'] = !empty($kvarh) ? min($kvarh) : 0;
        $this->vars['minkwh'] = !empty($kwh) ? min($kwh) : 0;

    }
    function weekOfMonth($date) {
        // estract date parts
        list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));

        // current week, min 1
        $w = 1;

        // for each day since the start of the month
        for ($i = 1; $i < $d; ++$i) {
            // if that day was a sunday and is not the first day of month
            if ($i > 1 && date('w', strtotime("$y-$m-$i")) == 0) {
                // increment current week
                ++$w;
            }
        }

        // now return
        return $w;
    }

    public function showPDF()
    {
        if(!isset($_SESSION['makeend'])){
            return "Error";
        }
        //Here we are getting all the readings from a date range
        $electricity_usage = array();
        $machineheader = array();
        $totalsarr = array();
        $totalweek = array();
        $enddate = $_SESSION['makeend'];
        $startdate = $_SESSION['makestart'];
        $readings = ElecModel::whereBetween('rdate', array($startdate, $enddate))->orderBy('meter_no', 'desc')->orderBy('rdate')->get();

        $monthstart = date("d F",strtotime($startdate));
        $monthend = date("d F",strtotime($enddate));



        foreach ($readings as $reading){
            #Get and validate data for electcicity
            if(!empty($reading->meter)) {
                # Get all KWH-------------------------
                #Get Week No
                $machine_id = $reading->meter->id;
                $machine_name = $reading->meter->name;

                $date = new \DateTime($reading->rdate);
                $week_no = $date->format('W') . '_'. $date->format('Y');
                $electricity_usage[$week_no]['name'] = $date->format('W') . '/'. $date->format('M/Y');;

                $electricity_usage[$week_no]['data'][$machine_id]['elec'] = (isset($electricity_usage[$week_no]['data'][$machine_id]['elec'])?$electricity_usage[$week_no]['data'][$machine_id]['elec']:0) + $reading->kwh;
                $electricity_usage[$week_no]['data'][$machine_id]['cost'] = (isset($electricity_usage[$week_no]['data'][$machine_id]['cost'])?$electricity_usage[$week_no]['data'][$machine_id]['cost']:0) + $reading->blended_rkwh;

                $btline_id = 0;
                if(isset($reading->meter->btline->id)){
                    $btline_id = $reading->meter->btline->id;
                    $btline_name = $reading->meter->btline->name;
                    $machineheader[$machine_id] = $machine_name . ' (' . $btline_name . ')';
                }else{
                    $machineheader[$machine_id] = $machine_name;
                }

            }
            if($machine_id != 7) {
                $totalweek[$week_no]['elec'] = (isset($totalweek[$week_no]['elec']) ? $totalweek[$week_no]['elec'] : 0) + $reading->kwh;
                $totalweek[$week_no]['cost'] = (isset($totalweek[$week_no]['cost']) ? $totalweek[$week_no]['cost'] : 0) + $reading->blended_rkwh;
            }
            $totalsarr[$machine_id]['elec'] =  (isset($totalsarr[$machine_id]['elec'])?$totalsarr[$machine_id]['elec']:0) + $reading->kwh;
            $totalsarr[$machine_id]['cost'] =  (isset($totalsarr[$machine_id]['cost'])?$totalsarr[$machine_id]['cost']:0) + $reading->blended_rkwh;

        }

          // $controlsheets = ControlSheet::whereBetween('opendate', array($startdate, $enddate))->whereHas('btline', function ($query) use($btline_id){
          //       $query->where('id', $btline_id);
          //   })->get();

        $controlsheets = ControlSheet::whereBetween('opendate', array($startdate, $enddate))->get();

            if(!empty($controlsheets)){
                foreach ($controlsheets as $controlsheet){

                    if(!empty($controlsheet->scheduleday) && !empty($controlsheet->btline)){

                        $machine_id = $controlsheet->btline->bt_meter_id;
                        if($machine_id > 0){
                            $date = new \DateTime($controlsheet->opendate);
                            $week_no = $date->format('W') . '_'. $date->format('Y');;
                            $electricity_usage[$week_no]['data'][$machine_id]['production'] = (isset($electricity_usage[$week_no]['data'][$machine_id]['production'])?$electricity_usage[$week_no]['data'][$machine_id]['production']:0) + $controlsheet->scheduleday->total_kg_processed;
                            if($machine_id != 7) {
                                $totalsarr[$machine_id]['production'] = (isset($totalsarr[$machine_id]['production']) ? $totalsarr[$machine_id]['production'] : 0) + $controlsheet->scheduleday->total_kg_processed;
                                $totalweek[$week_no]['production'] = (isset($totalweek[$week_no]['production']) ? $totalweek[$week_no]['production'] : 0) + $controlsheet->scheduleday->total_kg_processed;
                            }
                        }
                    }

                }
            }
        $sort_machine = array_sort($machineheader);
            $tarrif = Tarrif::orderBy('start_date', 'desc')->get();
        $pdf = PDF::loadView('bt.maintenance::pdfReading',array('readings'=> $readings,'electricity_usage' => $electricity_usage, 'start'=> $monthstart, 'end' => $monthend, 'machineheading' => $sort_machine, 'totals' => $totalsarr, 'totalweek' => $totalweek, 'tarrifs' => $tarrif));
        return $pdf->setPaper('a3', 'landscape')->download("Electric Meter Reading-".$monthstart . "-" . $monthend .".pdf");

    }

    public function showYearly()
    {
        #Name: Farai Chakarisa
        #Decsription: Function to download electricity readings as PDF
        #Changes: Remove trace_log()
        $weekly = array();
        $enddate = $_SESSION['makeend'];
        $startdate = $_SESSION['makestart'];
        $readings = ElecModel::whereBetween('rdate', array($startdate, $enddate))->orderBy('rdate')->get();

        #Loop through filtered electricity readings and accumulate them by week
        foreach ($readings as $mykey => $reading) {
            $daynum = $this->weekOfMonth($reading->rdate);
            $month_of_year = date("m",strtotime($reading->rdate));
            $weekly[$daynum]['date'] = $month_of_year;
            $weekly[$daynum]['kva'][$mykey] = $reading->kva;
            $weekly[$daynum]['kvacount'] = (isset($weekly[$daynum]['kvacount'])?$weekly[$daynum]['kvacount']:0) + 1;
            $weekly[$daynum]['kvaaverage'] = (isset($weekly[$daynum]['kvaaverage'])?$weekly[$daynum]['kvaaverage']:0) + $reading->kva;
            $weekly[$daynum]['pf'][$mykey] = $reading->pf;
            $weekly[$daynum]['pfcount'] = (isset($weekly[$daynum]['pfcount'])? $weekly[$daynum]['pfcount']:0) + 1;
            $weekly[$daynum]['pfaverage'] = (isset($weekly[$daynum]['pfaverage'])? $weekly[$daynum]['pfaverage']:0) + $reading->pf;
            $weekly[$daynum]['pfmax'] = max((isset($weekly[$daynum]['pfmax'])? $weekly[$daynum]['pfmax']:0), $reading->pf);
            $weekly[$daynum]['pfmin'] = min((isset($weekly[$daynum]['pfmin'])? $weekly[$daynum]['pfmin']:1), $reading->pf);
            $weekly[$daynum]['kwh'][$mykey] = $reading->kwh;
            $weekly[$daynum]['kwhcount'] =  (isset($weekly[$daynum]['kwhcount'])?$weekly[$daynum]['kwhcount']:0) + 1;
            $weekly[$daynum]['kwhaverage'] =  (isset($weekly[$daynum]['kwhaverage'])?$weekly[$daynum]['kwhaverage']:0) + $reading->kwh;
            $weekly[$daynum]['kVArh'][$mykey] = $reading->kVArh;
            $weekly[$daynum]['kVArhcount'] = (isset($weekly[$daynum]['kVArhcount'])?$weekly[$daynum]['kVArhcount']:0) + 1;
            $weekly[$daynum]['kVArhaverage'] = (isset($weekly[$daynum]['kVArhaverage'])?$weekly[$daynum]['kVArhaverage']:0) + $reading->kVArh;
        }

        $pdf = PDF::loadView('bt.maintenance::pdfYearly',array('readings'=> $readings,'weekly' => $weekly));
        return $pdf->download("Electric Meter Reading - Yearly". ".pdf");
    }

    public function onMachine(){
        if(!empty(\Input::get('machine'))){
            $_SESSION['machine'] = \Input::get('machine');
        }
        \Flash::success('Machine has been chosen');
    }
}
