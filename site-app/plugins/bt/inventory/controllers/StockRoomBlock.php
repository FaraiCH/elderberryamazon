<?php namespace Bt\Inventory\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Stock Room Block Back-end Controller
 */
class StockRoomBlock extends Controller
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

        BackendMenu::setContext('Bt.Inventory', 'inventory', 'stockroomblock');
    }
}
