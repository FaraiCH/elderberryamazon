<?php namespace Bt\Inventory\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Raw Material Recon Back-end Controller
 */
class RawMaterialRecon extends Controller
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

        BackendMenu::setContext('Bt.Inventory', 'inventory', 'rawmaterialrecon');
    }
}
