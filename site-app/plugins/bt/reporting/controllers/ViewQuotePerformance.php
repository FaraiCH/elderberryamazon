<?php namespace Bt\Reporting\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * View Quote Performance Backend Controller
 */
class ViewQuotePerformance extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.ImportExportController',
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_export.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Reporting', 'reporting', 'viewquoteperformance');
    }
}
