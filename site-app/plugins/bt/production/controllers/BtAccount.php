<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Production\Models\Schedule;

/**
 * Bt Account Back-end Controller
 */
class BtAccount extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';


    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Production', 'production', 'btaccount');
    }
    public function listExtendQuery($query, $definition = null)
    {
         

        $query->whereHas('pipe', function ($query) {
            return $query->where('active', '=', 1);
        });
    }

    public function onCheckOutStock()
    {
        $obj = PipeModel::active()->orderBy('start_date', 'desc')->get();

        $x = 0;

        foreach ($obj as $key => $item) {
            $totalfloor = $item->schedules()->sum('total_units_passed_qc') - $item->schedules()->sum('onhold') - $item->delivered()->sum('units');
            if ($totalfloor <= 0) {
                  $item->active = 0;
                  $item->save();
                   $x++;
            }
        }
         \Flash::success('Checking Out = '.$x);
    }

    public function onUpdatePrice()
    {
        $obj = Schedule::orderBy('id', 'DESC')->take(60)->get();

        foreach ($obj as $key => $value) {
            $weight = 0;
            if (!empty($value->pipe->quoteitems) && isset($value->pipe->quoteitems->product->value)) {
                    $weight_of_p = $value->pipe->quoteitems->product->value;
                    $unitlength = $value->pipe->quoteitems->unitlength;
                    $unitprice = $value->pipe->quoteitems->unitprice;

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
                    ;

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
        }
        \Flash::success('On Update');
    }
}
