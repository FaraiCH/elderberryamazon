<?php namespace Bt\Factory\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Assettype Back-end Controller
 */
class Assettype extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ImportExportController',
        'Backend.Behaviors.ListController'
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

        BackendMenu::setContext('Bt.Factory', 'factory', 'assettype');
    }
}