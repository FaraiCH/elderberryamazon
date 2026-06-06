<?php namespace Bt\Sheq\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Evacuation Back-end Controller
 */
class Evacuation extends Controller
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

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'evacuation');
    }
}
