<?php namespace Bt\Maintenance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Tools Checklist Back-end Controller
 */
class ToolsChecklist extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'toolschecklist');
    }
}
