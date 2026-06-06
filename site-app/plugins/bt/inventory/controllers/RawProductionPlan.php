<?php namespace Bt\Inventory\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Raw Production Plan Backend Controller
 */
class RawProductionPlan extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.RelationController',
    ];

    public $relationConfig = 'config_relation.yaml';
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

        BackendMenu::setContext('Bt.Inventory', 'inventory', 'rawproductionplan');
    }
}
