<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;

/**
 * Prodaily Backend Controller
 */
class Prodaily extends Controller
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

        BackendMenu::setContext('Bt.Production', 'production', 'prodaily');
    }

    public function sheet(){
        BackendMenu::setContext('Bt.Production', 'production', 'sheet');
        $this->pageTitle = 'Daily Production Report';
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap4.css', "1.0.0");

        $this->vars['startdate'] = Carbon::now()->format('Y-m-d');
        $startdate = \Input::get('startdate');
        if(isset($startdate)){
            $this->vars['startdate'] = \Input::get('startdate');
            $this->vars['test'] = \Bt\Production\Models\Prodaily::whereDate('date', $startdate)->first();
        }else{
            $this->vars['test'] = \Bt\Production\Models\Prodaily::whereDate('date', Carbon::today())->first();
        }
    }
}
