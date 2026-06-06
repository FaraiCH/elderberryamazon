<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
use Session;
use Bt\Sales\Models\Newquote;
use Input;
use Flash;
/**
 * Quoteitems Back-end Controller
 */
class Quoteitems extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
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

        BackendMenu::setContext('Bt.Sales', 'sales', 'quoteitems');

        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap4.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->vars['quotelist'] = Newquote::with('items')->where('ponumber', "!=", null)->orderBy('id', 'desc')->get();
    }

    public function onDateFilter(){
        if(\Input::has('quote') && Input::get('quote') > 0){
            $_SESSION['quote'] = Input::get('quote');
            Flash::success('Quote has been applied');
        }else{
            Flash::warning('Nothing has been applied');
        }
    }

    public function exportitem(){
        $this->pageTitle = "Export Quote Items";
        BackendMenu::setContext('Bt.Sales', 'sales', 'quoteitems');
    }
}
