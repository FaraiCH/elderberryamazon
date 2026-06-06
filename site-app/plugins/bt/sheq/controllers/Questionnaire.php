<?php namespace Bt\SHEQ\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Questionnaire Backend Controller
 */
class Questionnaire extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\ReorderController::class,
         'Backend.Behaviors.RelationController'
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
    public $reorderConfig = 'config_reorder.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'questionnaire');
        // $this->addCss("/plugins/bt/plcommon/assets/css/customform.css", "1.0.1");
        // $this->addCss("/plugins/bt/plcommon/assets/css/bigsidemenu.css", "1.0.1");
    }
}
