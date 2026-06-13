<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Mail;
use Config;
use Bt\Sales\Models\Srn as ModelSrn;
use RainLab\User\Facades\Auth;
use RainLab\User\Models\UserGroup;
use Bt\Sales\Models\StockOrder as StockOrderModel;
/**
 * Stock Order Backend Controller
 */
class StockOrder extends Controller
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

        BackendMenu::setContext('Bt.Sales', 'sales', 'stock_order');
    }

    public function onSendRequestInvoiceNotification($id = null)
    {
        $stockorder = StockOrderModel::find($id);
        $user = $stockorder->quote->user;
        $name = $user->name;#.' '.$user->last_name;
        $name .= ' ' . $user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url') . '/admin/bt/sales/newquote/update/' . $stockorder->quote->id;

        $link = "* View Quote: $url";

        $x = 0;

        $x++;
        $data = [];
        $data['to_name'] = $name;
        $data['to_email'] = $user->email;
        $data['stockorderObj'] = $stockorder;
        $data['ref'] = "#BT-" . $id;
        $data['company_name'] = $stockorder->quote->company_name;

        Mail::send('BT.sales.stockorder.notify', $data, function ($message) use ($data, $id) {

            $message->subject("BT Stock Ready: " . $data['ref']);

            $message->to($data['to_email'], $data['to_name']);

            $message->attach(Config::get('app.url') . "/stockorder/item/download/" . $id . ".pdf", ['as' => 'Stock Order.pdf']);

        });


        \Flash::success("Thank you, your message has been sent");
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }

}
