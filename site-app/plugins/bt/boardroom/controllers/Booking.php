<?php namespace Bt\Boardroom\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Boardroom\Models\Booking as BookingModel;
use Carbon\Carbon;
use BackendAuth;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;
use Bt\Boardroom\Models\Booking as ModelBooking;
use RainLab\User\Models\UserGroup;
use Backend\Models\User as UserModel;
use Bt\Boardroom\Models\BookingApproval as Approval;
use System\Helpers\DateTime;
use Bt\Boardroom\Models\Visitor as VisitorModel;

/**
 * Booking Backend Controller
 */
class Booking extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.RelationController',
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Boardroom', 'boardroom', 'booking');
    }

    public function onSendBookingRequest($id)
    {
        $obj = ModelBooking::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/backend/bt/boardroom/booking/update/'.$id;

        $link = "
        * View Boardroom booking: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 33)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;

            $data['username'] = $name;
            $data['booking'] = $obj;
            $data['response_details'] =  $link;
            Mail::send('bt.notify.booking', $data, function ($message) use ($data) {
                $message->subject("Boardroom Booking Request: ");
                $message->to($data['to_email'], $data['name']);
            });
        }
        \Flash::success("Thank you, your request have been sent to $x users");
    }

    public function myResponse($id)
    {
        $obj = ModelBooking::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/backend/bt/boardroom/booking/preview/'.$id;

        $link = "
        * View pettycash: $url";

        $x = 0;

        if (isset($obj->createdby) && is_object($obj->createdby)) {
            $user = UserModel::find($obj->createdby->id);
        }

        $x++;
        $data = [];
        $data['name'] = $user->last_name;
        $data['to_email'] = $user->email;
//        $data['to_email'] = 'fmc@bt-industrial.co.za';
        $data['username'] = $name;
        $data['response_details'] =  $link;
        Mail::send('bt.notify.booking.return', $data, function ($message) use ($data) {
            $message->subject("booking Response: ");
            $message->to($data['to_email'], $data['name']);
        });

        \Flash::success("Thank you, your approval has been sent to $x users");
    }

    public function formAfterSave($model)
    {
        $approval = Approval::where('booking_id', $model->id)->first();

        if (empty($approval)) {
            if ($model->response == 0) {
                $this->onSendBookingRequest($model->id, 0);
                $model->response = 1;
                $model->save();
            }
        } else {
            if ($model->response == 0) {
                    $this->myResponse($model->id);
            }
        }
    }
    public function appointment()
    {
        BackendMenu::setContext('Bt.Boardroom', 'boardroom', 'appointment');
        $this->pageTitle = "Appointment Dashboard";
        $events = [];
        $this->addJs("/plugins/bt/production/assets/js/popthis.js", "1.0.0");
        $this->addJs("/plugins/bt/production/assets/js/scheduleinput.js", "1.0.0");
        $this->addCss("/plugins/bt/plcommon/assets/css/customform.css", "1.0.2");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $appointments = BookingModel::all();
        $visitors = VisitorModel::all();
        $upvisitors = VisitorModel::where('date', '>=', Carbon::today())->orderBy('date', 'Asc')->get();
        foreach ($appointments as $val) {
            $start_time = new \DateTime($val->start_time);
            $start_format = $start_time->format('H:i');
            $end_time = new \DateTime($val->end_time);
            $end_format = $end_time->format('H:i');
            if ($val->subject == null) {
                $desc = $val->department->name;
            } else {
                $desc = $val->subject;
            }
            $events[] =  array('title' => $desc, 'start'=> $val->date . ' ' . $val->start_time,'end'=> $val->date .' '. $val->end_time,'color'=> 'green',"url"=> "/backend/bt/boardroom/booking/update/".$val->id );
        }


        //Visitors
        foreach ($visitors as $val) {
            $date_only = new \DateTime($val->date);
            $events[] =  array('title' => 'Visitors' . ' - ' . $val->visitorname, 'start'=> $val->date,'end'=> $date_only->format('Y-m-d') .' '. $val->end_time,'color'=> 'blue',"url"=> "/backend/bt/boardroom/visitor/update/".$val->id );
        }
        $this->vars['visitors'] = $upvisitors;
        $this->vars['events'] = $events;
    }
}
