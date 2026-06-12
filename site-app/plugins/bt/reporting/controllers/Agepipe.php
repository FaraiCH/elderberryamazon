<?php namespace Bt\Reporting\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\BtAccount;
use Bt\Production\Models\ControlSheet;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\SrnItem;
use Carbon\Carbon;
use Bt\Production\Models\ProductionPlan as ProductionPlanModel;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Sales\Models\SrnItem as SRNModel;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Illuminate\Support\Facades\Response;

use Bt\Sales\Models\Srn;
use Bt\Sales\Models\SrnCatalogue;
use Bt\Production\Models\ControlSheet as ControlSheetModel;
use Bt\Production\Models\Jobcard;
use Bt\Production\Models\JobCardBatch;

use Bt\Production\Models\Push as PushModel;

use Bt\Production\Models\Schedule as ScheduleModel;
Use DB;

use Bt\Sales\Models\Client;

/**
 * Agepipe Backend Controller
 */
class Agepipe extends Controller
{


    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Reporting', 'reporting', 'agepipe');
    }

     public function getTotalDelivered() {
        $pipes = PipeModel::all();
        $total = 0;

        return $pipes;
    }

    public function index()
    {
        BackendMenu::setContext('Bt.Reporting', 'reporting', 'agepipe');
        $this->pageTitle = "Age Pipe";

        $this->addCss("/plugins/bt/reporting/assets/css/bootstrap.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/dataTables.bootstrap5.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/responsive.bootstrap5.min.css", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap5.min.js", "1.0.0");
        $this->addJs("/plugins/bt/reporting/assets/js/backlaout.js", "1.0.0");

        $this->addJs("https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js", "1.0.0");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js", "1.0.0");
        $this->addJs("//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js", "1.0.0");

        $newSchedules = array();
        $mycount = 0;
        $btaccount = array();
        $btaccountpipes = BtAccount::all();
        foreach ($btaccountpipes as $bt)
        {
            if (isset($bt->pipe->delivered)){
//                trace_log("Pipe ID ". $bt->pipe->id. " Delivered ". $bt->pipe->delivered->sum("units") . " Diameter ID ". $bt->product->diameter_id. " PN Rating ID". $bt->product->pn_ratings_id);

                $srnitem =  SrnItem::where('pipe_id', $bt->pipe->id)->get();
                if(isset($srnitem))
                {
                    foreach ($srnitem as $item)
                    {
                        $btaccount[$item->pipe->quoteitems->product->diameter_id . " " . $item->pipe->quoteitems->product->pn_ratings_id . " " . $item->srn->quote_id] = $item->units;
                    }
                }



            }
        }

        $objClient = Client::where('id',"!=", 3)->whereHas('quotes', function ($query) {
                        $query->where('active', 1);
                        $query->whereHas('items', function ($query) {
                                     $query->where('isbackorder',1);
                            });
                        $query->whereHas('qpush', function ($query) {
                            $current = Carbon::now();
                            $enddate = Carbon::now();
                            $startdate = $current->addDays(-30);
                            $query->where('status_id','>',1);
                            $query->where('status_id','<',4);
                            $query->whereHas('approved', function ($query) {
                                    $query->where('status_id', 1);
                            });
                            $query->whereHas('pipes', function ($query) {
                                     $query->where('active', 1);
                            });

                        });

                })->orderby("company_name")->get();

        foreach ($objClient as $ckey => &$client) {
            foreach ($client->quotes as $qkey => &$quote) {



                $count = 0;
                foreach($quote->items as $key=>&$value){
//
                    if($value->isbackorder == 1)
                    {
                        if(isset($value->pipe))
                        {


                            $jobcard = Jobcard::where('pipe_id',$value->pipe->id)->first();
                            if(isset($jobcard))
                            {
                                $mybatch = $jobcard->batch->first();
                                if(isset($mybatch))
                                {
                                    $newSchedules[$value->id] = $jobcard->id . " - " . $mybatch->id;
                                }
                                else
                                {
                                    $newSchedules[$value->id] =  'None';
                                }

                            }
                            else{
                                $newSchedules[$value->id] =  'None';
                            }

                        }
                        else
                        {
                            $newSchedules[$value->id] =  "None";
                        }

                    }



                    if(isset($value->product)){


                        if ($value->product->value > 0 && $value->unitlength > 0) {


                            $count = $count + $value->units;
                        }
                            $value["gotbackorder"] = 1;
                        if (isset($value->pipe->delivered)){
                            if($value->pipe->delivered->sum("units") >= $value->units ){
                                    $value["gotbackorder"] = 0;
                            }
                        }

                        if ($value->isbackorder == 0){
                            $value["gotbackorder"] = 0;
                        }
                    }

                }

                $vs = 0;
                foreach($quote->srn as $pkey=>$pvalue){
                    if(isset($pvalue->items))
                        $vs = $vs + $pvalue->items()->sum('units');

                }
                if($count == 0){
                    ##remove items
                }else{
                    if($vs >= $count){
                        unset($quote);

                    }else{
                        $client["gotbackorder"] = 1;
                    }
                }
            }
            # code...
        }







        $this->vars['newSchedules'] = $newSchedules;
        $this->vars['list'] = $objClient;
        $this->vars['btaccount'] = $btaccount;


    }
}
