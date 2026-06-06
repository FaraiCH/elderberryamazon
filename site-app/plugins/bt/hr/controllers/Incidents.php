<?php namespace Bt\HR\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Incidents Back-end Controller
 */
class Incidents extends Controller
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

        BackendMenu::setContext('Bt.HR', 'hr', 'incidents');
    }
}
