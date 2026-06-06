<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Scrap Codes Back-end Controller
 */
class ScrapCodes extends Controller
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

        BackendMenu::setContext('Bt.Production', 'production', 'scrapcodes');
    }
}
