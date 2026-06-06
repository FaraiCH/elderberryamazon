<?php namespace Bt\JSEData\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Property Back-end Controller
 */
class Property extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
     public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ImportExportController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';
     public $importExportConfig = 'config_import_export.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.JSEData', 'jsedata', 'property');
    }
}
