<?php namespace Bt\Inventory\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceivingModel;
use Carbon\Carbon;
/**
 * Blended Purchase Backend Controller
 */
class BlendedPurchase extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Inventory', 'inventory', 'blendedpurchase');
    }

    public function getData($f){

        $this->addCss("/plugins/bt/reporting/assets/css/bootstrap.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/dataTables.bootstrap4.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/responsive.bootstrap4.min.css", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js", "1.0.0");
        $this->addJs("/plugins/bt/reporting/assets/js/backlaout.js", "1.0.0");

        $this->addJs("https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js", "1.0.0");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js", "1.0.0");
        $this->addJs("//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js", "1.0.0");


        $enddate = new Carbon($f->end_date);
        $startdate = new Carbon($f->locked_date);
        
        $startdate->hour = 0;
        $startdate->minute  = 0;
        $startdate->second  = 0;

       
        
        $enddate->hour = 23;
        $enddate->minute  = 59;
        $enddate->second  = 0;
      
        return RawMaterialReceivingModel::whereBetween('date_of_receipt',array($startdate, $enddate) )->orderby("date_of_receipt")->get();
        dd(RawMaterialReceivingModel::whereBetween('date_of_receipt',array($startdate, $enddate) )->get());
    }
    public function getSave($f,$ac_price,$ac_weight){


        $blendedprice = $ac_price/($ac_weight>0?$ac_weight:1);
        
        if($f->is_locked){
            echo "Blended Price is <b>R".number_format($blendedprice,2, '.', ',')."</b>";
        }else{
            echo "Blended Price is <b>R".number_format($blendedprice,2, '.', ',')." And Saved</b>";
            $f->price= $blendedprice;
        $f->save();
        }
        
        
    }

}
