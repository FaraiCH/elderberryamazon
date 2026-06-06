<?php namespace Bt\Reporting\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Logistics\Models\Pipeprice;
use Bt\Production\Models\BtAccount;
use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\Jobcard;
use Bt\Production\Models\JobCardBatch;
use Bt\Production\Models\Pipe;
use Bt\Production\Models\Schedule as ScheduleModel;
use Bt\Sales\Controllers\Piperequest;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\Srn;
use Bt\Sales\Models\SrnItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Bt\Sales\Models\Newquote;

use Input;
use Flash;
use RainLab\User\Models\User;

/**
 * Batchsearch Back-end Controller
 */
class Batchsearch extends Controller
{
    public $implement = [
      /*  'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'*/
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Reporting', 'reporting', 'batchsearch');
    }

    public function batch()
    {

        BackendMenu::setContext('Bt.Reporting', 'reporting', 'batchlist');
        $this->pageTitle = "Batch List";

        $this->addCss("/plugins/bt/reporting/assets/css/bootstrap.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/dataTables.bootstrap4.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/responsive.bootstrap4.min.css", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js", "1.0.0");
        $this->addJs("/plugins/bt/reporting/assets/js/backlaout.js", "1.0.0");

        $this->addJs("https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js", "1.0.0");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js", "1.0.0");
        $this->addJs("//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js", "1.0.0");

         $jobcards = Jobcard::has('controlsheets')->has('batch')->orderBy('id', 'desc')->get();

         $this->vars['jobcards'] = $jobcards;
    }

    public function find()
    {
        BackendMenu::setContext('Bt.Reporting', 'reporting', 'batchsearch');
        $this->pageTitle = "Batch Search";
    }

    public function onSearch(){
        $quoteObj = array();
        $quote = null;
        $client = null;
        $sales_rep = null;
        $jobcard = Jobcard::orderBy('id', 'desc');
        $this->vars['msg'] = "";
        if(Input::has("txtqoute") && Input::get("txtqoute") > 0){
            $chosen_quote = Input::get("txtqoute");
           $jobcard = $jobcard->whereHas('pipe', function($query) use ($chosen_quote){
                $query->where('id', '<>', null)->whereHas('qpush', function ($query) use ($chosen_quote){
                    $query->where('id', '<>', null)->whereHas('quote', function ($query) use ($chosen_quote){
                       $query->where('id', $chosen_quote);
                    });
                });
            });
            if(!empty($jobcard)){
                $jobcard = $jobcard->get();
                foreach($jobcard as $job) {
                    foreach($job->batch as $b){
                        $batch_key = $b->id;
                        if(isset($job->pipe->quoteitems->description)){
                            $date = new \DateTime($job->pipe->quoteitems->created_at);
                            $quoteObj[$batch_key]['batch'] = $job->id  ."-". $b->id;
                            $quoteObj[$batch_key]['item'] = $job->pipe->quoteitems->description;
                            $quoteObj[$batch_key]['ponumber'] = $job->pipe->qpush->quote->ponumber;
                            $quoteObj[$batch_key]['date'] = $date->format('Y-m-d');
                            $quoteObj[$batch_key]['client'] = $job->pipe->qpush->quote->company_name;
                            $client =  $job->pipe->qpush->quote->company_name;
                            $sales_rep = $job->pipe->qpush->quote->user->name . ' ' . $job->pipe->qpush->quote->user->surname;
                            $quoteObj[$batch_key]['quote'] = $job->pipe->qpush->quote_id;
                            $quote = $job->pipe->qpush->quote_id;
                            $quoteObj[$batch_key]['order'] = $job->pipe->quoteitems->units;
                            $quoteObj[$batch_key]['produced'] = $job->pipe->getTotalProduced();
                            if($quoteObj[$batch_key]['produced'] == 0){
                                $quoteObj[$batch_key]['extra'] = 0 ;
                            }else{
                                $quoteObj[$batch_key]['extra'] = $job->pipe->getTotalProduced() - $job->pipe->quoteitems->units ;
                            }

                            $quoteObj[$batch_key]['delivered'] = $job->pipe->getTotalDelivered();
                            $quoteObj[$batch_key]['yard'] =  $quoteObj[$batch_key]['produced'] - $quoteObj[$batch_key]['delivered'];
                        }
                    }
                    $counter = 0;
                    $btaccount = BtAccount::with(['fromschedule'])->where('quote_id', Input::get("txtqoute"))->get();
                    if(!empty($btaccount)){
                        foreach($btaccount as $item){
                            $counter++;
                            if(isset($item->fromschedule->controlsheet->jobcard)) {
                                $batch_key = 'Overruns' . $counter . $item->fromschedule->controlsheet->batch_id;
                                $job = $item->fromschedule->controlsheet->jobcard;
                                $date = new \DateTime($job->pipe->quoteitems->created_at);
                                $quoteObj[$batch_key]['batch'] = $job->id . "-" . $b->id;
                                $quoteObj[$batch_key]['overrun'] = "Yes";
                                $quoteObj[$batch_key]['pipe'] = $item->pipe_id;
                                $quoteObj[$batch_key]['item'] = $item->description . ' <b>(Overruns)</b>';
                                $quoteObj[$batch_key]['ponumber'] = $job->pipe->qpush->quote->ponumber;
                                $quoteObj[$batch_key]['date'] = $date->format('Y-m-d');
                                $quoteObj[$batch_key]['client'] = $job->pipe->qpush->quote->company_name;
                                $client = $job->pipe->qpush->quote->company_name;
                                $sales_rep = $job->pipe->qpush->quote->user->name . ' ' . $job->pipe->qpush->quote->user->surname;
                                $quoteObj[$batch_key]['quote'] = $job->pipe->qpush->quote_id;
                                $quote = $job->pipe->qpush->quote_id;
                                $quoteObj[$batch_key]['order'] = '--';
                                $quoteObj[$batch_key]['produced'] = $item->pipe->getTotalProduced();
                                if ($quoteObj[$batch_key]['produced'] == 0) {
                                    $quoteObj[$batch_key]['extra'] = 0;
                                } else {
                                    $quoteObj[$batch_key]['extra'] = $item->pipe->getTotalProduced() - $job->pipe->quoteitems->units;
                                }

                                $quoteObj[$batch_key]['delivered'] = $item->pipe->getTotalDelivered();
                                $quoteObj[$batch_key]['yard'] = $quoteObj[$batch_key]['produced'] - $quoteObj[$batch_key]['delivered'];
                            }
                        }

                    }
                }

            }


            $this->vars['quote'] = $quoteObj;
            $this->vars['client'] = $client;
            $this->vars['quoter'] = $quote;
            $this->vars['sales'] = $sales_rep;

        }else if(Input::has("txtbatch") && !empty(Input::get("txtbatch")) ) {
            if(strpos(Input::get("txtbatch"), '-')){
                $ex = explode('-', Input::get("txtbatch"));
                $batch_no = (int) filter_var($ex[1], FILTER_SANITIZE_NUMBER_INT);
                $jobcard_id = (int) filter_var($ex[0], FILTER_SANITIZE_NUMBER_INT);
                $jobcard = $jobcard->where('id', $jobcard_id)->with(['batch' => function($query) use($batch_no){
                    return $query->where('id', $batch_no);
                }]);
                if(!empty($jobcard)){
                    $jobcard = $jobcard->get();
                    foreach($jobcard as $job) {
                        foreach($job->batch as $b){
                            $batch_key = $b->id;
                            if(isset($job->pipe->quoteitems->description)){
                                $date = new \DateTime($job->pipe->quoteitems->created_at);
                                $quoteObj[$batch_key]['batch'] = $job->id  ."-". $b->id;
                                $quoteObj[$batch_key]['item'] = $job->pipe->quoteitems->description;
                                $quoteObj[$batch_key]['ponumber'] = $job->pipe->qpush->quote->ponumber;
                                $quoteObj[$batch_key]['date'] = $date->format('Y-m-d');
                                $quoteObj[$batch_key]['client'] = $job->pipe->qpush->quote->company_name;
                                $client =  $job->pipe->qpush->quote->company_name;
                                $sales_rep = $job->pipe->qpush->quote->user->name . ' ' . $job->pipe->qpush->quote->user->surname;
                                $quoteObj[$batch_key]['quote'] = $job->pipe->qpush->quote_id;
                                $quote = $job->pipe->qpush->quote_id;
                                $quoteObj[$batch_key]['order'] = $job->pipe->quoteitems->units;
                                $quoteObj[$batch_key]['produced'] = $job->pipe->getTotalProduced();
                                if($quoteObj[$batch_key]['produced'] == 0){
                                    $quoteObj[$batch_key]['extra'] = 0 ;
                                }else{
                                    $quoteObj[$batch_key]['extra'] = $job->pipe->getTotalProduced() - $job->pipe->quoteitems->units ;
                                }
                                $quoteObj[$batch_key]['delivered'] = $job->pipe->getTotalDelivered();
                                $quoteObj[$batch_key]['yard'] =  $quoteObj[$batch_key]['produced'] - $quoteObj[$batch_key]['delivered'];
                            }
                        }
                        $counter = 0;
                        $btaccount = BtAccount::with(['fromschedule'])->where('quote_id', $job->pipe->qpush->quote_id)->get();
                        if(!empty($btaccount)){
                            foreach($btaccount as $item){
                                $counter++;
                                if(isset($item->fromschedule->controlsheet->jobcard)) {
                                    $batch_key = 'Overruns'. $counter . $item->fromschedule->controlsheet->batch_id;
                                    $job = $item->fromschedule->controlsheet->jobcard;
                                    $date = new \DateTime($job->pipe->quoteitems->created_at);
                                    $quoteObj[$batch_key]['batch'] = $job->id . "-" . $b->id;
                                    $quoteObj[$batch_key]['overrun'] = "Yes";
                                    $quoteObj[$batch_key]['pipe'] = $item->pipe_id;
                                    $quoteObj[$batch_key]['item'] = $item->description . ' <b>(Overruns)</b>';
                                    $quoteObj[$batch_key]['ponumber'] = $job->pipe->qpush->quote->ponumber;
                                    $quoteObj[$batch_key]['date'] = $date->format('Y-m-d');
                                    $quoteObj[$batch_key]['client'] = $job->pipe->qpush->quote->company_name;
                                    $client = $job->pipe->qpush->quote->company_name;
                                    $sales_rep = $job->pipe->qpush->quote->user->name . ' ' . $job->pipe->qpush->quote->user->surname;
                                    $quoteObj[$batch_key]['quote'] = $job->pipe->qpush->quote_id;
                                    $quote = $job->pipe->qpush->quote_id;
                                    $quoteObj[$batch_key]['order'] = '--';
                                    $quoteObj[$batch_key]['produced'] = $item->pipe->getTotalProduced();
                                    if ($quoteObj[$batch_key]['produced'] == 0) {
                                        $quoteObj[$batch_key]['extra'] = 0;
                                    } else {
                                        $quoteObj[$batch_key]['extra'] = $item->pipe->getTotalProduced() - $job->pipe->quoteitems->units;
                                    }

                                    $quoteObj[$batch_key]['delivered'] = $item->pipe->getTotalDelivered();
                                    $quoteObj[$batch_key]['yard'] = $quoteObj[$batch_key]['produced'] - $quoteObj[$batch_key]['delivered'];
                                }
                            }

                        }
                    }


                    $this->vars['quote'] = $quoteObj;
                    $this->vars['client'] = $client;
                    $this->vars['quoter'] = $quote;
                    $this->vars['sales'] = $sales_rep;
                }
            }else{
                $this->vars['quote'] = array();
                $this->vars['client'] = null;
                $this->vars['quoter'] = null;
                $this->vars['sales'] = null;
            }
        } else{
            $this->vars['quote'] = array();
            $this->vars['client'] = null;
            $this->vars['quoter'] = null;
           $this->vars['msg'] = "Invalid input, please provide quote or batch number";
        }

    }

    public function onStock(){
        $jobcard = Jobcard::find(Input::get('id'));
        $batch = $jobcard->batch->first();
        $this->vars['batch'] = $jobcard->id . '-'. $batch->id;
        $this->vars['quote'] = $jobcard->pipe->quoteitems->quote->id ;
        $this->vars['produced'] = $jobcard->pipe->getTotalProduced();
        $this->vars['item'] = $jobcard->pipe->quoteitems->description;
        $this->vars['delivered'] = $jobcard->pipe->getTotalDelivered();
        $this->vars['yard'] = $jobcard->pipe->getTotalProduced() - $jobcard->pipe->getTotalDelivered();
    }

    public function onAddStock(){
        $dataObj = array();
        if(strpos(Input::get('batch'), '-')){
            $ex = explode('-', Input::get('batch'));
            $batch_no = (int) filter_var($ex[1], FILTER_SANITIZE_NUMBER_INT);
            $jobcard_id = (int) filter_var($ex[0], FILTER_SANITIZE_NUMBER_INT);
            $controlsheets = ControlSheet::where('jobcard_id', $jobcard_id)->where('batch_id',$batch_no)->get();
            foreach ($controlsheets as $controlsheet){
                if(isset($controlsheet->id)) {
                    $schedules = ScheduleModel::where('controlsheet_id', $controlsheet->id)->get();
                    foreach ($schedules as $schedule){
                        if(isset($schedule->id)){
                            $num = (int) filter_var(Input::get('yard'),FILTER_SANITIZE_NUMBER_INT);
                            $quoteitems = $schedule->pipe->quoteitems;
                            $dataObj['quote'] = $quoteitems->quote->id;
                            $dataObj['batch'] = $controlsheet->batch_id;
                            $dataObj['qty'] = $num;
                            $dataObj['length'] = $quoteitems->unitlength;
                            $dataObj['pn'] = $quoteitems->product->PNRating->name;
                            $dataObj['product'] = $quoteitems->product->Diameter->name;
                            $dataObj['sdr'] = $quoteitems->product->PNRating->sdr;
                            $dataObj['unitprice'] = $quoteitems->unitprice;
                            $dataObj['totalamount'] = $quoteitems->unitprice * $num;
                            $dataObj['date'] = Carbon::now();
                        }else{
                            //Do not do a data fill and skip the rest of loop
                            //if batch does not match criteria
                            continue;
                        }
                    }
                }else{
                    //Do not do a data fill and skip the rest of loop
                    //if batch does not match criteria
                    continue;
                }
            }
            if(!empty($dataObj)){
                $pipeprice = new Pipeprice();
                $pipeprice->fill($dataObj);
                $pipeprice->save();
                //Reset array for next row
                $dataObj = [];
                Flash::success('Item and date has been added to stock count');
            }
        }
    }

    public function onPipeRequest(){
        $quantityObj = array();
        $jobcard = Jobcard::find(Input::get('id'));
        $srns =  Srn::doesntHave('srnapprove', 'or', function ($query){
            $query->where('status_id', 1);
        })->orderBy('id', 'desc')->get();
        $this->vars['original_quote'] = $jobcard->pipe->quoteitems->quote->id . ' | ' . $jobcard->pipe->quoteitems->quote->company_name  ;
        $this->vars['myrep'] = $jobcard->pipe->quoteitems->quote->user->name . ' '. $jobcard->pipe->quoteitems->quote->user->surname;
        $this->vars['original_quote_item'] = $jobcard->pipe->quoteitems->id . ' | ' .  $jobcard->pipe->quoteitems->description ;
        $yard = $jobcard->pipe->getTotalProduced() - $jobcard->pipe->getTotalDelivered();
        if($yard < 1){
            $this->vars['quantity'] = array('0');
        }else{
            $this->vars['quantity'] = range(1, $yard);
        }

        $this->vars['srns'] = $srns;

        return [
            '#piperequest' => $this->makePartial('piperequest')
        ];
    }
    public function onAdd()
    {
        $from_quote  = (int) filter_var(Input::get('from_quote'), FILTER_SANITIZE_NUMBER_INT);
        $string_start = explode("|",Input::get('item'));
        $item = (int) filter_var($string_start[0], FILTER_SANITIZE_NUMBER_INT);

        $dest_quote = (int) filter_var(Input::get('to_srn'), FILTER_SANITIZE_NUMBER_INT);
        $mysrn = Srn::find($dest_quote);
        $user = \BackendAuth::getUser();
        if(empty($mysrn->srnapprove) || $mysrn->srnapprove->status_id == 0){
            $pipe = Quoteitems::find($item)->pipe;

                $srn_item = new SrnItem();
                $srn_item->pipe_id = $pipe->id;
                $srn_item->srn_id = $dest_quote;
                $srn_item->units = Input::get('quantity');
                $srn_item->createdby = $user->id;
                $srn_item->quoteitem_id = $pipe->quoteitem_id;
                $srn_item->save();
                $newsales = Input::get('myrep');
                $fullname = $mysrn->quote->user->name . " ". $mysrn->quote->user->surname;
                $yard = $pipe->getTotalProduced() - $pipe->getTotalDelivered();
                if($yard < 1)
                    $yard = 0;
                if($newsales !== $fullname){
                    $data = [
                        'salesperson' => $pipe->qpush->quote->user->name. ' '.$pipe->qpush->quote->user->surname,
                        'pipe' => $pipe->quoteitems->description,
                        'from_client' => $pipe->qpush->quote->company_name,
                        'from_quote' => $pipe->qpush->quote->id,
                        'quantity' => Input::get('quantity'),
                        'yard' => $yard,
                        'email_to' =>  $pipe->qpush->quote->user->email,
                        'to_quote' =>  $mysrn->quote->id,
                        'to_client' =>  $mysrn->quote->company_name,
                    ];
                    \Mail::send('bt.sales.pipemove.notify', $data, function($message) use ($data) {
                        $message->to($data['email_to']);
                        $message->subject("Pipes Have Been Moved: ");
                    });

                    \Flash::success($pipe->qpush->quote->user->name . ' is the original rep. Therefore, an email has been sent to them about the move.');
                }
                \DB::table('tbl_association')->insert(
                    [
                        'tbl_association__id' => $mysrn->quote->id,
                        'association__id' => $pipe->id,
                        'tbl_association_type' => 'Bt\Sales\Models\Newquote',
                        'association__record_active' => 1
                    ]
                );
                \Flash::success('Item Associate '.Input::get('item'));
                $this->onSearch();
        }
    }

    public function onFixYard(){

        $jobcard = Jobcard::find(Input::get('id'));
        $this->vars['pipe_id'] = $jobcard->pipe->id;
        $this->vars['pipe_name'] = $jobcard->pipe->quoteitems->description;
        $this->vars['amount'] = $jobcard->pipe->getTotalProduced() - $jobcard->pipe->getTotalDelivered();
        return [
            '#fixyard' => $this->makePartial('fixyard')
        ];
    }

    public function onUpdateFix(){
        $pipe = Pipe::find(Input::get('pipe_id'));

        $yard = $pipe->getTotalProduced() - $pipe->getTotalDelivered();
        $user = \BackendAuth::getUser();
        $countdays = $pipe->schedules->count();

        if(Input::get('amount') < $yard){
            $schedule = new ScheduleModel();
            $schedule->pipe_id = $pipe->id;
            $schedule->user_id = $user->id;
            $schedule->is_stock = 1;
            $schedule->total_units_produced = $yard - $yard + (Input::get('amount') - $yard);
            $schedule->total_units_passed_qc = $yard - $yard + (Input::get('amount') - $yard);
            $schedule->production_days = $countdays + 1;
            $schedule->production_date = Carbon::now();
            $schedule->save();
            Flash::success('Amended the Pipe quantity (Substracted)');
        }elseif (Input::get('amount') >= $yard){
            $schedule = new ScheduleModel();
            $schedule->pipe_id = $pipe->id;
            $schedule->user_id = $user->id;
            $schedule->is_stock = 1;
            $schedule->total_units_produced = (Input::get('amount') - $yard) ;
            $schedule->total_units_passed_qc = (Input::get('amount') - $yard) ;
            $schedule->production_days = $countdays + 1;
            $schedule->production_date = Carbon::now();
            $schedule->save();
            Flash::success('Amended the Pipe quantity (Added)');
        }



    }

    public function onOverrun(){
        $btaccount = BtAccount::where('pipe_id', Input::get('id'))->first();
        $srns =  Srn::doesntHave('srnapprove', 'or', function ($query){
            $query->where('status_id', 1);
        })->orderBy('id', 'desc')->get();
        $this->vars['original_quote'] = $btaccount->quote_id . ' | ' . $btaccount->quote->company_name  ;
        $this->vars['myrep'] = $btaccount->pipe->quoteitems->quote->user->name . ' '. $btaccount->pipe->quoteitems->quote->user->surname;
        $this->vars['original_quote_item'] = $btaccount->id . ' | ' .  $btaccount->description ;
        $yard = $btaccount->pipe->getTotalProduced() - $btaccount->pipe->getTotalDelivered();
        if($yard < 1){
            $this->vars['quantity'] = array('0');
        }else{
            $this->vars['quantity'] = range(1, $yard);
        }

        $this->vars['srns'] = $srns;

        return [
            '#overrun' => $this->makePartial('overrun')
        ];
    }
    public function onSaveOverrun(){
        $from_quote  = (int) filter_var(Input::get('from_quote'), FILTER_SANITIZE_NUMBER_INT);
        $string_start = explode("|",Input::get('item'));
        $item = (int) filter_var($string_start[0], FILTER_SANITIZE_NUMBER_INT);
        $dest_quote = (int) filter_var(Input::get('to_srn'), FILTER_SANITIZE_NUMBER_INT);
        $mysrn = Srn::find($dest_quote);
        $user = \BackendAuth::getUser();
        if(empty($mysrn->srnapprove) || $mysrn->srnapprove->status_id == 0){
            $pipe = BtAccount::find($item)->pipe;
            $srn_item = new SrnItem();
            $srn_item->pipe_id = $pipe->id;
            $srn_item->srn_id = $dest_quote;
            $srn_item->units = Input::get('quantity');
            $srn_item->createdby = $user->id;
            $srn_item->quoteitem_id = $pipe->quoteitem_id;
            $srn_item->save();
            $newsales = Input::get('myrep');
            $fullname = $mysrn->quote->user->name . " ". $mysrn->quote->user->surname;
            $yard = $pipe->getTotalProduced() - $pipe->getTotalDelivered();
            if($yard < 1)
                $yard = 0;
            if($newsales !== $fullname){
                $data = [
                    'salesperson' => $pipe->qpush->quote->user->name. ' '.$pipe->qpush->quote->user->surname,
                    'pipe' => $pipe->quoteitems->description,
                    'from_client' => $pipe->qpush->quote->company_name,
                    'from_quote' => $pipe->qpush->quote->id,
                    'quantity' => Input::get('quantity'),
                    'yard' => $yard,
                    'email_to' =>  $pipe->qpush->quote->user->email,
                    'to_quote' =>  $mysrn->quote->id,
                    'to_client' =>  $mysrn->quote->company_name,
                ];
                \Mail::send('bt.sales.pipemove.notify', $data, function($message) use ($data) {
                    $message->to($data['email_to']);
                    $message->subject("Pipes Have Been Moved: ");
                });

                \Flash::success($pipe->qpush->quote->user->name . ' is the original rep. Therefore, an email has been sent to them about the move.');
            }
            \DB::table('tbl_association')->insert(
                [
                    'tbl_association__id' => $mysrn->quote->id,
                    'association__id' => $pipe->id,
                    'tbl_association_type' => 'Bt\Sales\Models\Newquote',
                    'association__record_active' => 1
                ]
            );
            \Flash::success('Item Associate '.Input::get('item'));
            $this->onSearch();
        }
    }
}
