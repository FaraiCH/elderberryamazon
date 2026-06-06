<?php namespace Bt\Qc\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Pipe Report Backend Controller
 */
class PipeReport extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.QC', 'qc', 'pipereport');
    }
}
