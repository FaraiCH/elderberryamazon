<?php namespace Bt\Sales\Controllers;

use BackendAuth;
use BackendMenu;
use Backend\Classes\Controller;
use Bt\Notify\Classes\PanaceaApi;
use Bt\Sales\Models\PickslipItem;
use Bt\Sales\Models\SrnItem;
use Config;
use Flash;
use App;
use Carbon\Carbon;
use Redirect;
use Backend;
use Str;
use Mail;

use Bt\Sales\Models\Srn as ModelSrn;
use RainLab\User\Models\UserGroup;



/**
 * Srn Back-end Controller
 */
class Srn extends Controller
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

        BackendMenu::setContext('Bt.Sales', 'sales', 'srn');
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap4.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        // SRNS
        if(!isset($_SESSION['startsrn'])){
           $this->vars['startsrn'] = Carbon::now()->subDays(30);
           $this->vars['endsrn'] = Carbon::now();
        }else{
            $this->vars['startsrn'] = $_SESSION['startsrn'];
            $this->vars['endsrn'] = $_SESSION['endsrn'];
        }

        // Items
        if(!isset($_SESSION['srnstart'])){
            $this->vars['srnstart'] = Carbon::now()->subDays(30);
            $this->vars['srneend'] = Carbon::now();
        }else{
            $this->vars['srnstart'] = $_SESSION['srnstart'];
            $this->vars['srneend'] = $_SESSION['srneend'];
        }

        //Srn Items
        $this->vars['srnlist'] = ModelSrn::whereHas('quote', function ($query){
            $query->whereNotNull('ponumber');
        })->orderBy('id', 'desc')->get();
    }

    public function onSendRequestInvoiceNotification($id = null)
    {

        $quote = ModelSrn::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;#.' '.$user->last_name;
        $name .= ' ' . $user->last_name;


        ##SEND EMAIL
        $url = Config::get('app.url') . '/backend/bt/sales/newquote/update/' . $quote->quote->id;

        $link = "
        * View Quote: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 5)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['to_name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['sales_name'] = $name;

            $data['billing_name'] = $quote->quote->billing_name;
            $data['company_name'] = $quote->quote->company_name;
            $data['quote_total'] = $quote->quote->quote_total;
            $data['quote'] = $quote->quote;
            $data['notes'] = 'Delivery date : ' . $quote->schedule_date;

            $data['ref'] = "#BT-" . $quote->quote->id;
            $data['response_details'] = $link;

            Mail::send('BT.sales.response.notifyinvoice', $data, function ($message) use ($data) {
                $message->subject("BT Request Invoice for SRN: " . $data['ref']);

                $message->to($data['to_email'], $data['to_name']);

                $message->attach(Config::get('app.url') . "/quote/item/download/" . $data['quote']['id'] . ".pdf", ['as' => 'Original Quote.pdf']);
                $message->attach(Config::get('app.url') . "/quote/invoice/download/" . $data['quote']['id'], ['as' => 'Invoice.pdf']);//#INVOICE
                $message->attach(Config::get('app.url') . "/quote/response/download/" . $data['quote']['id'] . "/10", ['as' => 'PO.pdf']);#po
                $message->attach(Config::get('app.url') . "/quote/response/download/" . $data['quote']['id'] . "/9", ['as' => 'Singed Quote.pdf']);
                #SIGNED QOUTE

            });
        }


        \Flash::success("Thank you, you request have been sent to $x users");
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }

    public function onSendRequestApprovalNotification($id = null)
    {
        $obj = ModelSrn::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;#.' '.$user->last_name;
        $name .= ' ' . $user->last_name;

        ##SEND EMAIL
        $url = Config::get('app.url') . '/backend/bt/sales/srn/update/' . $id;

        $link = "
        * View SRN: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 20)->first();

        foreach ($groupusers->users as $key => $value) {
            if(isset($value->employee->phone)){
                $test = new PanaceaApi();
                $test->setUsername("noezans");
                $test->setPassword("Sithole@1435#");
                $test->debug = false;
                $to = $value->employee->phone;
                $text = "Good day QC Team. An approval needs your attention for SRN No " .  $id . ". Please use the following link to approve: " . $url;
                $send = $test->message_send($to, $text);
            }
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['company_name'] = $obj->quote->company_name;
            $data['username'] = $name;
            $data['sales_name'] = $name;
            $data['ref'] = "BT-SRN-" . $obj->id;
            $data['id'] = $id;
            $data['response_details'] = $link;

            Mail::send('BT.sales.response.srnaprove', $data, function ($message) use ($data) {
                $message->subject("BT Request SRN Approval: " . $data['ref']);
                $message->to($data['to_email'], $data['name']);
                $message->attach(Config::get('app.url') . "/srn/item/download/" . $data['id'] . ".pdf", ['as' => 'srn.pdf']);
            });
        }



        \Flash::success("Thank you, you request have been sent to $x users");
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }

    public function onSendNotificationReturnNote($id = null)
    {
        ### SEND NOTIFICATION TO FINANCE GROUP AND RELATED MEMBERS
        ### ID = SRN ID

        $obj = ModelSrn::find($id);
        $url = Config::get('app.url') . '/backend/bt/sales/srn/preview/' . $id;

        $link = "
        * View SRN: $url";

        $x = 0;

        if (!empty($obj->returnnote)) {

            $user = BackendAuth::getUser();
        if (!$user) return;
            $name = $user->first_name;#.' '.$user->last_name;
            $name .= ' ' . $user->last_name;
            #from_name

            $groupusers = UserGroup::where('id', 22)->first();

            foreach ($groupusers->users as $key => $value) {
                $x++;
                $data = [];
                $data['from_name'] = $name;
                $data['to_name'] = $value->name;

                $data['company_name'] = $obj->quote->company_name;
                $data['quote_id'] = $obj->quote_id;
                $data['srn_id'] = $id;

                $data['tblrns'] = $obj->returnnote;
                $data['to_email'] = $value->email;


                $data['id'] = $id;
                $data['response_details'] = $link;

                // Mail::send('bt.notify.sales.returnnotes', $data, function ($message) use ($data) {
                //     $message->subject("BT Return Note: " . $data['srn_id']);
                //     $message->to($data['to_email'], $data['to_name']);

                //     $message->attach(Config::get('app.url') . "/returnnote/item/download/" . $data['id'] . ".pdf", ['as' => 'return_note.pdf']);
        });
            }


        }

        \Flash::success("Thank you, you request have been sent to $x users");
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }

    public function formExtendFields($form)
    {
        $srn = \Bt\Sales\Models\Srn::find(\Request::segment(6));
        $this->addCss("/plugins/bt/sales/assets/css/container.css", "1.0.0");


    }

    public function easysign($id){
        $this->vars['srn'] = \Bt\Sales\Models\Srn::find($id);
    }

    public function onDateFilter(){
        if(!empty(\Input::get('startsrn'))){
            $_SESSION['startsrn'] = \Input::get('startsrn');
            $_SESSION['endsrn'] = \Input::get('endsrn');
        }
        Flash::success('Date filters have been applied');

    }

    public function onSavePickSlip($id = null){
        //Make sure to check the pipes already exist as well so we don't add it again
        //Add only pipes checked. ID has been made into an array
        $mypicks = \Input::get('pick');
        $counter = 0;
        if(!empty($mypicks)){
            $pick_values = array_keys($mypicks);
            foreach($pick_values as $pick){

                $pickitem = PickslipItem::find($pick);
                if(!empty($pickitem)){
                    $new_srn_item = SrnItem::where('srn_id', $id)->where('pipe_id', $pickitem->pipe_id)->first();
                    if(empty($new_srn_item)){
                        $counter++;
                        $new_srn_item = new SrnItem();
                        $new_srn_item->srn_id = $id;
                        $new_srn_item->pipe_id = $pickitem->pipe_id;
                        $new_srn_item->description = $pickitem->pipe->quoteitems->description;
                        $new_srn_item->units = $pickitem->units;
                        $new_srn_item->quoteitem_id = $pickitem->pipe->quoteitems->id;
                        $new_srn_item->save();
                    }else{
                        Flash::warning("This pipe already exists: " . $pickitem->pipe->quoteitems->description);
                    }
                }
            }
            if($counter > 0){
                Flash::success("You have added " . $counter . " type(s) of pipes to the SRN");
                return Redirect::refresh();
            }
        }else{
            Flash::error("You have not selected any Pick Slip item to put into the SRN");
        }

    }

    public function exportitem(){
        $this->pageTitle = "Export Srn Items";
        BackendMenu::setContext('Bt.Sales', 'sales', 'srn');
    }

    public function onDateItemFilter(){
        if(!empty(\Input::get('srnstart'))){
            $_SESSION['srnstart'] = \Input::get('srnstart');
            $_SESSION['srneend'] = \Input::get('srneend');
        }
        if(\Input::has('srn') && \Input::get('srn') > 0){
            $_SESSION['srn'] = \Input::get('srn');
        }else{
            $_SESSION['srn'] = '';
        }
        Flash::success('Srn filters have been applied');

    }
}
