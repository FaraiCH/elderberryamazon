<?php namespace Bt\Logistics\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Trailer Backend Controller
 */
class Trailer extends Controller
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

        BackendMenu::setContext('Bt.Logistics', 'logistics', 'trailer');
    }
}
