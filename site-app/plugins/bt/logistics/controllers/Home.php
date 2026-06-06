<?php namespace  Bt\Logistics\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendAuth;
use Backend\Models\User;
use Bt\Production\Models\ControlSheet as ControlSheetModel;
use Bt\Sales\Models\DeliveryPlan;
use Bt\Sales\Models\Pickslip;
use Bt\Sales\Models\Srn;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Bt\Logistics\Models\Logisticapprove;
use Bt\Logistics\Models\Schedule;

use BackendMenu;
use Flash;

class Home extends Controller
{
    public $pageTitle = "Logistics";

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Logistics', 'logistics', 'home'); // has to be uppercase plugin name always

        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");


  //$this->addJs("/plugins/yourname/plugname/assets/js/custom.js", "1.0.0");
    }

    // public function index($id = null) // folder of the views has to have same name as this class in order to work
    // {
    //     $current = Carbon::now();
    //     $enddate =  $current->addDays(3);
    //     $current = Carbon::now();
    //     $startdate = $current->addDays(-5);
    //     $data = array('startdate' => $startdate, 'enddate' => $enddate);
    //     $events = array();
    //     $obj = Schedule::whereBetween('schedule_date', array($data['startdate'], $data['enddate']." 23:59:00"))->get();



    //         $id = $obj->id;
    //         dd($id);
    //     foreach ($obj as $key => $value) {
    //         $i = 1;
    //         $id = $value->id;
    //         // $calenderpost = Schedule::find($id);
    //              $obj = Logisticapprove::where('id',$id)->first();

    //         if(isset($obj->status_approve) && $obj->status_approve == 1)
    //         {
    //             $color = '#4497e0';


    //             $desc = "#".$value->id;

    //             $date=date_create($value->schedule_date);
    //             $desc = "#".$value->id." ".$value->vehicle->name." / ".$value->department->name." (".date_format($date,"Y/m/d ").")";


    //             $events[] =  array('title' => $desc, 'start'=> $value->schedule_date,'end'=> $value->return_date,'color'=>$color,"url"=> "/backend/bt/Logistics/schedule/update/".$value->id );
    //         }
    //         $i++;
    //     }

    //     $this->vars['events'] = $events;
    //     $current = Carbon::now();
    //     $this->vars['today'] = Schedule::whereBetween('schedule_date', array( $current->addDays(-1), Carbon::now()." 23:59:00"))->get();


    // }

    public function index($id = null) // folder of the views has to have same name as this class in order to work
    {

        $obj = Schedule::where('schedule_date', '>', Carbon::now()->addDays(-1))->get();
        $srnObj = Srn::where('schedule_date', '>', Carbon::now()->addDays(-1))->get();
        $delievryschedule = DeliveryPlan::where('schedule_date', '>', Carbon::now()->addDays(-1))->get();

        foreach ($obj as $key => $value) {
            if (isset($value->logisticapprove->status_approve) && $value->logisticapprove->status_approve == 1) {
                $color = '#4497e0';


                $desc = "#".$value->id;

                $date=date_create($value->schedule_date);
                $desc = "#".$value->id." ".$value->vehicle->name." / ".$value->department->name." (".date_format($date, "Y/m/d ").")";


                $events[] =  array('title' => $desc, 'start'=> $value->schedule_date,'color'=>$color,"url"=> "/backend/bt/Logistics/schedule/update/".$value->id );
            }
        }

        foreach ($srnObj as $key => $value) {
            $events[] =  array('title' => "SRN No". $value->id, 'start'=> $value->schedule_date,'color'=>'orange',"url"=> "/backend/bt/logistics/stockrelease/update/".$value->id );
        }

        foreach ($delievryschedule as $key => $value) {
            $events[] = array('title' => $value->quote->company_name, 'start'=> $value->schedule_date,'color'=>'darkblue');
        }

        $this->vars['events'] = $events;

        $this->vars['today'] = Schedule::where('schedule_date', '>', Carbon::now()->addDays(-1))->get();
        $this->vars['todaysrn'] = $srnObj;
    }


    public function srn($id = null) // folder of the views has to have same name as this class in order to work
    {

        $obj = Schedule::where('schedule_date', '>', Carbon::now()->addDays(-1))->get();
        $srnObj = Srn::where('schedule_date', '>', Carbon::now()->addDays(-1))->get();
        $delievryschedule = DeliveryPlan::where('schedule_date', '>', Carbon::now()->addDays(-1))->get();
        $events = [];
        foreach ($obj as $key => $value) {
            if (isset($value->logisticapprove->status_approve) && $value->logisticapprove->status_approve == 1) {
                $color = '#4497e0';


                $desc = "#".$value->id;

                $date=date_create($value->schedule_date);
                $desc = "#".$value->id." ".$value->vehicle->name." / ".$value->department->name." (".date_format($date, "Y/m/d ").")";


                $events[] =  array('title' => $desc, 'start'=> $value->schedule_date,'color'=>$color,"url"=> "/backend/bt/Logistics/schedule/update/".$value->id );
            }
        }

        foreach ($srnObj as $key => $value) {
            $events[] =  array('title' => "SRN No". $value->id, 'start'=> $value->schedule_date,'color'=>'orange',"url"=> "/backend/bt/logistics/stockrelease/update/".$value->id );
        }

        foreach ($delievryschedule as $key => $value) {
            $events[] = array('title' => $value->quote->company_name, 'start'=> $value->schedule_date,'color'=>'darkblue');
        }

        $this->vars['events'] = $events;

        $this->vars['today'] = Schedule::where('schedule_date', '>', Carbon::now()->addDays(-1))->get();
        $this->vars['todaysrn'] = $srnObj;
    }

    public function truck($id = null)
    {
        $this->vars['today'] = Pickslip::where('created_at', '>', Carbon::now()->addDays(-7))->orderBy("id", "desc")->get();
        $departures = [];
        foreach ($this->vars['today'] as $departure) {
            if (!empty($departure->srn)) {
                $vehicle = Srn::find($departure->srn->id);
                if (!empty($vehicle)) {
                    $departures[$departure->id] = $vehicle->vehicle_departure;
                }
            }
        }
        $this->vars['departures'] = $departures ;
    }
}
