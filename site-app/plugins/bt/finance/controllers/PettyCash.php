<?php namespace Bt\Finance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
use BackendAuth;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;
use Bt\Finance\Models\PettyCash as ModelCash;
use RainLab\User\Models\UserGroup;
use Backend\Models\User as UserModel;
use Bt\Finance\Models\PettyCashApprove as Approve;
use Bt\Finance\Models\CardRecords as ModelRecords;

/**
 * Petty Cash Backend Controller
 */
class PettyCash extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ImportExportController',

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
    public $importExportConfig = 'config_import_export.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->vars['enddate'] = Carbon::now()->format('Y-m-d');
        $this->vars['startdate'] = Carbon::now()->addDays(-7)->format('Y-m-d');
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        BackendMenu::setContext('Bt.Finance', 'finance', 'pettycash');
    }
    public function onSend($id, $messageNo)
    {
        $obj = ModelCash::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/finance/pettycash/update/'.$id;

        $link = "
        * View pettycash: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 27)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['petty_cash'] = $obj;
            if ($messageNo == 0) {
                $data['MyMessage'] = "This is a request sent without an item in Petty Cash Usage ";
            } else {
                $data['MyMessage'] = "This is a request sent with an item in Petty Cash Usage ";
            }
            $data['response_details'] =  $link;
            Mail::send('bt.notify.finance.approve', $data, function ($message) use ($data) {
                $message->subject("Petty Cash Approval: ");
                $message->to($data['to_email'], $data['name']);
            });
        }
        \Flash::success("Thank you, your request have been sent to $x users");
    }

    public function myResponse($id)
    {
        $obj = ModelCash::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/finance/pettycash/preview/'.$id;

        $link = "
        * View pettycash: $url";

        $x = 0;

        $user = UserModel::find($obj->createdby->id);

        $x++;
        $data = [];
        $data['name'] = $user->last_name;
        $data['to_email'] = $user->email;
        $data['username'] = $name;
        $data['response_details'] =  $link;
        Mail::send('bt.notify.pettycash.return', $data, function ($message) use ($data) {
            $message->subject("Petty Cash Response: ");
            $message->to($data['to_email'], $data['name']);
        });

        \Flash::success("Thank you, your approval has been sent to $x users");
    }

    public function formAfterSave($model)
    {
        $approval = Approve::where('pettycash_id', $model->id)->first();
        $cards = \Bt\Finance\Models\CardRecords::where('pettycash_id', $model->id)->first();
        if ($model->is_completed == 0) {
            if (isset($cards->id)) {
                if ($model->response == 0) {
                    $this->onSend($model->id, 1);
                }
            } else {
                if (empty($approval)) {
                    if ($model->response == 0) {
                        $this->onSend($model->id, 0);
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
    }

    public function onPettyExport()
    {
        $_SESSION['starter'] = \Input::get('startdate');
        $_SESSION['ender'] = \Input::get('enddate');
        Flash::success("Dates are saved. You can now export");
    }
}
