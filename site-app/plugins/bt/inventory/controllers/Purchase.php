<?php namespace Bt\Inventory\Controllers;

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
use Bt\Inventory\Models\Purchase as ModelPurchase;
use RainLab\User\Models\UserGroup;

/**
 * Purchase Back-end Controller
 */
class Purchase extends Controller
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

        BackendMenu::setContext('Bt.Inventory', 'inventory', 'purchase');
    }

     public function onSendRequestPONotification($id = null)
    {
        $obj = ModelPurchase::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;#.' '.$user->last_name;   
        $name .= ' '.$user->last_name;


        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/inventory/purchase/update/'.$id;

        $link = " 
        * View PO: $url";
       

        $x = 0;

        $groupusers = UserGroup::where('id', 14)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['purchase'] = $obj;
            $data['ref'] = "BT-PO-".$obj->id;
            $data['response_details'] =  $link;
            Mail::send('bt.notify.purchase.approval', $data, function($message) use ($data) {
                $message->subject("BT PO Approval: ".$data['ref']);                       
                $message->to($data['to_email'], $data['name']);
             
                 $message->attach( Config::get('app.url')."/po/item/download/".$data['purchase']['id'].".pdf", ['as' => 'po.pdf']);
            });
        }

        
        \Flash::success( "Thank you, you request have been sent to $x users");
       
    }
}
