<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Sales\Models\Fabrication as FabricationModel;
use Carbon\Carbon;

/**
 * Fabrication Backend Controller
 */
class Fabrication extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.RelationController'

    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Sales', 'sales', 'fabrication');
        $this->addCss("/plugins/bt/sales/assets/css/fabrication.css", "1.0.0");

        // Items
        if(!isset($_SESSION['srnstart'])){
            $this->vars['srnstart'] = Carbon::now()->subDays(30);
            $this->vars['srneend'] = Carbon::now();
        }else{
            $this->vars['srnstart'] = $_SESSION['srnstart'];
            $this->vars['srneend'] = $_SESSION['srneend'];
        }

        //Srn Items
        $this->vars['srnlist'] = FabricationModel::whereHas('quote', function ($query){
            $query->whereNotNull('ponumber');
        })->orderBy('id', 'desc')->get();
    }

    public function onDateItemFilter(){
        if(!empty(\Input::get('srnstart'))){
            $_SESSION['srnstart'] = \Input::get('srnstart');
            $_SESSION['srneend'] = \Input::get('srneend');
        }
        if(\Input::has('srn') && \Input::get('srn') > 0){
            $_SESSION['srn'] = \Input::get('srn');
        }else{
            $_SESSION['srn'] = '';
        }
        \Flash::success('Fabrication filters have been applied');
    }

    public function exportitem(){
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap4.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->pageTitle = "Export Fabrication Items";
        BackendMenu::setContext('Bt.Sales', 'sales', 'fabrication');
    }
}
