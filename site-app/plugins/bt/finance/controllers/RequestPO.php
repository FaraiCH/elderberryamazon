<?php namespace Bt\Finance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Config;
use Flash;
use App;
use Carbon\Carbon;
use BackendAuth;
use Redirect;
use Backend;
use Str;
use Mail;
use RainLab\User\Models\UserGroup;
use RainLab\User\Models\User;
use Bt\Finance\Models\RequestPO as ModelRequest;

/**
 * Request P O Backend Controller
 */
class RequestPO extends Controller
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

        BackendMenu::setContext('Bt.Finance', 'finance', 'requestpo');
    }
    public function onSendRequestPoNotification($id = null)
    {
        $po = ModelRequest::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name . ' ' . $user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/finance/requestpo/update/'.$id;
        $link = "
        * View Request PO: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 38)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $user->last_name;
            $data['to_email'] = $user->email;
            $data['amount'] = $po->total_amount_incvat;
            $data['username'] = $name;
            $data['suppliername'] = $po->suppliername;
            $data['po'] = $po;
            $data['response_details'] =  $link;

            Mail::send('BT.finance.requisition.po.request', $data, function($message) use ($data) {

                $message->to($data['to_email'], $data['name']);

            });
        }


        \Flash::success( "Thank you, you request have been sent to $x users");
    }
}
