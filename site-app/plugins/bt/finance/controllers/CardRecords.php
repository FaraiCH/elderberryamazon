<?php namespace Bt\Finance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Card Records Back-end Controller
 */
class CardRecords extends Controller
{

    public $requiredPermissions = ['bt.finance.cardrecords'];
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ImportExportController',
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Finance', 'finance', 'cardrecords');
    }
}
