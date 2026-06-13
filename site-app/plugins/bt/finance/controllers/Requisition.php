<?php namespace Bt\Finance\Controllers;

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
use Bt\Finance\Models\Requisition as ModelRequisition;

use RainLab\User\Models\UserGroup;
use RainLab\User\Models\User;

/**
 * Requisition Back-end Controller
 */
class Requisition extends Controller
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

        BackendMenu::setContext('Bt.Finance', 'finance', 'requisition');
    }
    public function onSendRemindHOManager($id = null)
    {
        $this->onSend($id, 16, 'Request Head Office Requisition Approval');
    }
    public function onSendFinManager($id = null)
    {
        $this->onSend($id, 5, 'Request Finance Requisition Approval');
    }

    public function formExtendFields($form)
    {
        if (isset($form->model->created_by)) {
            $user = BackendAuth::getUser();
        if (!$user) return;


                $form->addFields([
                'cancelled' => [
                    'label'   => 'Cancel',
                    'type' => 'switch',
                    'span' => 'auto',
                    'disabled' => ($form->model->created_by == $user->id? false:true ),
                    'commentHtml' => true,
                    'comment' => 'Requisitions can only be cancelled by the person who created it, owner <b style="color: red">'.($form->model->createdby->first_name).' '.($form->model->createdby->last_name).'</b>',
                ],
                ]);
        }
    }

    public function onSendRemindLineManager($id = null)
    {
        $subject = 'Request Line management Requisition Approval';

        $quote = ModelRequisition::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;#.' '.$user->last_name;
        $name .= ' '.$user->last_name;
        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/finance/requisition/update/'.$quote->id;

        $link = "
        * View Requisition: $url";

        $x = 1;
        $value = $quote->linemanager;
        $data = [];
        $data['to_name'] = $value->name;
        $data['to_email'] = $value->email;
        $data['sales_name'] = $name;
        $data['quote'] = $quote;
        $data['ref'] = "#BT-REQ-".$id;
        $data['response_details'] =  $link;
        $data['subject'] = $subject;


        Mail::send('BT.finance.requisition.notify', $data, function ($message) use ($data) {
            $message->subject($data['subject'].": ".$data['ref']);
            $message->to($data['to_email'], $data['to_name']);

            $message->attach(Config::get('app.url')."/finance/requisition/item/download/".$data['quote']['id'].".pdf", ['as' => 'Requesition_'.$data['quote']['id'].'.pdf']);
             $message->attach(Config::get('app.url')."/finance/requisition/invoice/download/".$data['quote']['id'].".pdf", ['as' => 'Invoice_'.$data['quote']['id'].'.pdf']);
        });



        \Flash::success("Thank you, you request have been sent to $x users");
    }


    private function onSend($id, $grp, $subject)
    {

        $quote = ModelRequisition::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;#.' '.$user->last_name;
        $name .= ' '.$user->last_name;
        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/finance/requisition/update/'.$quote->id;

        $link = "
        * View Requisition: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', $grp)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['to_name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['sales_name'] = $name;
            $data['quote'] = $quote;
            $data['ref'] = "#BT-REQ-".$id;
            $data['response_details'] =  $link;
            $data['subject'] = $subject;


            Mail::send('BT.finance.requisition.notify', $data, function ($message) use ($data) {
                $message->subject($data['subject'].": ".$data['ref']);
                $message->to($data['to_email'], $data['to_name']);

                $message->attach(Config::get('app.url')."/finance/requisition/item/download/".$data['quote']['id'].".pdf", ['as' => 'Requesition_'.$data['quote']['id'].'.pdf']);
                 $message->attach(Config::get('app.url')."/finance/requisition/invoice/download/".$data['quote']['id'].".pdf", ['as' => 'Invoice_'.$data['quote']['id'].'.pdf']);
            });
        }


        \Flash::success("Thank you, you request have been sent to $x users");
    }

    public function listExtendQuery($query, $definition = null)
    {

        $user = BackendAuth::getUser();
        if (!$user) return;
        $me = User::where("email", $user->email)->first();

        if ($this->user->hasPermission(['bt.finance.fin']) || $this->user->hasPermission(['bt.finance.ho']) ||
            $this->user->hasPermission(['bt.finance.reqList'])) {
            $query->where('created_by', '>', 0);
        } else {
            $query->where('created_by', '=', $user->id)
                ->orWhere('requestedby_id', '=', $user->id);

            if (isset($me->id)) {
                $query = $query->orWhere('linemanager_id', '=', $me->id);
            }
        }

    }

    public function onReq()
    {
        $_SESSION['req'] = \Input::get("req");
    }


}
