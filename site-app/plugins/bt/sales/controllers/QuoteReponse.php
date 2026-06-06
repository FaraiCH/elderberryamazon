<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;

/**
 * Quote Reponse Backend Controller
 */
class QuoteReponse extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.ImportExportController',
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';
    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Sales', 'sales', 'quotereponse');
        if(!isset($_SESSION['startresp'])){
            $this->vars['startresp'] = Carbon::now()->subDays(30);
            $this->vars['endresp'] = Carbon::now();
        }else{
            $this->vars['startresp'] = $_SESSION['startresp'];
            $this->vars['endresp'] = $_SESSION['endresp'];
        }

     
        // $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        // $this->addJs("/plugins/bt/production/assets/js/popthis.js", "1.0.0");
        // $this->addJs("/plugins/bt/production/assets/js/scheduleinput.js", "1.0.0");

    }

    

      public function listExtendQuery($query, $definition = null)
    {
        $query->where('quote_status_id',10)->whereHas('quote', function ($query) {

                          $query->whereNotNUll('ponumber');
                          $query->where('ponumber','<>','');
                    });
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

    public function onDateFilter(){
        if(!empty(\Input::get('startresp'))){
            $_SESSION['startresp'] = \Input::get('startresp');
            $_SESSION['endresp'] = \Input::get('endresp');
        }
        \Flash::success('Date filters have been applied');

    }

}
