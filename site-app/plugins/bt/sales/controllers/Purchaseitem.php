<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Sales\Models\Catalogue;

/**
 * Purchaseitem Back-end Controller
 */
class Purchaseitem extends Controller
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

        BackendMenu::setContext('Bt.Sales', 'sales', 'purchaseitem');
    }

    public function formAfterSave($model)
    {

    }
}
