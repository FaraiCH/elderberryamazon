<?php namespace Bt\Inventory\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Inventory\Models\Purchase;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceivingModel;
use Bt\Inventory\Models\BagBatch;

/**
 * Raw Material Receiving Back-end Controller
 */
class RawMaterialReceiving extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ImportExportController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_import_export.yaml';


    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Inventory', 'inventory', 'rawmaterialreceiving');

        $this->pageTitle = "Raw Material Receiving";
       
    }
    public function releasesummary(){
        $this->pageTitle = "Release List";
        $this->vars["products"] = RawMaterialReceivingModel::where('purchase_id','>',0)->get();

    }

}
