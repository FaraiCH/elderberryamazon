<?php namespace Bt\Hr\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Employee Contract Backend Controller
 */
class EmployeeContract extends Controller
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

        BackendMenu::setContext('Bt.HR', 'hr', 'employeecontract');
    }
}
