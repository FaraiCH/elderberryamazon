<?php namespace Bt\Production\Controllers;

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
use Bt\Production\Models\Jobcard as ModelJobcard;
use RainLab\User\Models\UserGroup;

/**
 * Jobcard Back-end Controller
 */
class Jobcard extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public function __construct()
    {
        parent::__construct();
            
        BackendMenu::setContext('Bt.Production', 'production', 'jobcard');
    }

    public function onSendRequestApprovalNotification($id = null)
    {
        $obj = ModelJobcard::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;#.' '.$user->last_name;
        $name .= ' '.$user->last_name;


        ##SEND EMAIL
        $url = Config::get('app.url').'/backend/bt/production/jobcard/update/'.$id;

        $link = " 
        * View Jobcard: $url";
       

        $x = 0;

        $groupusers = UserGroup::where('id', 14)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['jobcard'] = $obj;
            $data['ref'] = "BT-Production-Jobcard-".$obj->id;
            $data['response_details'] =  $link;
            Mail::send('bt.notify.production.jobcardapproval', $data, function ($message) use ($data) {
                $message->subject("BT Industrial Production Jobcard Approval: ".$data['ref']);
                $message->to($data['to_email'], $data['name']);
                 $message->attach(Config::get('app.url')."/productionjobcard/item/download/".$data['jobcard']['id'].".pdf", ['as' => 'productionjobcard.pdf']);
            });
        }

        
        \Flash::success("Thank you, you request have been sent to $x users");
    }
}
