<?php namespace Bt\Qc\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Qc Equipment Backend Controller
 */
class QcEquipment extends Controller
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

        BackendMenu::setContext('Bt.QC', 'qc', 'qcequipment');
    }
}
