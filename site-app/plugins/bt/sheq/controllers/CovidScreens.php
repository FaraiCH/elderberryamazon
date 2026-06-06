<?php namespace Bt\SHEQ\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\SHEQ\Models\CovidScreens as Covid;
use Carbon\Carbon;
use Input;
/**
 * Covid Screens Back-end Controller
 */
class CovidScreens extends Controller
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

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'covidscreens');
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


        $this->pageTitle = "Covid Status";
        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'covidscreens');


        $schedules = Covid::whereBetween('capturedate', array($startdate, $enddate))->orderBy('capturedate')->get();

        $data = array();

        $total  = 0;
        $total_u  = 0;
        $total_t = 0;
        $total_i = 0;
        foreach ($schedules as $skey => $schedule) {

            $createdAt = Carbon::parse($schedule->capturedate);
            $datetri = $createdAt->format('d-m-Y H').":0";
            $test =  Carbon::parse($datetri)->timestamp;
            $date_ =  $datetri;

            $line = "Employees Screened";

            $data[$line][$date_] = (int)$schedule->no_screen;

            $total += $schedule->no_screen;

            $line = "Employees Who Declared Symptoms";

            $data[$line][$date_] = (int)$schedule->potential_infection;

            $total_t += $schedule->potential_infection;

            $line = "No Of Infected";

            $data[$line][$date_] = (int)$schedule->no_infected;

            $total_i += $schedule->no_infected;


            $line = "Notes";

            $data[$line][$date_] = (int)$schedule->note;

            $line = "Highest Temperature";

            $data[$line][$date_] = (int)$schedule->highest_temperature;


            $total_u += $schedule->highest_temperature;

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
        $this->vars['avarage'] = 0;
        $this->vars['infected'] = 0;
        $this->vars['symptoms'] = 0;
        $this->vars['temp'] = 0;
        if(isset($data["Employees Screened"]))
            $this->vars['avarage'] = (int)($total/count($data["Employees Screened"]));
        if(isset($data["Employees Who Declared Symptoms"]))
            $this->vars['symptoms'] = (int)($total_t/count($data["Employees Who Declared Symptoms"]));
        if(isset($data["No Of Infected"]))
            $this->vars['infected'] = (int)($total_i/count($data["No Of Infected"]));
        if(isset($data["Highest Temperature"]))
            $this->vars['temp'] = (int)($total_u/count($data["Highest Temperature"]));

    }
}
