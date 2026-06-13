<?php namespace Bt\QC\Controllers;

use BackendMenu;
use BackendAuth;
use Backend\Classes\Controller;
use Carbon\Carbon;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;
use RainLab\User\Models\UserGroup;
//use RainLab\User\Models\User as dbUsers;
use Bt\Sales\Models\Quoteitems;
use Bt\QC\Models\Reqcertificate as ModelCoc;
use Bt\Sales\Models\Newquote;
use Backend\Models\User;
use System\Models\File;


/**
 * Reqcertificate Back-end Controller
 */
class Reqcertificate extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
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
        BackendMenu::setContext('Bt.QC', 'qc', 'reqcertificate');
    }

    public function listExtendColumns($list)
    {
        if ($this->user->hasAccess('bt.qc.lab')) {
            $list->removeColumn('requestqc');
        }
    }

    public function formExtendFields($fields, $context = null)
    {
        if ($this->user->hasAccess('bt.qc.lab')) {
            $fields->removeField('coc');
            $fields->removeField('coa');
            $fields->addFields([
                'completed' => [
                    'label' => 'Is Request Completed',
                    'type' => 'switch',
                     'on' => 'Yes',
                     'off' => 'No',
                    'span' => 'auto'
                ],
            ]);
        }
    }
    public function onSendToSales($id = null)
    {

        $req = ModelCoc::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/qc/reqcertificate/update/'.$id;

        $link = "
        * View COC Requets: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 32)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['COC'] = $req;
            $data['response_details'] =  $link;
            Mail::send('bt.qc.notify.sales.Certificate', $data, function($message) use ($data) {
                $message->subject("COC Request Approval: ");
                $message->to($data['to_email'], $data['name']);

            });
        }


        \Flash::success( "Good Day, an update has been sent to  $x users");
    }


}
