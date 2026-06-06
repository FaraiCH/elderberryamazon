<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Schedule as ScheduleModel;
use Carbon\Carbon;
use Session;
use Input;
use Flash;

/**
 * Schedule Back-end Controller
 */
class Schedule extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ImportExportController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_export.yaml';


    public function __construct()
    {
        parent::__construct();
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap4.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");

        BackendMenu::setContext('Bt.Production', 'production', 'schedule');

        //Export Filter
        if (Session::has('schstart') && Session::get('schstart') > 0) {
            $this->vars['schstart'] = Session::get('schstart');
            $this->vars['schend'] = Session::get('schend');
        } else {
            $this->vars['schstart'] = Carbon::now()->subDays(30);
            $this->vars['schend'] = Carbon::now();
        }
    }

    public function onUpdatePrice()
    {
        $obj = ScheduleModel::orderBy('id', 'DESC')->take(60)->get();

        foreach ($obj as $key => $value) {
            $weight = 0;
            if (isset($value->pipe->quoteitems->product->value)) {
                    $weight_of_p = $value->pipe->quoteitems->product->value;
            }


                    $unitlength = isset($value->pipe->quoteitems->unitlength)?$value->pipe->quoteitems->unitlength:0;
                    $unitprice = isset($value->pipe->quoteitems->unitprice)?$value->pipe->quoteitems->unitprice:0;

                    $total_material_value = 0;
                    $total_material_weight = 0;
                    $total_scrap_cost = 0;
            foreach ($value->usedmaterials as $key_ => $value_) {
                if (isset($value_->receiving->pricekg)) {
                    $total_material_value = $total_material_value + ($value_->kg * $value_->receiving->pricekg);

                    $total_material_weight = $total_material_weight + $value_->kg;
                }
            }

                    ##CULCULATE MATERIAL COST PER KG
            if ($value->total_units_passed_qc > 0 &&  $total_material_value > 0 && $total_material_weight) {
                $mcost_pkg =  $total_material_value/$total_material_weight; ##cost per  C14
                $cost_p_meter = $mcost_pkg * $weight_of_p; ##Weight per meter
                $total_cost = $total_material_weight;

                $cost_per_pipe = $unitlength * $cost_p_meter;
                $total_cost_schedule = $cost_per_pipe * $value->total_units_passed_qc;

                $value->priceperpipe = $cost_per_pipe;
                $value->production_costperkg = $mcost_pkg;
                $value->materialvalue = $total_material_value;
                $value->unitprice = $unitprice;
                $value->total_cost_schedule = $total_cost_schedule;

                $value->total_scrap_cost = $value->weight_scrap_kg*$mcost_pkg;
                $value->save();
            }
        }
        \Flash::success('On Update');
    }

    public function onPublishExtraPipes()
    {
           \Flash::error('Process invalid');
    }

    public function onDateFilter()
    {
        if (\Input::has('schstart') && Input::get('schstart') > 0) {
            Session::put('schstart', \Input::get('schstart'));
            Session::put('schend', \Input::get('schend'));
            Flash::success('Date filters have been applied');
        } else {
            Flash::warning('Nothing has been applied');
        }
    }
}
