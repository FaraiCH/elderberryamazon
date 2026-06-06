<?php namespace Bt\CRM\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Client Back-end Controller
 */
class Client extends Controller
{
     public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = '$/bt/sales/controllers/client/config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.CRM', 'crm', 'client');
    }
}
