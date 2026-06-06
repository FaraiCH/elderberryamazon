<?php namespace Bt\Sheq\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Sheq\Models\SupplierImport;
use Maatwebsite\Excel\Facades\Excel;
use October\Rain\Support\Facades\Flash;

/**
 * Supplier Back-end Controller
 */
class Supplier extends Controller
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

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'supplier');
    }

    public function onImport()
    {
        $path = \Input::file('importfile');
        if(isset($path))
        {
            Excel::import(new SupplierImport(), $path);
            return Flash::success('Success');
        }
    }
    public function importType()
    {
        $this->pageTitle = "Supplier Import";
    }
}
