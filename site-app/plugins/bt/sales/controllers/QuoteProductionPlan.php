<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use Bt\Sales\Models\QuoteProductionPlan as PlanModel;

/**
 * Quote Production Plan Backend Controller
 */
class QuoteProductionPlan extends Controller
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

        BackendMenu::setContext('Bt.Sales', 'sales', 'quoteproductionplan');
    }

    public function overview(){

        $list = [];

        $obj = PlanModel::all();

        foreach ($obj as $key => $value) {
            $p = $value->item->product;
            $k = $p->PNRating->id."-".$p->Diameter->id;
            $name =  $p->PNRating->name." ".$p->Diameter->name."MM"; 
            
            $list[$k]["name"] = $name;

            $list[$k]["obj"][] = $value;

            $l = $value->item->unitlength;

             $list[$k]["target"] = 15000;

            $list[$k]["totalweight"] = isset($list[$k]["totalweight"])?$list[$k]["totalweight"]:0 + ($p->production_value * $l * $value->units) ;

            $per = 0;
            if( $list[$k]["totalweight"] > 0)
                $per = ($list[$k]["totalweight"]/$list[$k]["target"]) * 100;
            
            $list[$k]["perc"] = $per; 

        }

       
        $this->vars['list'] = $list;


    }
}
