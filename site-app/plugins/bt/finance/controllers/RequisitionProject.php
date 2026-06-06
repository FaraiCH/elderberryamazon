<?php namespace Bt\Finance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Requisition Project Backend Controller
 */
class RequisitionProject extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.RelationController',
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

        BackendMenu::setContext('Bt.Finance', 'finance', 'requisitionproject');
    }
}
