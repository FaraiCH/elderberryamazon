<?php namespace Bt\Maintenance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend\Facades\BackendAuth;
use Backend\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Bt\Maintenance\Models\JobCard as ModelJobCard;

/**
 * Overview Backend Controller
 */
class Overview extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
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

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'overview');

        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");
    }

     public function index()
    {

        $this->pageTitle = "OverView";
        $current = Carbon::now();
        $enddate =  $current->addDays(3);
        $current = Carbon::now();
        $startdate = $current->addDays(-5);
        $data = array('startdate' => $startdate, 'enddate' => $enddate);
        $events = array();
        $obj = ModelJobCard::whereBetween('opendate', array($data['startdate'], $data['enddate']." 23:59:00"))->where("id",'>',0)->get();
        foreach ($obj as $key => $value) {
            $color = '#4497e0';
           
            
            $desc = "Ref ".$value->id."-".$value->job_summary;
            if($value->jobcard_id > 0){
                $date=date_create($value->opendate);
              $desc = "#".$value->id.", #JobCard-".$value->jobcard_id."(".date_format($date,"Y/m/d ").")";
            }
            $events[] =  array('title' => $desc, 'start'=> $value->opendate,'color'=>$color,"url"=> "/admin/bt/maintenance/jobcard/update/".$value->id );
        }

        $this->vars['events'] = $events; 
        $current = Carbon::now();
        $this->vars['today'] = ModelJobCard::whereBetween('opendate', array( $current->addDays(-1), Carbon::now()." 23:59:00"))->where("id",'>',0)->get();


    }
}
