<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use RainLab\User\Models\UserGroup;

/**
 * Piperequest Backend Controller
 */
class Piperequest extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.RelationController'
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

        BackendMenu::setContext('Bt.Sales', 'sales', 'piperequest');
    }

    public function formAfterSave($model){
        $user = \BackendAuth::getUser();
        if(isset($model->piperapprove->id)){
            \DB::table('tbl_association')->insert(
                [
                    'tbl_association__id' => $model->to_quote->id,
                    'association__id' => $model->quote_item->pipe->id,
                    'tbl_association_type' => 'Bt\Sales\Models\Newquote',
                    'association__record_active' => 1
                ]
            );
        }
        $data['to_name'] = $model->createdby->first_name . ' ' . $model->createdby->last_name;
        $data['to_email'] = $model->createdby->email;
        $data['exec'] = $user->first_name. ' ' . $user->last_name;
        $data['from_quote'] = $model->from_quote->id. ' | ' . $model->from_quote->company_name ;
        $data['quote_item'] = $model->quote_item->description;
        $data['to_quote'] = $model->to_quote->id . ' | '. $model->to_quote->company_name;

        \Mail::send('BT.sales.pipe.pipeapproved', $data, function($message) use ($data) {
            //$message->subject("BT Industrial Production Approval: ".$data['ref']);
            $message->to($data['to_email'], $data['to_name']);
        });

        \Flash::success('Approval Succesfully Sent');

    }
    public function onRequestPipe($id){
        ##SEND EMAIL
        $quote = \Bt\Sales\Models\Piperequest::find($id);
        $url = \Config::get('app.url').'/admin/bt/sales/piperequest/update/'.$quote->id;

        $link = "
        * View Pipe Request: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 31)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['to_name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['from_quote'] = $quote->from_quote;
            $data['quantity'] = $quote->qty;
            $data['to_quote'] = $quote->to_quote;
            $data['response_details'] =  $link;

            \Mail::send('BT.sales.pipe.piperequest', $data, function($message) use ($data) {
                //$message->subject("BT Industrial Production Approval: ".$data['ref']);
                $message->to($data['to_email'], $data['to_name']);
            });
        }

    }


}
