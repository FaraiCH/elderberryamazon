<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Purchase Back-end Controller
 */
class Purchase extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Sales', 'sales', 'purchase');
    }

      public function makeThumb($src_file_name){

        $supported_image = array('gif','jpg','jpeg','png');
        $supported_pdf = array('pdf');
        $ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
        if (in_array($ext, $supported_image)) {
            return ' <img src="'.$src_file_name.'" style="width: 100%;   > ';
        }elseif (in_array($ext, $supported_pdf)) {
            return ' <embed src="'.$src_file_name.'" width="100%"  height="100%" /> ';
        }
        return '';
    }

}
