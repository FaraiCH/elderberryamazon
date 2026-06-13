<?php namespace  Bt\Operator\Controllers;


use Backend\Classes\Controller;
use Backend\Facades\BackendAuth;
use Backend\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Bt\Production\Models\ControlSheet as ControlSheetModel;

use BackendMenu;
use Flash;


class Home extends Controller
{
    public $pageTitle = "Operator";

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Operator', 'operator','home'); // has to be uppercase plugin name always

      $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
      $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
      $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
      $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");


  //$this->addJs("/plugins/yourname/plugname/assets/js/custom.js", "1.0.0");

    }

    public function index() // folder of the views has to have same name as this class in order to work
    {
        $current = Carbon::now();
        $enddate =  $current->addDays(3);
        $current = Carbon::now();
        $startdate = $current->addDays(-3);
        $data = array('startdate' => $startdate, 'enddate' => $enddate);
        $events = array();
        $obj = ControlSheetModel::whereBetween('created_at', array($data['startdate'], $data['enddate']." 23:59:00"))->where("editlevel_id",0)->where("jobcard_id",'>',0)->where('active', 0)->get();
        foreach ($obj as $key => $value) {
            $color = '#4497e0';
            $desc = "#".$value->id;
//            if($value->batch_id > 0){
//                $date=date_create($value->opendate);
//              $desc = "#".$value->id.", #BT-".$value->jobcard_id."-".$value->batch_id." (".date_format($date,"Y/m/d ").")";
//            }
            if(isset($value->btline) && isset($value->btline->name)){
              $desc .= ", Running on ".($value->btline->name?$value->btline->name:"");
            }
            $events[] =  array('title' => $desc, 'start'=> $value->opendate,'color'=>$color,"url"=> "/admin/bt/operator/shiftinputs/update/".$value->id );
        }

        $this->vars['events'] = $events;
        $current = Carbon::now();
        $this->vars['today'] = ControlSheetModel::where('created_at','>', $current->addDays(-7))->orWhere('opendate', Carbon::today())->where('active', 0)->get();


    }


}
