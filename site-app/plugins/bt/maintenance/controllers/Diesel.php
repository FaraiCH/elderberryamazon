<?php namespace Bt\Maintenance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Diesel Backend Controller
 */
class Diesel extends Controller
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
    public $importExportConfig = 'config_import_export.yaml';
    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'diesel');
    }
}
