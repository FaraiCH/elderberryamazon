<?php namespace Bt\IT\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Job Type Back-end Controller
 */
class JobType extends Controller
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

        BackendMenu::setContext('Bt.IT', 'it', 'jobtype');
    }
}
