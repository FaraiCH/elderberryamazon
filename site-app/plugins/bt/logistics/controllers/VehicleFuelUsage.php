<?php namespace Bt\Logistics\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
use Bt\Logistics\Models\VehicleFuelUsage as fuelmodel;
use BT\Logistics\Models\FuelType;

/**
 * Vehicle Fuel Usage Backend Controller
 */
class VehicleFuelUsage extends Controller
{
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

        BackendMenu::setContext('Bt.Logistics', 'logistics', 'vehiclefuelusage');
    }
    public function graph()
    {
        $this->pageTitle = "Vehicle Fuel Graph";


        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");

        $data = array();
        $counter = 0;
        $lineFul = null;
        $enddate = null;
        $startdate = null;
        if (\Input::has('enddate')) {
            $enddate = \Input::get('enddate');
        } else {
            $enddate = Carbon::now()->setTime(00, 00, 00);
        }

        if (\Input::has('startdate')) {
            $startdate = \Input::get('startdate');
        } else {
            $current = Carbon::now();
            $startdate = $current->addDays(-10)->setTime(00, 00, 00);
            ;
        }

        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;

        BackendMenu::setContext('Bt.Logistics', 'logistics', 'vehiclefuelusagegraph');


        $fuelusage = fuelmodel::whereBetween('date', array($startdate, $enddate))->orderBy('date')->get();

        $arrAhours = [];
        $totals = [];
        foreach ($fuelusage as $skey => $value) {
            $combinedDT = date('Y-m-d H:i:s', strtotime("$value->date "));
            $createdAt = Carbon::parse($combinedDT);
            $datetri = $createdAt->format('Y-m-d');
            $date_ =  $datetri;

            $line = $value->fueltype->name;
            $lineFul = $line. ' FuelType';
            $data[$line][$date_] = (double)$value->fuel_intake;
            $counter++;
        }

        $stats = array();
        foreach ($data as $name => $arrdata) {
            $content = array();
            foreach ($arrdata as $key => $value) {
                $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $value );
            }
            $stats[] = array('name' =>  $name , 'data' => $content);
        }

        $this->vars['fuel'] = $fuelusage;
        $this->vars['stats'] = $stats;
    }
}
