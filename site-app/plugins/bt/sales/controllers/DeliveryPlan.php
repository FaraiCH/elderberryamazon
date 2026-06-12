<?php namespace Bt\Sales\Controllers;

use BackendAuth;
use BackendMenu;
use Backend\Classes\Controller;
use Config;
use Flash;
use App;
use Carbon\Carbon;
use Redirect;
use Backend;
use Str;
use Mail;
use Bt\Sales\Models\DeliveryPlan as ModelDeliveryPlan;
use RainLab\User\Models\UserGroup;
use Session;
use Input;

/**
 * Delivery Plan Back-end Controller
 */
class DeliveryPlan extends Controller
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

        BackendMenu::setContext('Bt.Sales', 'sales', 'deliveryplan');
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");

        if(Session::has('schedulestart') && Session::get('schedulestart') > 0){
            $this->vars['schedulestart'] = Session::get('schedulestart');
            $this->vars['scheduleend'] = Session::get('scheduleend');
        }else{
            $this->vars['schedulestart'] = Carbon::now()->subDays(30);
            $this->vars['scheduleend'] = Carbon::now();
        }
    }


    public function onSendlNotification($id = null)
    {
        $obj = ModelDeliveryPlan::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;#.' '.$user->last_name;
        $name .= ' '.$user->last_name;


        ##SEND EMAIL
        $url = Config::get('app.url').'/backend/bt/sales/deliveryplan/update/'.$id;

        $link = "
        * View Schedule: $url";


        $x = 0;

        $groupusers = UserGroup::where('id', 15)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['delivery'] = $obj;

            if(isset($obj->quote->invoice) && $obj->quote->invoice){
                $data['invoice'] = 'Invoiced';
            }else{
                $data['invoice'] = 'Not Invoiced';
            }


            $data['ref'] = "BT-Delivery-Schedule: BT-QT-".$obj->quote_id;
            $data['response_details'] =  $link;
            Mail::send('bt.notify.sales.deliveryplan', $data, function($message) use ($data) {
                $message->to($data['to_email'], $data['name']);


            });
        }


        \Flash::success( "Thank you, you request have been sent to $x users");
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }

    public function calendarplan()
    {



         $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");




        $this->pageTitle = "Calendar Plan";


        BackendMenu::setContext('Bt.Sales', 'sales', 'calendarplan');


        $current = Carbon::now();
        $enddate =  $current->addDays(3);
        $current = Carbon::now();
        $startdate = $current->addDays(-5);
        $data = array('startdate' => $startdate, 'enddate' => $enddate);
        $events = array();
        $obj = ModelDeliveryPlan::whereBetween('schedule_date', array($data['startdate'], $data['enddate']." 23:59:00"))->get();
        foreach ($obj as $key => $value) {
            $color = '#4497e0';
            $date=date_create($value->schedule_date);
            $desc = "QT #".$value->quote_id.", ".$value->type->lookup__name_public.", ".$value->client->company_name.", ".$value->address." (".date_format($date,"Y/m/d ").")";

            $events[] =  array('title' => $desc, 'start'=> $value->schedule_date,'color'=>$color,"url"=> "/backend/bt/sales/deliveryplan/preview/".$value->id );
        }

        $this->vars['events'] = $events;
        $current = Carbon::now();
        $this->vars['today'] = ModelDeliveryPlan::whereBetween('schedule_date', array( $current->addDays(-1), Carbon::now()." 23:59:00"))->get();
    }

    public function onDateFilter(){
        if(\Input::has('schedulestart') && Input::get('schedulestart') > 0){
            Session::put('schedulestart',\Input::get('schedulestart'));
            Session::put('scheduleend',\Input::get('scheduleend'));
            Flash::success('Date filters have been applied');
        }else{
            Flash::warning('Nothing has been applied');
        }


    }
}
