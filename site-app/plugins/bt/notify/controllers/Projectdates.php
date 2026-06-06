<?php namespace Bt\Notify\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Projectdates Back-end Controller
 */
class Projectdates extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $requiredPermissions = ['bt.notify.upcomingproject'];
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Notify', 'notify', 'projectdates');
    }
}
