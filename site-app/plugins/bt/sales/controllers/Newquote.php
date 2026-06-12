<?php

namespace Bt\Sales\Controllers;

use BackendMenu;
use BackendAuth;
use Backend\Classes\Controller;
use Bt\Production\Models\Pipe;
use Bt\Sales\Models\Diameter;
use Bt\Sales\Models\SrnItem;
use Bt\Sales\Models\TransportFee;
use Config;
use EJ\Grid;
use EJ\Grid\Column;
use Flash;
use App;
use Carbon\Carbon;
use Illuminate\Validation\Rules\In;
use RainLab\User\Models\User;
use Redirect;
use Backend;
use Str;
use Mail;
use Bt\Sales\Models\Newquote as ModelNewquote;
use RainLab\User\Models\UserGroup;
use Bt\Sales\Models\Client;
use Bt\QC\Models\Reqcertificate;
use Session;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\QuoteApprovalIntro;

use Input;

/**
 * Newquote Back-end Controller
 */
class Newquote extends Controller
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

    public $requiredPermissions = ['bt.sales.quotes', 'bt.sales.sales'];

    /**
     * @var string subject of email to be sent
     */
    public string $quoteApprovalEmailSubject = '';

    /**
     * @var string body of email to be sent
     */
    public string $quoteApprovalEmailBody = '';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Sales', 'sales', 'newquote');
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->addJs('/plugins/bt/sales/assets/js/newquote.js', "1.0.0");

        //Export Filter
        if (Session::has('quotestart') && Session::get('quotestart') > 0) {
            $this->vars['quotestart'] = Session::get('quotestart');
            $this->vars['quoteend'] = Session::get('quoteend');
        } else {
            $this->vars['quotestart'] = Carbon::now()->subDays(30);
            $this->vars['quoteend'] = Carbon::now();
        }
        $RateUpdate = TransportFee::orderBy('date', 'desc')->where('active', 1)->first();
        if(isset($RateUpdate->date)){
            $new_date = new \DateTime($RateUpdate->date);
            if($new_date->format('Y-m') >= Carbon::now()->format('Y-m')){
                $this->vars['flag_date'] = 0;
            }else{
                $this->vars['flag_date'] = 1;
            }
        }else{
            $this->vars['flag_date'] = 0;
        }


    }

    public function InjectDataTable()
    {
        $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/dataTables.bootstrap5.min.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/responsive.bootstrap5.min.css", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/backlaout.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/datatables.min.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/dataTables.bootstrap5.min.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/dataTables.responsive.min.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/responsive.bootstrap5.min.js", "1.0.0");
    }

    public function onSendQuoteToMe($id = null)
    {
        $q = ModelNewquote::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $data = [
            'name' => $q->billing_name,
            'company_name' => $q->company_name,
            'response_quote' => $user->first_name,
            'email_to' => $user->email,
            'notes' =>  null,
            'ref' => "#BT-" . $q->id
        ];

        Mail::send('BT.sales.newquote', $data, function ($message) use ($data, $q) {
            $message->to($data['email_to'], $data['response_quote']);
            $message->subject("BT Industrial Quote: " . $data['ref']);
            #$pdf = PDF::loadView('bt.sales::pdfitem',array('quote'=>$quote))->stream();
            #$message->attach( $pdf->download($quote->id.'.pdf'), ['as' => 'newquote.jpg']);
            $message->attach(Config::get('app.url') . "/quote/item/download/" . $q->id . ".pdf", ['as' => 'newquote.pdf']);
        });

        \Flash::success("Thank you, you request have been sent to " . $user->email);
    }


    public function onSendRequestInvoiceNotification($id = null)
    {
        $quote = ModelNewquote::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;


        ##SEND EMAIL
        $url = Config::get('app.url') . '/backend/bt/sales/newquote/update/' . $id;

        $link = "
        * View Quote: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 5)->first();

        if ($groupusers && $groupusers->users) {
            foreach ($groupusers->users as $key => $value) {
                $x++;
                $data = [];
                $data['to_name'] = $value->name;
                $data['to_email'] = $value->email;
                $data['sales_name'] = $quote->user->name;

                $data['billing_name'] = $quote->billing_name;
                $data['company_name'] = $quote->company_name;
                $data['quote_total'] = $quote->quote_total;
                $data['quote'] = $quote;
                $data['notes'] = '';

                $data['ref'] = "#BT-" . $quote->id;
                $data['response_details'] =  $link;

                Mail::send('BT.sales.response.notifyinvoice', $data, function ($message) use ($data) {
                    //$message->subject("BT Industrial Production Approval: ".$data['ref']);

                    $message->to($data['to_email'], $data['to_name']);

                    $message->attach(Config::get('app.url') . "/quote/item/download/" . $data['quote']['id'] . ".pdf", ['as' => 'Original Quote.pdf']);
                    $message->attach(Config::get('app.url') . "/quote/invoice/download/" . $data['quote']['id'], ['as' => 'Invoice.pdf']); //#INVOICE
                    $message->attach(Config::get('app.url') . "/quote/response/download/" . $data['quote']['id'] . "/10", ['as' => 'PO.pdf']); #po
                    $message->attach(Config::get('app.url') . "/quote/response/download/" . $data['quote']['id'] . "/9", ['as' => 'Singed Quote.pdf']);
                    #SIGNED QOUTE

                });
            }
        }


        \Flash::success("Thank you, you request have been sent to $x users");
    }



    public  function backorders()
    {
        $this->InjectDataTable();
        $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        $this->addCss("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", "1.0.0");

        $this->addJs("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js", "1.0.0");

        $this->addCss("/plugins/bt/sales/assets/css/bootstrap.min.css", "1.0.0");
        $this->pageTitle = "Back Order";
        BackendMenu::setContext('Bt.Sales', 'sales', 'backorders');
        $objClient = Client::where('id', "!=", 3)->whereHas('quotes', function ($query) {
            $query->where('active', 1);
            $query->whereHas('items', function ($query) {
                $query->where('isbackorder', 1);
            });
            $query->whereHas('qpush', function ($query) {
                $current = Carbon::now();
                $startdate = $current->addDays(-30);
                $query->where('created_at', '>', "2021-01-01 23:59:00");
                $query->whereHas('approved', function ($query) {
                    $query->where('status_id', 1);
                });
                $query->whereHas('pipes', function ($query) {
                });
            });
        })->orderby("company_name")->get();
        ##CLEAN DATA
        ##IF 100% DELIVERED THEN REMOVE
        foreach ($objClient as $ckey => &$client) {
            foreach ($client->quotes as $qkey => &$quote) {
                $count = 0;
                foreach ($quote->items as $key => &$value) {
                    if (isset($value->product)) {
                        if ($value->product->value > 0 && $value->unitlength > 0) {
                            $count = $count + $value->units;
                        }
                        $value["gotbackorder"] = 1;
                        if (isset($value->pipe->delivered)) {
                            if ($value->pipe->delivered->sum("units") >= $value->units) {
                                $value["gotbackorder"] = 0;
                            }
                        }
                        if ($value->isbackorder == 0) {
                            $value["gotbackorder"] = 0;
                        }
                    }
                }

                $vs = 0;
                foreach ($quote->srn as $pkey => $pvalue) {
                    if (isset($pvalue->items))
                        $vs = $vs + $pvalue->items()->sum('units');
                }
                if ($count == 0) {
                    ##remove items
                } else {
                    if ($vs >= $count) {
                    } else {
                        $client["gotbackorder"] = 1;
                    }
                }
            }
            # code...
        }
        $this->vars['list'] = $objClient;
    }

    public function backorderbydelivery()
    {
        $this->InjectDataTable();
        $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        $this->addCss("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", "1.0.0");
        $this->addJs("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js", "1.0.0");
        $this->pageTitle = "Back Order By Delivery";
        BackendMenu::setContext('Bt.Sales', 'sales', 'backorderbydelivery');



        $obj = null;


        $sales = \Input::get('sales');
        $client = \Input::get('client');
        $pipe = \Input::get('pipe');


        if ((isset($sales) && !empty($sales)) || (isset($client) && !empty($client)) || (isset($pipe) && !empty($pipe))) {
            if (!empty($sales) && !empty($client) && !empty($pipe)) {
                $obj = Quoteitems::find($pipe)->quote()->where('client_id', $client)->where('id', "!=", 3)->where('created_at', '>', "2021-01-01 23:59:00")->where('user_id', $sales)
                    ->whereHas('qpush', function ($query) {
                        $current = Carbon::now();
                        $startdate = $current->addDays(-30);
                        $query->where('created_at', '>', "2021-01-01 23:59:00");

                        $query->whereHas('pipes', function ($query) {
                        });
                    })->get();
                $clientName = Client::find($client);

                $this->vars['client'] = $clientName->id;
                $user = User::find($sales);
                $pipename = Quoteitems::find($pipe);
                $this->vars['pipe'] = $pipename->id;
                $this->vars['sales'] = $sales;
                Flash::success("Showing results for only " . $user->name . " " . $user->surname . " and " . $clientName->company_name . " and pipe " . $pipename->description);
            }
            if (!empty($sales) && empty($client) && !empty($pipe)) {
                $obj = Quoteitems::find($pipe)->quote()->where('client_id', ">", 0)->where('id', "!=", 3)->where('created_at', '>', "2021-01-01 23:59:00")->where('user_id', $sales)->whereHas('qpush', function ($query) {
                    $current = Carbon::now();
                    $startdate = $current->addDays(-30);
                    $query->where('created_at', '>', "2021-01-01 23:59:00");

                    $query->whereHas('pipes', function ($query) {
                    });
                })->get();
                $user = User::find($sales);
                $pipename = Quoteitems::find($pipe);
                $this->vars['pipe'] = $pipename->id;
                $this->vars['sales'] = $sales;
                Flash::success("Showing results for only " . $user->name . " " . $user->surname . " and pipe " . $pipename->description);
            }
            if (empty($sales) && !empty($client) && !empty($pipe)) {
                $obj = Quoteitems::find($pipe)->quote()->where('client_id', $client)->where('id', "!=", 3)->where('created_at', '>', "2021-01-01 23:59:00")->whereHas('qpush', function ($query) {
                    $current = Carbon::now();
                    $startdate = $current->addDays(-30);
                    $query->where('created_at', '>', "2021-01-01 23:59:00");

                    $query->whereHas('pipes', function ($query) {
                    });
                })->get();
                $clientName = Client::find($client);

                $this->vars['client'] = $clientName->id;

                $pipename = Quoteitems::find($pipe);
                $this->vars['pipe'] = $pipename->id;

                Flash::success("Showing results for only " . $clientName->company_name . " and pipe " . $pipename->description);
            }
            if (!empty($sales) && (!empty($client) && isset($client)) && empty($pipe)) {
                $obj = ModelNewquote::where('client_id', $client)->where('id', "!=", 3)->where('created_at', '>', "2021-01-01 23:59:00")->where('user_id', $sales)->whereHas('qpush', function ($query) {
                    $current = Carbon::now();
                    $startdate = $current->addDays(-30);
                    $query->where('created_at', '>', "2021-01-01 23:59:00");

                    $query->whereHas('pipes', function ($query) {
                    });
                })->get();
                $clientName = Client::find($client);

                $this->vars['client'] = $clientName->id;
                $user = User::find($sales);
                $this->vars['sales'] = $sales;
                Flash::success("Showing results for only " . $user->name . " " . $user->surname . " and " . $clientName->company_name);
            }

            if (!empty($sales) && (empty($client) || !isset($client)) && empty($pipe)) {
                $obj = ModelNewquote::where('client_id', '>', 0)->where('id', "!=", 3)->where('created_at', '>', "2021-01-01 23:59:00")->where('user_id', $sales)->get();
                $user = User::find($sales);

                $this->vars['sales'] = $sales;
                Flash::success("Showing results for only " . $user->name . " " . $user->surname);
            }
            if (empty($sales) && !empty($client) && empty($pipe)) {
                $obj = ModelNewquote::where('client_id', $client)->where('id', "!=", 3)->where('created_at', '>', "2021-01-01 23:59:00")->get();
                $clientName = Client::find($client);

                $this->vars['client'] = $clientName->id;
                Flash::success("Showing results for only " . $clientName->company_name);
            }
            if ((isset($pipe) && !empty($pipe)) && (empty($sales) && empty($client))) {
                $obj = Quoteitems::find($pipe)->quote()->where('client_id', ">", 0)->where('id', "!=", 3)->where('created_at', '>', "2021-01-01 23:59:00")->get();
                $pipename = Quoteitems::find($pipe);
                $this->vars['pipe'] = $pipename->id;
                Flash::success("Showing results for only pipe " . $pipename->description);
            }
        }
        if (empty($sales) && empty($client) && empty($pipe)) {
            $obj = ModelNewquote::where('ponumber', "<>", "")->whereNotnull('ponumber')->where('client_id', ">", 0)->where('id', "!=", 3)->where('created_at', '>', "2021-01-01 23:59:00")->get();
        }



        $this->vars['list'] = $obj;
        $this->vars['groupusers'] = UserGroup::where('id', 3)->first();
        $this->vars['clientobject'] = Client::all();
        $this->vars['itemsobject'] = Quoteitems::all();
    }


    public function onSendQCRequest($id = null)
    {

        $q = ModelNewquote::find($id);
        $user = BackendAuth::getUser();
        if (!$user) return;

        $requester = Reqcertificate::where('quote_id', $q->id)->get();
        foreach ($requester as $request) {
            $coc = $request->coc;
            $coa = $request->coa;
        }

        if (!empty($coc) && !empty($coa)) {
            $msg = 'both COC and COA';
        } elseif (!empty($coc)) {
            $msg = 'COC';
        } elseif (!empty($coa)) {
            $msg = 'COA';
        }

        $groupusers = UserGroup::where('id', 20)->first();
        foreach ($groupusers->users as $key => $value) {
            $data = [
                'qc' => $value->first_name . ' ' . $value->last_name,
                'salesperson' => $user->first_name . ' ' . $user->last_name,
                'certificate' => $msg,
                'email_to' => $value->email,
                'quote' =>  $q->id
            ];
            Mail::send('bt.sales.reqcertificates.notify', $data, function ($message) use ($data, $q) {
                $message->to($data['email_to']);
                $message->subject("BT Sales Request COC certificates: ");
            });
        }

        \Flash::success("Good Day, your request have been sent to the QC Team");
    }

    public function listExtendQuery($query)
    {
    }

    public function customersurvey()
    {
        $this->InjectDataTable();
        BackendMenu::setContext('Bt.Sales', 'sales', 'customersurvey');
        $this->pageTitle = "Customer Survey";
    }

    public function onRemove($id = null)
    {
        $obj = Quoteitems::find(Input::get('id'));
        $obj->isbackorder = 0;
        $obj->save();




        \Flash::success('Item Removed ' . Input::get('id'));
    }
    public function onPipeRequest()
    {

        $obj = Quoteitems::find(Input::get('id'));
        $newquote =  ModelNewquote::where('ponumber', "<>", "")->whereNotnull('ponumber')
            ->where('id', "!=", 3)->get();
        $this->vars['original_quote'] = $obj->quote->company_name . ' | ' . $obj->quote_id;
        $this->vars['original_quote_item'] = $obj->description . ' | ' . $obj->id;
        $this->vars['clients'] = $newquote;

        return [
            '#piperequest' => $this->makePartial('piperequest')
        ];
    }
    public function onAdd()
    {
        $from_quote  = (int) filter_var(Input::get('from_quote'), FILTER_SANITIZE_NUMBER_INT);
        $string_start = explode("|", Input::get('item'));
        $item = (int) filter_var($string_start[1], FILTER_SANITIZE_NUMBER_INT);
        $dest_quote = (int) filter_var(Input::get('to_quote'), FILTER_SANITIZE_NUMBER_INT);
        $obj = \Bt\Sales\Models\Piperequest::where('quote_item_id', $item)->where('to_quote_id', $dest_quote)->where('from_quote_id', $from_quote)->get();
        $user = BackendAuth::getUser();
        if (!$user) return;
        if ($obj->count('from_quote_id') > 0) {
            foreach ($obj as $piperequester) {
                $updateObj = \Bt\Sales\Models\Piperequest::find($piperequester->id);
                $updateObj->from_quote = $from_quote;
                $updateObj->quote_item = $item;
                $updateObj->to_quote = $dest_quote;
                $updateObj->updated_by = $user->id;
                $updateObj->save();
                $email = new Piperequest();
                $email->onRequestPipe($updateObj->id);
                \Flash::success('Updated request for approval ' . Input::get('item'));
            }
        } else {
            $newObj = new \Bt\Sales\Models\Piperequest();
            $newObj->from_quote = $from_quote;
            $newObj->quote_item = $item;
            $newObj->to_quote = $dest_quote;
            $newObj->created_by = $user->id;
            $newObj->save();
            $email = new Piperequest();
            $email->onRequestPipe($newObj->id);
            \Flash::success('Item has been sent for approval to associate ' . Input::get('item'));
        }
    }

    public function backorderclient()
    {
        $this->InjectDataTable();
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        BackendMenu::setContext('Bt.Sales', 'sales', 'backorderclient');
        $this->pageTitle = "Back Order by Client";
        $pipe_class = array();
        $pipe_length = array();
        if (\Input::has('enddate')) {
            $enddate = \Input::get('enddate');
        } else {
            $enddate = date('Y-m-d');
        }
        if (\Input::has('startdate')) {
            $startdate = \Input::get('startdate');
        } else {
            $startdate = date('Y-m-d', strtotime(date('Y-m-d') . ' - ' . 30 . ' days'));
        }
        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;
        $clients = Client::all();
        $srnItems = array();
        $pipe_class = \Bt\Sales\Models\PNRating::all();
        $pipe_length = Diameter::all();
        $this->vars["clients"] = $clients;
        $this->vars['pipe_class'] = $pipe_class;
        $this->vars['pipe_length'] = $pipe_length;

        $myclient = Input::get('client');
        $myPNClass = Input::get('pipe_class');
        $myLength = Input::get('pipe_length');

        $newquote =  ModelNewquote::with(['items' => function ($query) {
            $query->where('isbackorder', "=", 1);
        }])
            ->whereDoesntHave('responses', function ($query){
                $query->where('quote_status_id', 15)->orWhere('quote_status_id', 20);
            })
            ->where('ponumber', "<>", "")->whereNotnull('ponumber')
            ->where('id', "!=", 3)
            ->whereBetween('created_at', array($startdate, $enddate));

        if (isset($myclient) && $myclient > 0) {
            $clientName = Client::find($myclient);
            if (isset($clientName)) {
                $this->vars['client'] = $clientName->id;
            }
            $newquote = $newquote->where('client_id', $myclient);
        } else {
            $newquote = $newquote->where('client_id', ">", 0);
        }

        if (isset($myPNClass) && $myPNClass > 0) {
            $className = \Bt\Sales\Models\PNRating::find($myPNClass);
            if (isset($className)) {
                $this->vars['pipeClass'] = $className->id;
            }
            $newquote = $newquote->whereHas('items', function ($query) use ($myPNClass) {
                $query->where('id', '<>', null)->whereHas('product', function ($query) use ($myPNClass) {
                    $query->where('id', '<>', null)->whereHas('PNRating', function ($query) use ($myPNClass) {
                        $query->where('id', $myPNClass);
                    });
                });
            });
        }

        if (isset($myLength) && $myLength > 0) {
            $lengthName = Diameter::find($myLength);
            if (isset($className)) {
                $this->vars['pipeLength'] = $lengthName->id;
            }
            $newquote = $newquote->whereHas('items', function ($query) use ($myLength) {
                $query->where('id', '<>', null)->whereHas('product', function ($query) use ($myLength) {
                    $query->where('id', '<>', null)->whereHas('Diameter', function ($query) use ($myLength) {
                        $query->where('id', $myLength);
                    });
                });
            });
        }
        $newquote = $newquote->get();


        foreach ($newquote as $quote) {
            foreach ($quote->items as $item) {
                if (!empty($item->delivered)) {
                    $srnObj = $item->delivered;

                    $srnItems['item'][$item->id] = $item->getSameItemDelivered($item->quote_id, $item->product_id, $item->unitlength, '', '')->sum('units');
                    foreach ($srnObj as $srnitem) {
                        $srnItems['srn'][$item->id][$srnitem->srn_id] = $srnitem->srn_id;
                        $srnItems['invoice'][$item->id][] = $srnitem->srn->srninvoice;
                    }
                }
            }
        }


        // foreach($newquote as $quote) {
        //     foreach($quote->items as $item) {
        //         if(isset($item->pipe->id)){ ##id produced
        //             $srnObj = SrnItem::where('pipe_id', $item->pipe->id)->get(); ###

        //             $srnItems['item'][$item->pipe->id] = $srnObj->sum('units');
        //             foreach ($srnObj as $srnitem){
        //                 $srnItems['srn'][$item->pipe->id][$srnitem->srn_id] = $srnitem->srn_id;
        //                 $srnItems['invoice'][$item->pipe->id][] = $srnitem->srn->srninvoice;

        //             }
        //         }
        //     }
        // }

        $this->vars['srn_item'] = $srnItems;
        $this->vars['obj'] = $newquote;
    }


    public function quote_overview()
    {
        $this->InjectDataTable();
        $this->pageTitle = "Quote Overview";
        BackendMenu::setContext('Bt.Sales', 'sales', 'quote_over');
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js');
        $this->addJs('/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.js');
        $this->addJs('/themes/hambern-hambern-blank-bootstrap-4/assets/packages/interaction/main.js');
        $this->addJs('/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.js');
        $this->addJs('/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.js');
        $this->addJs('/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.js');
        $newquote = ModelNewquote::orderBy('id', 'desc')->where('ponumber', '<>', null)->get();
        $this->vars['quoteObj'] = $newquote;
        $callquoute = Input::get('quote');
        $newquote = ModelNewquote::find($callquoute);
        if (!empty($newquote) && isset($newquote->ponumber)) {
            foreach ($newquote->responses as $response) {
                $calender[] = array('title' => $response->status->name, 'start' => $response->created_at, 'end' => $response->created_at, 'color' => 'darkblue');
            }
            foreach ($newquote->items as $item) {
                $calender[] = array('title' => 'Item ' . $item->description . ' created.', 'start' => $item->created_at, 'end' => $item->created_at, 'url' => 'update/' . $newquote->id . '#primarytab-item-wish', 'color' => 'darkblue');
                if ($item->pipe) {
                    $itemSchedule = $item->pipe;
                    $calender[] = array('title' => 'Pushed to Production: ' . $item->description, 'start' => $itemSchedule->created_at, 'end' => $itemSchedule->created_at, 'color' => 'darkblue', 'url' => '/backend/bt/production/push/update/' . $itemSchedule->push_id);
                    foreach ($itemSchedule->schedules as $schedule) {
                        if (isset($schedule->controlsheet_id))
                            $calender[] = array('title' => 'Production Day ' . $schedule->production_days . ' Shift: ' . $schedule->controlsheet->shift, 'start' => $item->created_at, 'end' => $item->created_at, 'color' => 'darkblue');
                        else
                            $calender[] = array('title' => 'Production Day ' . $schedule->production_days . ' Shift: No Control Sheet', 'start' => $item->created_at, 'end' => $item->created_at, 'color' => 'darkblue');
                    }
                }
            }
            foreach ($newquote->itemscat as $catitem) {
                $calender[] = array('title' => 'Item ' . $catitem->description . ' created.', 'start' => $catitem->created_at, 'end' => $catitem->created_at, 'url' => 'update/' . $newquote->id . '#primarytab-item-wish-catalogue', 'color' => 'darkblue');
            }
            $this->vars['selectquote'] = $newquote->id;
        } else
            $calender[] = 0;
        $this->vars['calender'] = $calender;
        $this->vars['quoteLive'] = $newquote;
    }


    public function onDateFilter()
    {
        if (\Input::has('quotestart') && Input::get('quotestart') > 0) {
            Session::put('quotestart', \Input::get('quotestart'));
            Session::put('quoteend', \Input::get('quoteend'));
            Flash::success('Date filters have been applied');
        } else {
            Flash::warning('Nothing has been applied');
        }
    }


    public function onSendForm($id = null)
    {
        //Create array to hold email details
        $data = [];
        //get visitors
        $concession = ModelNewquote::find($id);
        if (!isset($concession->invited)) {
            $concession->invited = 1;
            $concession->save();
        }
        //Get the app url (This helps when you test locally)
        $url = Config::get('app.url') . '/concessions/form/' . $concession->id . "/" . $concession->key_pass;
        if (!empty($concession->email)) {
            $data['to_email'] = $concession->email;
            $data['name'] = $concession->billing_name;
            $data['sales_name'] = $concession->user;
            $data['url'] = $url;
            //Send Email with data
            \Mail::send('BT.sales.concession.send', $data, function ($message) use ($data) {
                $message->subject("BT Industrial Group Non-SABS Concession Form");
                $message->to($data['to_email'], $data['name']);
            });
            \Flash::success("Your invitation was sent");
            return Redirect::refresh();
        } else {
            \Flash::error("Please make sure you fill in the required fields");
        }
    }

    public function onAccept($id = null)
    {
        $concession = ModelNewquote::find($id);
        $concession->accept_date = Carbon::now();
        $concession->save();
        return Redirect::refresh();
    }

    /**
     * triggers when client approve link is clicked
     * @return void
     */
    public function onSendClienApproval($id = null)
    {
        $quote = ModelNewquote::with('quote_approval_intro')->find($id);
        if (!empty($quote->quote_approval_intro)) {
            $appUrl = env('APP_URL');

            $data = [];
            $data['sales_person'] = ['name' => $quote->user->name . ' ' . $quote->user->surname, 'email' => $quote->user->email];
            $data['client'] = ['name' => $quote->billing_name, 'email' => $quote->email];
            $data['subject'] = $quote->quote_approval_intro->subject;
            $data['body'] = $quote->quote_approval_intro->body;
            $data['client_quote'] = "$appUrl/quote/item/download/$quote->key_pass/$quote->id.pdf";

            Mail::send('bt.sales::mail.quote_approval', $data, function ($message) use ($data) {

                $message->to([
                    $data['sales_person']['email'] => $data['sales_person']['name'],
                    $data['client']['email'] => $data['client']['email']
                ]);

                // $message->attach($data['client_quote']);

            });

            $quote->quote_approval_activity_log()->create([
                'title' => 'Quote approval',
                'description' => "Quote approval email was sent to $quote->billing_name"
            ]);

            Flash::success('Thank you! Email was sent.');
            return;
        }

        Flash::error("Please create a quote approval intro email template first.");
    }

    /**
     * triggers when preview email button is clicked
     * @return void
     */
    public function onPreviewEmail($id = null)
    {
        $quoteApprovalIntro = QuoteApprovalIntro::where('quote_id', $id)->first();

        if (!empty($quoteApprovemailalIntro)) {
            return trim("
                    <div style=\"height:100%;display:flex;align-items:center;justify-content:center;\">
                        <div>
                            $quoteApprovalIntro->subject
                            <br/>
                            $quoteApprovalIntro->body
                        </div>
                    </div>
                ");
        }

        return trim("
                <div style=\"height:100%;display:flex;align-items:center;justify-content:center;\">
                    No preview available
                </div>
            ");
    }

    public function onRequestExco($id = null)
    {
        $quote = ModelNewquote::find($id);

        if($quote->dispatch->count() == 0){
            Flash::error("There is no load for this quote. Please add one and then push to production");
        } else {
            $groupusers = UserGroup::where('id', 6)->first();
            $url = Config::get('app.url') . '/backend/bt/sales/newquote/update/' . $quote->id;
            foreach ($groupusers->users as $key => $value) {
                #REQUEST DISCOUNT
                $data = [
                    'email' => 'BT.sales.response.productionrequest',
                    'to_name' => $value->name,
                    'to_email' =>  $value->email,
                    'sales_name' => $quote->user->name,
                    'billing_name' => $quote->billing_name,
                    'company_name' => $quote->company_name,
                    'quote_total' => $quote->totalincvat,
                    'quoteObj' => $quote,
                    'link' =>  $url,
                    'ref' => "#BT-" . $quote->id
                ];

                Mail::send($data['email'], $data, function ($message) use ($data) {
                    $message->to($data['to_email'], $data['to_name']);
                    $message->getHeaders()->addTextHeader('Importance', 'High');
                });

                Flash::success("Request has been sent to EXCO for approval");
            }
        }
    }
}
