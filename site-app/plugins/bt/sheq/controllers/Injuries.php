<?php namespace Bt\SHEQ\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\SHEQ\Models\Injuries as Injury;
use Carbon\Carbon;
use Input;
/**
 * Injuries Back-end Controller
 */
class Injuries extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'injuries');
    }

    public function stats(){

        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");

        $enddate = null;
        $startdate = null;
        if(Input::has('enddate')){
            $enddate = Input::get('enddate');
        }else{
            $enddate = Carbon::now()->setTime(00, 00, 00);
        }

        if(Input::has('startdate')){
            $startdate = Input::get('startdate');
        }else{
            $current = Carbon::now();
            $startdate = $current->addDays(-10)->setTime(00, 00, 00);;
        }


        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;


        $this->pageTitle = "Injury Status ";
        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'injury');
        $schedules = Injury::whereBetween('injurydate', array($startdate, $enddate))->orderBy('injurydate')->get();
        $data = array();
        $pending  = 0;
        $closed  = 0;
        $hold  = 0;
        $small  = 0;
        $minor  = 0;
        $major  = 0;

        foreach ($schedules as $skey => $schedule) {
            $createdAt = Carbon::parse($schedule->injurydate);
            $datetri = $createdAt->format('d-m-Y H').":0";
            $test =  Carbon::parse($datetri)->timestamp;
            $date_ =  $datetri;
            if ($schedule->status == 1) {
                $line = "Status Pending";
                $data[$line][$date_] = 1;

                $pending += 1;
            }
            if ($schedule->status == 2)
            {
                $line = "Status Hold";
                $data[$line][$date_] = 1;

                $hold += 1;
            }
            if ($schedule->status == 3) {
                $line = "Status Closed";
                $data[$line][$date_] = 1;

                $closed += 1;
            }
            if($schedule->scale_of_injury == 1) {
                $line = "Minor Injury";
                $data[$line][$date_] = 1;

                $small += 1;
            }
            if($schedule->scale_of_injury == 2) {
                $line = "Moderate Injury";
                $data[$line][$date_] = 1;

                $minor += 1;
            }
            if($schedule->scale_of_injury == 3) {
                $line = "Major Injury";
                $data[$line][$date_] = 1;

                $major += 1;
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

        $this->vars['schedules'] = $schedules;
        $this->vars['stats'] = $stats;
        $this->vars['avaragestatus'] = 0;
        $this->vars['scale'] = 0;
        if(isset($data["Status Pending"]) && isset($data["Status Hold"]) && isset($data["Status Closed"]))
            $this->vars['avaragestatus'] = ($pending + $hold + $closed) /count($data["Status Pending"] + $data["Status Hold"] + $data["Status Closed"]);
        if(isset($data["Scale Of Injury"]))
            $this->vars['scale'] = ($small + $minor + $major)/count($data["Scale Of Injury"]);
    }
}
