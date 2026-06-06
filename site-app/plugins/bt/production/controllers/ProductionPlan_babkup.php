<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Sales\Models\Quoteitems;
use Carbon\Carbon;
use Bt\Production\Models\ProductionPlan as ProductionPlanModel;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Sales\Models\SrnItem as SRNModel;

use Bt\Sales\Models\Srn;
use Bt\Sales\Models\SrnCatalogue;
use Bt\Sales\Models\PaymentTracker;

use Bt\Sales\Models\Invoice as InvoiceModel;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceivingModel;
use Bt\Inventory\Models\StockRelease;

use Bt\Production\Models\Push as PushModel;

use Bt\Production\Models\Schedule as ScheduleModel;
use Bt\Production\Models\MaterialUsed as MaterialUsedModel;
Use DB;

use Bt\Sales\Models\Client;
use Input;

/**
 * Production Plan Back-end Controller
 */
class ProductionPlan extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
   public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];


    public $relationConfig = 'config_relation.yaml';

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Production', 'production', 'productionplan');
        BackendMenu::setContext('Bt.Production', 'production', 'createplan');

    }

    public function getTotalDelivered() {
        $pipes = PipeModel::all();
        $total = 0;

        return $pipes;
    }

     public function onRemove($id = null)
    {
        $obj = Quoteitems::find(Input::get('id'));
        $obj->isbackorder = 0;
        $obj->save();


        \Flash::success('Item Removed '.Input::get('id'));
        return \Backend::redirect('bt/production/productionplan/backorders');
        // return \Backend::redirect();
    }

    public  function backorders(){
        $this->pageTitle = "Back Order";
        BackendMenu::setContext('Bt.Production', 'production', 'backorders');
        $objClient = Client::where('id',"!=", 3)->whereHas('quotes', function ($query) {
                        $query->where('active', 1);
                        $query->whereHas('items', function ($query) {
                                     $query->where('isbackorder',1);
                            });
                        $query->whereHas('qpush', function ($query) {
                            $current = Carbon::now();
                            $startdate = $current->addDays(-30);
                            // $query->where('created_at','>', $startdate);
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
        ##CLEAN DATA
        ##IF 100% DELIVERED THEN REMOVE
        foreach ($objClient as $ckey => &$client) {
            foreach ($client->quotes as $qkey => &$quote) {
                $count = 0;
                foreach($quote->items as $key=>&$value){
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
        $this->vars['list'] = $objClient;

    }

    public function home(){

        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");


        $this->pageTitle = "Production Plan";
        BackendMenu::setContext('Bt.Production', 'production', 'displayplans');


        $current = Carbon::now();
        $enddate =  $current->addDays(7);
        $current = Carbon::now();
        $startdate = $current->addDays(-1);
        $data = array('startdate' => $startdate, 'enddate' => $enddate);
        #whereBetween('enddate', array($data['startdate'], $data['enddate']." 23:59:00"))
         $this->vars['list'] = ProductionPlanModel::
         where('enddate','>=', Carbon::now())
         ->orderBy('startdate', 'asc')
         ->get();

        $material = RawMaterialReceivingModel::all();
        $totalweight = 0;
        foreach ($material as $key => $value) {
            # code...
            $totalweight += $value->weight - $value->release->sum("kg");
        }
        #$released = StockRelease::all();
        #$totalweight =  $material->sum("weight") -  $released->sum("kg");
        $this->vars['incage'] = $totalweight;


        $events = array();

         $obj = ProductionPlanModel::where('enddate','>=', Carbon::now())->orderBy('startdate', 'asc')
         ->get();
        foreach ($obj as $key => $value) {
            $color = '#4497e0';

            $countkg = 0;



            foreach($value->planitems as $val){
                $desc = $val->quote->company_name." / QTY ".$value->qty." / ".($val->qty * $val->item->weight)."  kg";

                $events[] =  array('title' => $desc, 'start'=> $value->startdate,'end'=> $value->enddate,'color'=>$color );

                $countkg += ($val->qty * $val->item->weight);


            }
               $desc = $value->size." mm / ".$value->btline->name." / Total $countkg" ;

            $events[] =  array('title' => $desc, 'start'=> $value->startdate,'end'=> $value->enddate,'color'=>$color );




        }

        $this->vars['events'] = $events;

    }

    public  function weeklyrunsreport(){
      
        $this->pageTitle = "Weekly Report";
        BackendMenu::setContext('Bt.Production', 'production', 'weeklyrunsreport');

        $enddate = Carbon::now();
        $current = Carbon::now();
        $startdate = "2020/01/01";
        $monster = array();
        
        $this->getBailaData($startdate, $enddate,$monster,3);
      
         $this->getWeeklyMaterial($startdate, $enddate,$monster);


         $this->getWeeklyDelivery($startdate, $enddate,$monster); 
         $this->getWeeklyDeliveryStock($startdate, $enddate,$monster); 
         $this->getPaymentTracker($startdate, $enddate,$monster);
         $this->getRawMaterialReceiving($startdate, $enddate,$monster);
         

        $w =  ScheduleModel::select(
            DB::raw("sum(target_kg_processed) as target_kg_processed"),
            DB::raw("sum(total_kg_processed) as total_kg_processed"),
            DB::raw("sum(weight_scrap_kg) as weight_scrap_kg"),
            DB::raw("sum(over_weight_kg) as over_weight_kg"),
            DB::raw("sum(target_units_produced) as target_units_produced"),
            DB::raw("sum(total_units_produced) as total_units_produced"),
            DB::raw("sum(total_units_passed_qc) as total_units_passed_qc"),

            DB::raw("week(production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Monday'), '%x %v %W')  as outyear"))
        ->whereBetween('production_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
        ->orderBy("outyear",'desc')
        ->orderBy("outweek",'desc')
        ->get();

        // STR_TO_DATE(
        //     CONCAT(
        //         DATE_FORMAT(production_date,'%Y')
        //         ,' ',
        //         week(production_date,1)
        //         ,' Sunday')
        //     , '%x %v %W')

        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outyear;
            $monster[$k]["target_kg_processed"] =  $value->target_kg_processed;
            $monster[$k]["total_kg_processed"] =  $value->total_kg_processed;
            $monster[$k]["total_kg_processed_avg"] =  ((int)$value->total_kg_processed)/7;
            $monster[$k]["weight_scrap_kg"] =  (int)$value->weight_scrap_kg;
            $monster[$k]["over_weight_kg"] =  (int)$value->over_weight_kg;

            $monster[$k]["target_units_produced"] =  (int)$value->target_units_produced;
            $monster[$k]["total_units_produced"] =  (int)$value->total_units_produced;
            $monster[$k]["total_units_produced_avg"] =  ((int)$value->total_units_passed_qc)/7;
            $monster[$k]["fail_pipe"] =  (int)$value->total_units_produced - (int)$value->total_units_passed_qc;
            $monster[$k]["invoicedamount"] = 0;
            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;

            $date_ = Carbon::parse($value->outyear.' 00:00:00'); 
            $monster[$k]["month"] = $date_->format("F");
            $monster[$k]["year"] = $date_->year;
         }





        $w_invoice = InvoiceModel::select(
            DB::raw("sum(amount) as invoicedamount"),
           
            
            DB::raw("week(invoice_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(invoice_date,'%Y'),' ',week(invoice_date,1),' Monday'), '%x %v %W')  as outyear"))
        ->whereBetween('invoice_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
        ->orderBy("outyear",'desc')
        ->orderBy("outweek",'desc')
        ->get();

        foreach ($w_invoice as $key => $value) {
            $k =  $value->outweek.$value->outyear;
            $monster[$k]["invoicedamount"] =  $value->invoicedamount;
            
            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
         }


            $this->vars['monster'] = $monster;

            $this->vars['graph'] =  $this->getWeeklyProductionGraph($startdate, $enddate);



    }

      private function getWeeklyMaterial($startdate, $enddate,&$monster){

       $w =  MaterialUsedModel::select(
            DB::raw("sum(bt_production_material_useds.kg) as kg"),
            DB::raw("week(bt_production_schedules.production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_production_schedules.production_date,'%Y'),' ',week(bt_production_schedules.production_date,1),' Monday'), '%x %v %W')  as outyear"))
       ->join('bt_production_schedules', 'bt_production_schedules.id', '=', 'bt_production_material_useds.schedule_id')
        ->whereBetween('bt_production_schedules.production_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
         ->orderBy("outyear",'desc')
        ->orderBy("outweek",'desc')
        ->get();

        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outyear;
            $monster[$k]["used_kg"] =  $value->kg;
            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
         }



    }


    private function getRawMaterialReceiving($startdate, $enddate,&$monster){

       $w =    RawMaterialReceivingModel::select(
            DB::raw("sum(pricekg*weight) as amounttotal"),
            DB::raw("sum(weight) as weighttotal"),
            DB::raw("week(date_of_receipt,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(date_of_receipt,'%Y'),' ',week(date_of_receipt,1),' Monday'), '%x %v %W')  as outyear"))
       
        ->whereBetween('date_of_receipt', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
         ->orderBy("outyear",'desc')
        ->orderBy("outweek",'desc')
        ->get();

        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outyear;
            $monster[$k]["materialreceivetotalkg"] =  $value->weighttotal;
            $monster[$k]["materialreceivetotalprice"] =  $value->amounttotal;
            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
         }



    }

    private function getPaymentTracker($startdate, $enddate,&$monster){

           $w =  PaymentTracker::select(
                DB::raw("sum(amount) as amounttotal"),
                DB::raw("week(payment_date,1) as outweek"),
                DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(payment_date,'%Y'),' ',week(payment_date,1),' Monday'), '%x %v %W')  as outyear"))
           
            ->whereBetween('payment_date', array($startdate, $enddate." 23:59:00"))
            ->groupBy("outweek","outyear")
             ->orderBy("outyear",'desc')
            ->orderBy("outweek",'desc')
            ->get();

            foreach ($w as $key => $value) {
                $k =  $value->outweek.$value->outyear;
                $monster[$k]["paymentamount"] =  $value->amounttotal;
                $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
             }



        }


     private function getWeeklyDelivery($startdate, $enddate,&$monster){

       $i =  SRNModel::whereNull('stockweight')->get();
       foreach ($i as $key => $value) {
           $value->stockweight = $value->pipe->quoteitems->weight * $value->units;
           $value->stockvalue = $value->pipe->quoteitems->unitprice * $value->units;
           $value->save();
       }

        $w =  Srn::select(
            DB::raw("sum(bt_sales_srn_items.stockweight) as kg"),
             DB::raw("sum(bt_sales_srn_items.stockvalue) as amount"),
            DB::raw("week(bt_sales_srns.schedule_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_sales_srns.schedule_date,'%Y'),' ',week(bt_sales_srns.schedule_date,1),' Monday'), '%x %v %W')  as outyear"))
       ->join('bt_sales_srn_items', 'bt_sales_srns.id', '=', 'bt_sales_srn_items.srn_id')
        ->whereBetween('bt_sales_srns.schedule_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
         ->orderBy("outyear",'desc')
        ->orderBy("outweek",'desc')
        ->get();

        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outyear;
            $monster[$k]["stockweight"] =  $value->kg;
             $monster[$k]["stockvalue"] =  $value->amount;

            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
         }

    }


    private function getBailaData($startdate, $enddate,&$monster,$id){

       

        $w =  ScheduleModel::select(
            DB::raw("sum(bt_production_schedules.total_kg_processed) as kg"),
             DB::raw("bt_production_control_sheets.line_id"),
            DB::raw("week(bt_production_schedules.production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_production_schedules.production_date,'%Y'),' ',week(bt_production_schedules.production_date,1),' Monday'), '%x %v %W')  as outyear"))

       ->join('bt_production_control_sheets', 'bt_production_control_sheets.id', '=', 'bt_production_schedules.controlsheet_id')
        ->whereBetween('bt_production_schedules.production_date', array($startdate, $enddate." 23:59:00"))
        
        ->groupBy("outweek","outyear",'line_id')
         ->orderBy("outyear",'desc')
        ->orderBy("outweek",'desc')
        ->get();

        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outyear;
            $monster[$k]["baila_".$value->line_id] =  $value->kg;
            

            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
         }

    }


    private function getWeeklyDeliveryStock($startdate, $enddate,&$monster){
        $i =  SrnCatalogue::whereNull('stockvalue')->get();
        foreach ($i as $key => $value) {
           $value->stockvalue = $value->qoutecat->unitprice * $value->units;
           $value->save();
       }

        $w =  Srn::select(
            
             DB::raw("sum(bt_sales_srn_catalogues.stockvalue) as amount"),
            DB::raw("week(bt_sales_srns.schedule_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_sales_srns.schedule_date,'%Y'),' ',week(bt_sales_srns.schedule_date,1),' Monday'), '%x %v %W')  as outyear"))
       ->join('bt_sales_srn_catalogues', 'bt_sales_srns.id', '=', 'bt_sales_srn_catalogues.srn_id')
        ->whereBetween('bt_sales_srns.schedule_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
         ->orderBy("outyear",'desc')
        ->orderBy("outweek",'desc')
        ->get();

        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outyear;
            
             $monster[$k]["catstockvalue"] =  $value->amount;

            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;

         }

    }

    private function getWeeklyProductionGraph($startdate, $enddate){
       $w =  ScheduleModel::select(
            DB::raw("sum(over_weight_kg) as x"),
            DB::raw("sum(total_kg_processed) as y"),
            DB::raw("sum(weight_scrap_kg) as z"),
            DB::raw("week(production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Monday'), '%x %v %W')  as outyear"))
        //->where("scheduled",1)
       ->whereBetween('production_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
        ->orderBy("outyear")
        ->orderBy("outweek")
        ->get();

        $wasted = array();
        $over_weight_kg = array();
        $total_kg_processed = array();
        $total_kg_processed_avg = array();
        $weight_scrap_kg = array();

        foreach ($w as $key => $value) {
            $wasted[] =  (int)$value->x + (int)$value->z;

            $over_weight_kg[] =  (int)$value->x;
            $total_kg_processed[] =  (int)$value->y;
            $total_kg_processed_avg[] =  ((int)$value->y)/7;
            $weight_scrap_kg[] =  (int)$value->z;
         }



         $monster  =  array();
         $name  =  array();
         foreach ($w as $key => $value) {
             $name[] = "Wk ".$value->outweek."/".$value->outyear;
         }

          $monster[] =  array('name' => 'Total Waste', 'data'=> $wasted );
        $monster[] =  array('name' => 'Over Weight', 'data'=> $over_weight_kg );
        $monster[] =  array('name' => 'Total Processed', 'data'=> $total_kg_processed );
        $monster[] =  array('name' => 'Weight Scrap', 'data'=> $weight_scrap_kg );
        $monster[] =  array('name' => 'Total Processed AVG', 'data'=> $total_kg_processed_avg );
       return  array('name' =>$name, 'data' =>$monster  );;
    }



}
