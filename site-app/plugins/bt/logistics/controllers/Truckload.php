<?php namespace Bt\Logistics\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Pipestickeritem;
use Bt\Sales\Models\Pickslip;
use Bt\Sales\Models\PickslipItem;
use Bt\Sales\Models\Srn;
use Bt\Sales\Models\SrnItem;
use Carbon\Carbon;

/**
 * Truckload Backend Controller
 */
class Truckload extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.RelationController'
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';
    public $relationConfig = '$/bt/sales/controllers/pickslip/truck_config_relation.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Logistics', 'logistics', 'truckload');
        $this->addJs("/plugins/bt/production/assets/js/popthis.js", "1.0.0");
        $this->addJs("/plugins/bt/production/assets/js/scheduleinput.js", "1.0.0");

        $this->addCss("/plugins/bt/plcommon/assets/css/customform.css", "1.0.2");
    }

    public function onCreateSrn($id = null){
        //Make sure to check the pipes already exist as well so we don't add it again
        //Add only pipes checked. ID has been made into an array
//        $pickslip = Pickslip::find($id);
//        if(empty($pickslip->srn)){
//            $new_srn = new Srn();
//            $new_srn->client_id = $pickslip->quote->client_id;
//            $new_srn->pickslip_id = $id;
//            $new_srn->quote_id = $pickslip->quote_id;
//            //Schedule Delivery must be added to pick slip
//            if ($pickslip->schedule !== null)
//              $new_srn->schedule_date = $pickslip->schedule->schedule_date;
//            //Type must be added to pick slip
//            if ($pickslip->schedule !== null)
//              $new_srn->type_id = $pickslip->type->id;
//            $new_srn->save();
//            $mypicksitems = Pipestickeritem::where('pickslip_id', $id)->get();
//            if(!empty($mypicksitems)){
//                foreach ($mypicksitems as $item){
//                    $item->srn_id = $new_srn->id;
//                    $item->save();
//                }
//            }
//            \Flash::success("Created SRN and Saved Items To SRN");
//        }else{
//            \Flash::error("Already attached to SRN");
//        }
    }

    public function onPushToSrn($id = null){
        //Make sure to check the pipes already exist as well so we don't add it again
        //Add only pipes checked. ID has been made into an array
//        $pickslip = Pickslip::find($id);
//        if(!empty($pickslip->srn)){
//
//            $srn_id = $pickslip->srn->id;
//
//            $mypicksitems = Pipestickeritem::where('pickslip_id', $id)->get();
//            if(!empty($mypicksitems)){
//                foreach ($mypicksitems as $item){
//                    $item->srn_id = $srn_id;
//                    $item->srn_date = Carbon::now();
//                    $item->save();
//                }
//            }
//            \Flash::success("Created SRN and Saved Items To SRN");
//        }else{
//            \Flash::error("Already attached to SRN");
//        }
    }

}
