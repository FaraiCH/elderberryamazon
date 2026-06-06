<?php namespace Bt\Maintenance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;

/**
 * Waterusage Back-end Controller
 */
class Waterusage extends Controller
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

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'waterusage');
    }

    public function graph()
    {
        $this->pageTitle = "Electric Meter Graph";


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

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'waterusagegraph');


        $electricmeter = \Bt\Maintenance\Models\Waterusage::whereBetween('readingdate', array($startdate, $enddate))->orderBy('readingdate')->get();

        $data = array();
        $valueToMinus = array();
        $count = 0;
        $total  = 0;
        $difference  = 0;
        $total_t = 0;
        $total_i = 0;

        foreach($electricmeter as $skey => $readingValue)
        {
            $valueToMinus[] =  (double)$readingValue->cooling_meter;

        }

        foreach ($electricmeter as $skey => $readingValue) {


            $createdAt = Carbon::parse($readingValue->readingdate);
            $datetri = $createdAt->format('d-m-Y H').":0";#date("d/m/Y", $dates);
            $date_ =  $datetri;#     "".(($test *1000) + (2*3600*1000));

            $line = "Reading";
            if(isset($valueToMinus[$count+1]))
            {
                $difference = $valueToMinus[$count+1] - (double)$readingValue->cooling_meter ;
            }
            else
            {
                $difference = (double)$readingValue->cooling_meter -  $valueToMinus[$count];
            }
            $data["column"][$line][$date_] = $difference;

            $total += $difference;

            $line = "Accumlative Reading";

            $data["spline"][$line][$date_] =  $total;

            $count++;
        }

        $stats = array();
        foreach ($data as $type => $arrdata) {
            foreach ($arrdata as $name => $namevalue)
            {
                $content = array();
                foreach ($namevalue as $key => $value) {
                    $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $value );
                }
                $stats[] = array('type'=> $type, 'name' =>  $name , 'data' => $content);
            }


        }

        $this->vars['schedules'] = $electricmeter;
        $this->vars['stats'] = $stats;


    }
}
