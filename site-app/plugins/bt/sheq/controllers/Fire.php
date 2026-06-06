<?php namespace Bt\Sheq\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Fire Back-end Controller
 */
class Fire extends Controller
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

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'fire');
    }
}
