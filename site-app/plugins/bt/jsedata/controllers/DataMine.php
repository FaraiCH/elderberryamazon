<?php namespace Bt\JSEData\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel;

// use Excel;
use Input;
// use Vdomah\Excel\Classes\Excel;
// use Illuminate\Support\Facades\Input;
#https://docs.laravel-excel.com/3.1/imports/multiple-sheets.html
use Bt\JSEData\Models\DataMineImportMultiple;
use Bt\JSEData\Models\DataMineImportShare;
/**
 * Data Mine Back-end Controller
 */
class DataMine extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.JSEData', 'jsedata', 'datamine');
    }

    public function import(){

    }

    public function onImportFile(){

     
        Excel::import(new DataMineImportMultiple, request()->file('importfile'));

        // return [
        //     '#scans' => $this->makePartial('p_scans')
        // ];
    }


    public function onImportFileShareData(){

     
        Excel::import(new DataMineImportShare, request()->file('importfile'));

        // return [
        //     '#scans' => $this->makePartial('p_scans')
        // ];
    }
}
