<?php namespace Bt\HR\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Designation Back-end Controller
 */
class Designation extends Controller
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

        BackendMenu::setContext('Bt.HR', 'hr', 'designation');
    }
}
