<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Running Parameter Backend Controller
 */
class RunningParameter extends Controller
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

        BackendMenu::setContext('Bt.Production', 'production', 'runningparameter');
    }
}
