<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Sales\Controllers\Srn as RNController;
use Bt\Sales\Models\ReturnNote as RNModel;
/**
 * Return Note Back-end Controller
 */
class ReturnNote extends Controller
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

        BackendMenu::setContext('Bt.Sales', 'sales', 'returnnote');
    }

    public function onSendReturnNote($id = null)
    {

        $obj = RNModel::find($id);
        $test = new RNController();
       $test->onSendNotificationReturnNote($obj->srn_id);
    }


}
