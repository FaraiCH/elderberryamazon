<?php namespace Bt\HR\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Training Type Back-end Controller
 */
class TrainingType extends Controller
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

        BackendMenu::setContext('Bt.HR', 'hr', 'trainingtype');
    }
}
