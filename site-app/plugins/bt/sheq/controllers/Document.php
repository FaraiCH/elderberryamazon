<?php namespace Bt\SHEQ\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\SHEQ\Models\Category; 
/**
 * Document Back-end Controller
 */
class Document extends Controller
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

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'document');
    }

    public function finddoc(){
        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'finddoc');
        $this->pageTitle = "Back Order";
        $this->vars['list'] = Category::all();

    }
}
