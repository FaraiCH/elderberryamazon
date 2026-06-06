<?php namespace Bt\SHEQ\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Question Backend Controller
 */
class Question extends Controller
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

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'question');
        // $this->addCss("/plugins/bt/plcommon/assets/css/customform.css", "1.0.1");
        // $this->addCss("/plugins/bt/plcommon/assets/css/bigsidemenu.css", "1.0.1");
    }
}
