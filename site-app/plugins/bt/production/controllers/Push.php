<?php namespace Bt\Production\Controllers;

use BackendAuth;
use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\ExperiEpxort;
use Bt\Production\Models\Pipe;
use Config;
use Flash;
use App;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use Backend;
use Str;
use Mail;
use Input;
use Bt\Production\Models\Push as ModelPush;
use Bt\Production\Models\ProductionDelay;
use RainLab\User\Models\UserGroup;
use Bt\Sales\Models\Quoteitems;
use Bt\Inventory\Models\BlendedPurchase;

/**
 * Push Back-end Controller
 */
class Push extends Controller
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
    public $importExportConfig = 'config_export.yaml';

    public function __construct()
    {
        parent::__construct();
        // $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        // $this->addCss("/plugins/bt/production/assets/css/prettyPhoto.css", "1.0.0");

        // $this->addJs("/plugins/bt/production/assets/js/jquery.prettyPhoto.js");
        // $this->addJs("/plugins/bt/production/assets/js/photo.js");

        BackendMenu::setContext('Bt.Production', 'production', 'push');
    }

    public function printBlendedPrices()
    {
        $list = BlendedPurchase::where('locked_date', '>', Carbon::now()->subMonths(10))->orderby("locked_date")->get();
        echo '<table class="table data">';
        $td1 = "<tr><td><b>Month</b></td>";
        $td2 = "<tr><td>Price</td>";
        $td3 = "<tr><td>Is Locked</td>";

        foreach ($list as $key => $value) {
            $timestamp = strtotime($value->locked_date);
            $td1 .= "<td style='text-align: center;'>".date("M-Y", $timestamp)."&nbsp;&nbsp;&nbsp; <a href='/backend/bt/inventory/blendedpurchase/update/".$value->id."'><i  class='icon-line-chart icon-1x'></i> View</a></td>";
            $td2 .= "<td style='text-align: center;'>R ".$value->price."</td>";
            $td3 .= "<td style='text-align: center;'>".($value->is_locked?'<i  class="icon-lock icon-2x"></i>':'<i style="color: #ff3e1d" class="icon-unlock icon-2x"></i>')."</td>";
        }
        $td1 .= "</tr>";
        $td2 .= "</tr>";
        $td3 .= "</tr>";

        echo "$td1 $td2 $td3 </table>";
    }

    public function onSendRequestProductionNotification($id = null)
    {
        $obj = ModelPush::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;#.' '.$user->last_name;
        $name .= ' '.$user->last_name;


        ##SEND EMAIL
        $url = Config::get('app.url').'/backend/bt/production/push/update/'.$id;

        $link = "
        * View Production: $url";


        $x = 0;

        $groupusers = UserGroup::where('id', 14)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['push'] = $obj;
            $data['ref'] = "BT-Production-".$obj->id;
            $data['response_details'] =  $link;
            Mail::send('bt.notify.production.productionapproval', $data, function ($message) use ($data) {
                $message->subject("BT Industrial Production Approval: ".$data['ref']);
                $message->to($data['to_email'], $data['name']);

                $message->attach(Config::get('app.url')."/quote/item/download/".$data['push']['quote']['id'].".pdf", ['as' => 'Original Quote.pdf']);
                $message->attach(Config::get('app.url')."/quote/invoice/download/".$data['push']['quote']['id'], ['as' => 'Invoice.pdf']);//#INVOICE
                $message->attach(Config::get('app.url')."/quote/response/download/".$data['push']['quote']['id']."/10", ['as' => 'PO.pdf']);#po
                $message->attach(Config::get('app.url')."/quote/response/download/".$data['push']['quote']['id']."/9", ['as' => 'Singed Quote.pdf']);
                #SIGNED QOUTE
            });
        }


        \Flash::success("Thank you, you request have been sent to $x users");
    }

    public function onSendSalesEmail($id = null)
    {
        $x = Input::get('id');

        $obj = ProductionDelay::find($x); #Lined to Push->qoute->salespers
        $push = \Bt\Production\Models\Push::find($obj->push_id);
        $pipes = Pipe::where("id", '=', $obj->pipe_id)->get()->first();

        $name = BackendAuth::getUser();
        $data = [];
        ##TO SALES PERSON

        $data['to_name'] = $push->quote->user->name; #sales persons name
        $data['to_email'] = $obj->quote->user->email;

        #FROM UPDATE PERSON SENDING

        $data['username'] = $name->first_name;
        $data['start'] = $obj->start_date_delay;
        $data['end'] = $obj->expected_date_resume;
        $data['delayreason'] = $obj->delayreason->name;
        $data['items'] = $pipes->quoteitems->description;
        $data['quote'] = $push->quote->id;
        $data['client'] = $push->quote->company_name;
        $data['ref'] = "BT-Production Delay-".$push->quote->id;


        Mail::send('bt.notify.production.delay', $data, function ($message) use ($data) {
            $message->subject($data['ref']);
            $message->to($data['to_email'], $data['to_name']);
        });

        \Flash::success("Thank you, you request have been sent to ".  $push->quote->user->name . " " . $x . " times");
    }
    public function onSendPending()
    {
        $push = \Bt\Production\Models\Push::all();
        $data = [];
        $groupusers = UserGroup::where('id', 6)->first();

        foreach ($groupusers->users as $key => $value) {
            $data['name'] = $value->name;
            $data['ref'] = "BT Production Pending/Delivery";
            $data['to_email'] = $value->email;
            $data['push'] = $push;
            Mail::send('bt.notify.production.pending', $data, function ($message) use ($data) {
                $message->subject($data['ref']);
                $message->to($data['to_email'], $data['name']);
            });
        }

        Flash::success("Message has been sent to executives");
    }

    public function makeThumb($src_file_name)
    {

        $supported_image = array('gif','jpg','jpeg','png');
        $supported_pdf = array('pdf');
        $ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
        if (in_array($ext, $supported_image)) {
            return ' <img src="'.$src_file_name.'" style="width: 100%; "  > ';
        } elseif (in_array($ext, $supported_pdf)) {
            return ' <embed src="'.$src_file_name.'" width="100%"  height="100%" /> ';
        }
        return '';
    }


//    public function relationExtendViewWidget($widget, $field, $model)
//    {
//        // Make sure the model and field matches those you want to manipulate
//        if (!$model instanceof \Bt\Production\Models\Pipe) {
//            return;
//        }
//
//        // This will work
//        $widget->bindEvent('list.extendColumns', function () use ($widget) {
//            $widget->removeColumn('id');
        });
//    }

    public function listExtendColumns($list)
    {
        if ($this->user->hasAccess('bt.production.analysis')) {
            $list->addColumns([
                'blendedprice' => [
                    'label' =>  'Blended Price',
                    'relation' =>  'blendedprice',
                    'select' =>  "concat('R',price)",
                    'invisible' =>  'true'
                ],
            ]);
        }
    }
}
