<?php namespace Bt\QC\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Ncrtype Back-end Controller
 */
class Ncrtype extends Controller
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

        BackendMenu::setContext('Bt.QC', 'qc', 'ncrtype');
    }
}
