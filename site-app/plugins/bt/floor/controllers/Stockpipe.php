<?php namespace Bt\Floor\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Stockpipe Back-end Controller
 */
class Stockpipe extends Controller
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

        BackendMenu::setContext('Bt.Floor', 'floor', 'stockpipe');
    }
}
