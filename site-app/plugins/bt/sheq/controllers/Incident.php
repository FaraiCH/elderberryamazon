<?php namespace Bt\Sheq\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;

/**
 * Incident Back-end Controller
 */
class Incident extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'incident');
    }

    public function stats()
    {
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");

        $enddate = null;
        $startdate = null;
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


        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;


        $this->pageTitle = "Incidents Status ";
        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'incidents');
        $schedules = \Bt\Sheq\Models\Incident::whereBetween('incident_date', array($startdate, $enddate))->orderBy('incident_date')->get();
        $data = array();

        foreach ($schedules as $skey => $schedule) {
            $createdAt = Carbon::parse($schedule->incident_date);
            $datetri = $createdAt->format('d-m-Y H').":0";
            $date_ =  $datetri;
            if(isset($schedule->incident_date)){
                $line = "No of Incidents";
                $data[$line][$date_] = (isset($data[$line][$date_])? $data[$line][$date_]: 0) + 1;
            }
            if(isset($schedule->invest_date)){
                $line = "Investigations";
                $data[$line][$date_] = (isset($data[$line][$date_])? $data[$line][$date_]: 0) + 1;
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
    }
}
