<?php namespace Bt\Logistics\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BackendAuth;
use Flash;
use Config;
use Mail;
use RainLab\User\Models\UserGroup;
use Bt\Logistics\Models\Schedule as ScheduleModel;
use Bt\Logistics\Models\Logisticapprove as Approval;
use Backend\Models\User as UserModel;

/**
 * Schedule Back-end Controller
 */
class Schedule extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $relationConfig = 'config_relation.yaml';
    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Logistics', 'logistics', 'schedule');
    }

    public function onSendRequestApprovalNotification($id = null)
    {

        $obj = ScheduleModel::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/backend/bt/logistics/schedule/update/'.$id;

        $link = " 
        * View schedule:" .$url;

        // $x = 0;
        

        $avehicle = $obj->vehicle->name;
        $avehicle .= ' - ' .$obj->vehicle->num_plate;

        $x = 0;
        $groupusers = UserGroup::where('id', 24)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['vehicle'] = $avehicle;
            $data['schedule'] = $obj->schedule_date;
            $data['ref'] = "BT-Logistic-Schedule-".$value->id;
            $data['response_details'] =  $link;

                Mail::send('bt.notify.logistic.approval', $data, function ($message) use ($data) {
                    $message->subject("BT Industrial Logistics Schedule Approval: ".$data['ref']);
                    $message->to($data['to_email'], $data['name']);
                });

            \Flash::success("Thank you, you request have been sent to $x users.");
        }
    }

    public function myResponse($id)
    {
        $obj = ScheduleModel::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/backend/bt/logistics/schedule/preview/'.$id;

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
        $data['username'] = $name;
        $data['response_details'] =  $link;
        Mail::send('bt.notify.schedule.return', $data, function ($message) use ($data) {
            $message->subject("BT Industrial Logistics Schedule Response: ");
            $message->to($data['to_email'], $data['name']);
        });

        \Flash::success("Thank you, your approval has been sent to $x users");
    }

    public function formAfterSave($model)
    {
        $approval = Approval::where('schedule_id', $model->id)->first();

        if (empty($approval)) {
            if ($model->response == 0) {
                $this->onSendRequestApprovalNotification($model->id, 0);
                $model->response = 1;
                $model->save();
            }
        } else {
            if ($model->response == 0) {
                    $this->myResponse($model->id);
            }
        }
    }
}
