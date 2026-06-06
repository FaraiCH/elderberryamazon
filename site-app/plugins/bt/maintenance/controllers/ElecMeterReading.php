<?php namespace Bt\Maintenance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Elec Meter Reading Back-end Controller
 */
class ElecMeterReading extends Controller
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

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'elecmeterreading');
    }
}
