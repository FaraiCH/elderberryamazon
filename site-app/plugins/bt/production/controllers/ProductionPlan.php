<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Inventory\Models\Purchase;
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
use DB;
use Bt\Inventory\Models\BlendedPurchase;
use Bt\Sales\Models\Client;
use Illuminate\Support\Facades\Redirect;
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
        'Backend.Behaviors.RelationController',
       'Backend.Behaviors.ImportExportController',
    ];


    public $relationConfig = 'config_relation.yaml';

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';
    public $importExportConfig = 'config_export.yaml';
    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Production', 'production', 'productionplan');
        BackendMenu::setContext('Bt.Production', 'production', 'createplan');
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        if (\Input::has('enddate')) {
            $enddate = \Input::get('enddate');
        } else {
            $enddate = date('Y-m-d');
        }
        if (\Input::has('startdate')) {
            $startdate = \Input::get('startdate');
        } else {
            $startdate = date('Y-m-d', strtotime(date('Y-m-d') . ' - ' . 13 . ' days'));
        }
        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;
    }

    public function getTotalDelivered()
    {
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

    public function backorders()
    {
        $this->pageTitle = "Back Order";
        BackendMenu::setContext('Bt.Production', 'production', 'backorders');
        $objClient = Client::where('id', "!=", 3)->
                with(['quotes'=> function ($query) {
                        $query->where('active', 1);
                        $query->where('ponumber', "<>", "")->whereNotnull('ponumber');
                        $current = Carbon::now();
                        $startdate = $current->addDays(-80);
                        $query->where('created_at', '>', $startdate);
                        $query->where('active', 1);

                        $query->with(
                            ['items'=> function ($query) {
                                     $query->where('isbackorder', 1);
                            },
                            'qpush'=> function ($query) {
                                $current = Carbon::now();
                                $startdate = $current->addDays(-90);
                                $query->where('created_at', '>', $startdate);
                                $query->where('status_id', '>', 1);
                                $query->where('status_id', '<', 4);
                                $query->whereHas('approved', function ($query) {
                                        $query->where('status_id', 1);
                                });
                                $query->whereHas('pipes', function ($query) {
                                         $query->where('active', 1);
                                });
                            }
                            ]
                        );
                }])->orderby("company_name")->get();
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
                    if (isset($pvalue->items)) {
                        $vs = $vs + $pvalue->items()->sum('units');
                    }
                }
                if ($count == 0) {
                    ##remove items
                } else {
                    if ($vs >= $count) {
                        unset($quote);
                    } else {
                        $client["gotbackorder"] = 1;
                    }
                }
            }
            # code...
        }
        $this->vars['list'] = $objClient;
    }

    public function home()
    {

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
         where('enddate', '>=', Carbon::now())
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

         $obj = ProductionPlanModel::where('enddate', '>=', Carbon::now())->orderBy('startdate', 'asc')
         ->get();
        foreach ($obj as $key => $value) {
            $color = '#4497e0';

            $countkg = 0;



            foreach ($value->planitems as $val) {
                $desc = $val->quote->company_name." / QTY ".$value->qty." / ".($val->qty * $val->item->weight)."  kg";

                $events[] =  array('title' => $desc, 'start'=> $value->startdate,'end'=> $value->enddate,'color'=>$color );

                $countkg += ($val->qty * $val->item->weight);
            }
               $desc = $value->size." mm / ".$value->btline->name." / Total $countkg" ;

            $events[] =  array('title' => $desc, 'start'=> $value->startdate,'end'=> $value->enddate,'color'=>$color );
        }

        $this->vars['events'] = $events;
    }

    public function weeklyrunsreport()
    {

        $this->pageTitle = "Weekly Report";
        BackendMenu::setContext('Bt.Production', 'production', 'weeklyrunsreport');
        $this->vars['all_clients'] = Client::all();
        $pick_company = Input::get('pick_company');
        $enddate = Carbon::now();
        $current = Carbon::now();
        $startdate = "2021/01/01";
        $company = null;
        $monster = array();
        if (!empty($pick_company) && $pick_company != "All Clients") {
            $company = $pick_company;
        }
        $this->getBailaData($startdate, $enddate, $monster, 3, $company);
        $this->getWeeklyMaterial($startdate, $enddate, $monster, $company);
        $this->getWeeklyDelivery($startdate, $enddate, $monster, $company);
        $this->getWeeklyDeliveryStock($startdate, $enddate, $monster, $company);
        $this->getPaymentTracker($startdate, $enddate, $monster, $company);
        $this->getRawMaterialReceiving($startdate, $enddate, $monster, $company);


        $w =  ScheduleModel::select(
            DB::raw("sum(target_kg_processed) as target_kg_processed"),
            DB::raw("sum(total_kg_processed) as total_kg_processed"),
            DB::raw("sum(weight_scrap_kg) as weight_scrap_kg"),
            DB::raw("sum(over_weight_kg) as over_weight_kg"),
            DB::raw("sum(target_units_produced) as target_units_produced"),
            DB::raw("sum(total_units_produced) as total_units_produced"),
            DB::raw("sum(total_units_passed_qc) as total_units_passed_qc"),
            DB::raw("week(production_date,1) as outweek"),
            DB::raw("month(production_date) as outmonth"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Monday'), '%x %v %W')  as outyear")
        )
        ->whereBetween('production_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek", "outyear", "outmonth")
        ->orderBy("outyear", 'desc')
        ->orderBy("outweek", 'desc');

        if (!empty($pick_company) && $pick_company != "All Clients") {
            $this->vars['chosen_company'] = $pick_company;
            $w = $w->whereHas('pipe', function ($newQ) use ($pick_company) {
                $newQ->whereHas('quoteitems', function ($query) use ($pick_company) {
                    $query->whereHas('quote', function ($q) use ($pick_company) {
                        $q->whereHas('client', function ($que) use ($pick_company) {
                            $que->where('id', $pick_company);
                        });
                    });
                });
            })->get();
        } else {
            $w = $w->get();
            $this->vars['chosen_company'] = 0;
        }


        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outmonth.$value->outyear;
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
            $monster[$k]["month"] = $this->getMonth($value->outmonth);

            $monster[$k]["year"] = $date_->year;
        }

        $w_invoice = InvoiceModel::select(
            DB::raw("sum(amount) as invoicedamount"),
            DB::raw("month(bt_sales_srns.schedule_date) as outmonth"),
            DB::raw("week(bt_sales_srns.schedule_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_sales_srns.schedule_date,'%Y'),' ',week(bt_sales_srns.schedule_date,1),' Monday'), '%x %v %W')  as outyear")
        )

        ->join('bt_sales_srns', 'bt_sales_srns.id', '=', 'bt_sales_invoices.srn_id')

        ->whereBetween('bt_sales_srns.schedule_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek", "outyear", "outmonth")
        ->orderBy("outyear", 'desc')
        ->orderBy("outweek", 'desc');

        if (!empty($pick_company) && $pick_company != "All Clients") {
            $w_invoice =  $w_invoice->whereHas('quote', function ($q) use ($pick_company) {
                    $q->whereHas('client', function ($que) use ($pick_company) {
                        $que->where('id', $pick_company);
                    });
            })->get();
        } else {
            $w_invoice = $w_invoice->get();
        }

        foreach ($w_invoice as $key => $value) {
            $k =  $value->outweek.$value->outmonth.$value->outyear;
            $monster[$k]["invoicedamount"] =  $value->invoicedamount;

            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
        }


            $this->vars['monster'] = $monster;

            $this->vars['graph'] =  $this->getWeeklyProductionGraph($startdate, $enddate, $pick_company);
    }

    private function getWeeklyMaterial($startdate, $enddate, &$monster, $company)
    {

        $w =  MaterialUsedModel::select(
            DB::raw("sum(bt_production_material_useds.kg) as kg"),
            DB::raw("month(bt_production_schedules.production_date) as outmonth"),
            DB::raw("week(bt_production_schedules.production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_production_schedules.production_date,'%Y'),' ',week(bt_production_schedules.production_date,1),' Monday'), '%x %v %W')  as outyear")
        )
        ->join('bt_production_schedules', 'bt_production_schedules.id', '=', 'bt_production_material_useds.schedule_id')
        ->whereBetween('bt_production_schedules.production_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek", "outyear", "outmonth")
        ->orderBy("outyear", 'desc')
        ->orderBy("outweek", 'desc');

        if (!empty($company) && $company != "All Clients") {
            $w = $w->whereHas('scheduleday', function ($first) use ($company) {
                $first->whereHas('pipe', function ($newQ) use ($company) {
                    $newQ->whereHas('quoteitems', function ($query) use ($company) {
                        $query->whereHas('quote', function ($q) use ($company) {
                            $q->whereHas('client', function ($que) use ($company) {
                                $que->where('id', $company);
                            });
                        });
                    });
                });
            })->get();
        } else {
            $w = $w->get();
        }
        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outmonth.$value->outyear;
            $monster[$k]["used_kg"] =  $value->kg;
            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
        }
    }


    private function getRawMaterialReceiving($startdate, $enddate, &$monster, $company)
    {

        $w =    RawMaterialReceivingModel::select(
            DB::raw("sum(pricekg*weight) as amounttotal"),
            DB::raw("sum(weight) as weighttotal"),
            DB::raw("week(date_of_receipt,1) as outweek"),
            DB::raw("month(date_of_receipt) as outmonth"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(date_of_receipt,'%Y'),' ',week(date_of_receipt,1),' Monday'), '%x %v %W')  as outyear")
        )

        ->whereBetween('date_of_receipt', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek", "outyear", "outmonth")
         ->orderBy("outyear", 'desc')
        ->orderBy("outweek", 'desc');

        if (!empty($company) && $company != "All Clients") {
            $w = $w->whereHas('used', function ($used) use ($company) {
                $used->whereHas('scheduleday', function ($first) use ($company) {
                    $first->whereHas('pipe', function ($newQ) use ($company) {
                        $newQ->whereHas('quoteitems', function ($query) use ($company) {
                            $query->whereHas('quote', function ($q) use ($company) {
                                $q->whereHas('client', function ($que) use ($company) {
                                    $que->where('id', $company);
                                });
                            });
                        });
                    });
                });
            })->get();
        } else {
            $w = $w->get();
        }
        foreach ($w as $key => $value) {
              $k =  $value->outweek.$value->outmonth.$value->outyear;
            $monster[$k]["materialreceivetotalkg"] =  $value->weighttotal;
            $monster[$k]["materialreceivetotalprice"] =  $value->amounttotal;
            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
        }
    }

    private function getPaymentTracker($startdate, $enddate, &$monster, $company)
    {

           $w =  PaymentTracker::select(
               DB::raw("sum(amount) as amounttotal"),
               DB::raw("week(payment_date,1) as outweek"),
               DB::raw("month(payment_date) as outmonth"),
               DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(payment_date,'%Y'),' ',week(payment_date,1),' Monday'), '%x %v %W')  as outyear")
           )

            ->whereBetween('payment_date', array($startdate, $enddate." 23:59:00"))
            ->groupBy("outweek", "outyear", "outmonth")
             ->orderBy("outyear", 'desc')
            ->orderBy("outweek", 'desc');

        if (!empty($company) && $company != "All Clients") {
            $w = $w->whereHas('quote', function ($q) use ($company) {
                    $q->whereHas('client', function ($que) use ($company) {
                        $que->where('id', $company);
                    });
            })->get();
        } else {
            $w = $w->get();
        }
        foreach ($w as $key => $value) {
             $k =  $value->outweek.$value->outmonth.$value->outyear;
            $monster[$k]["paymentamount"] =  $value->amounttotal;
            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
        }
    }


    private function getWeeklyDelivery($startdate, $enddate, &$monster, $company)
    {

        $i =  SRNModel::whereNull('stockweight')->get();

        foreach ($i as $key => $value) {
            if (!empty($value->pipe->quoteitems)) {
                $value->stockweight = $value->pipe->quoteitems->weight * $value->units;
                $value->stockvalue = $value->pipe->quoteitems->unitprice * $value->units;

                if ($value->stockvalue == 0) {
                    ##GET BT ACOUNT  PRODUCT ID
                    $bt_acc_productid= $value->pipe->quoteitems->product_id;

                    ##SRN BELONGS TO QUOTE
                    #looking for unitprice
                    $unitprice = 0;
                    foreach ($value->srn->quote->items as $qi_key => $qitems) {
                        if ($bt_acc_productid == $qitems->product_id) {
                            $unitprice = $qitems->unitprice;
                        }
                        // code...
                    }

                    if ($unitprice > 0) {
                        $value->stockvalue = $unitprice* $value->units;
                    }
                }
                $value->save();
            }
        }

        $w =  Srn::select(
            DB::raw("sum(bt_sales_srn_items.stockweight) as kg"),
            DB::raw("sum(bt_sales_srn_items.stockvalue) as amount"),
            DB::raw("week(bt_sales_srns.schedule_date,1) as outweek"),
            DB::raw("month(bt_sales_srns.schedule_date) as outmonth"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_sales_srns.schedule_date,'%Y'),' ',week(bt_sales_srns.schedule_date,1),' Monday'), '%x %v %W')  as outyear")
        )
        ->join('bt_sales_srn_items', 'bt_sales_srns.id', '=', 'bt_sales_srn_items.srn_id')
        ->where('bt_sales_srns.fabrication', '<', 1)
        ->whereBetween('bt_sales_srns.schedule_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek", "outyear", "outmonth")
        ->orderBy("outyear", 'desc')
        ->orderBy("outweek", 'desc');
        if (!empty($company) && $company != "All Clients") {
            $w = $w->whereHas('quote', function ($q) use ($company) {
                $q->whereHas('client', function ($que) use ($company) {
                    $que->where('id', $company);
                });
            })->get();
        } else {
            $w = $w->get();
        }
        foreach ($w as $key => $value) {
             $k =  $value->outweek.$value->outmonth.$value->outyear;
            $monster[$k]["stockweight"] =  $value->kg;
             $monster[$k]["stockvalue"] =  $value->amount;

            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
        }
    }


    private function getBailaData($startdate, $enddate, &$monster, $id, $company)
    {

        $w =  ScheduleModel::select(
            DB::raw("sum(bt_production_schedules.total_kg_processed) as kg"),
            DB::raw("bt_production_control_sheets.line_id"),
            DB::raw("month(bt_production_schedules.production_date) as outmonth"),
            DB::raw("week(bt_production_schedules.production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_production_schedules.production_date,'%Y'),' ',week(bt_production_schedules.production_date,1),' Monday'), '%x %v %W')  as outyear")
        )

        ->join('bt_production_control_sheets', 'bt_production_control_sheets.id', '=', 'bt_production_schedules.controlsheet_id')
        ->whereBetween('bt_production_schedules.production_date', array($startdate, $enddate." 23:59:00"))

        ->groupBy("outweek", "outyear", "outmonth", 'line_id')
         ->orderBy("outyear", 'desc')
        ->orderBy("outweek", 'desc');
        if (!empty($company) && $company != "All Clients") {
            $w = $w->whereHas('pipe', function ($newQ) use ($company) {
                    $newQ->whereHas('quoteitems', function ($query) use ($company) {
                        $query->whereHas('quote', function ($q) use ($company) {
                            $q->whereHas('client', function ($que) use ($company) {
                                $que->where('id', $company);
                            });
                        });
                    });
            })->get();
        } else {
            $w = $w->get();
        }

        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outmonth.$value->outyear;
            $monster[$k]["baila_".$value->line_id] =  $value->kg;


            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
        }
    }


    private function getWeeklyDeliveryStock($startdate, $enddate, &$monster, $company)
    {
        $i =  SrnCatalogue::whereNull('stockvalue')->get();
        foreach ($i as $key => $value) {
            $value->stockvalue = $value->qoutecat->unitprice * $value->units;
            $value->stockweight = $value->qoutecat->weight * $value->units;
            $value->save();
        }

        $w =  Srn::select(
            DB::raw("sum(bt_sales_srn_catalogues.stockvalue) as amount"),
            DB::raw("sum(bt_sales_srn_catalogues.stockweight) as kg"),
            DB::raw("week(bt_sales_srns.schedule_date,1) as outweek"),
            DB::raw("month(bt_sales_srns.schedule_date) as outmonth"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_sales_srns.schedule_date,'%Y'),' ',week(bt_sales_srns.schedule_date,1),' Monday'), '%x %v %W')  as outyear")
        )
        ->join('bt_sales_srn_catalogues', 'bt_sales_srns.id', '=', 'bt_sales_srn_catalogues.srn_id')
        ->whereBetween('bt_sales_srns.schedule_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek", "outyear", "outmonth")
         ->orderBy("outyear", 'desc')
        ->orderBy("outweek", 'desc');
        if (!empty($company) && $company != "All Clients") {
            $w = $w->whereHas('quote', function ($q) use ($company) {
                $q->whereHas('client', function ($que) use ($company) {
                    $que->where('id', $company);
                });
            })->get();
        } else {
            $w = $w->get();
        }
        foreach ($w as $key => $value) {
            $k =  $value->outweek.$value->outmonth.$value->outyear;

             $monster[$k]["catstockvalue"] =  $value->amount;
             $monster[$k]["catstockweight"] =  $value->kg;

            $monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
        }
    }

    private function getWeeklyProductionGraph($startdate, $enddate, $company)
    {
        $w =  ScheduleModel::select(
            DB::raw("sum(over_weight_kg) as x"),
            DB::raw("sum(total_kg_processed) as y"),
            DB::raw("sum(weight_scrap_kg) as z"),
            DB::raw("week(production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Monday'), '%x %v %W')  as outyear")
        )
        //->where("scheduled",1)
        ->whereBetween('production_date', array($startdate, $enddate." 23:59:00"))
        ->groupBy("outweek", "outyear")
        ->orderBy("outyear")
        ->orderBy("outweek");

        if (!empty($company) && $company != "All Clients") {
            $w = $w->whereHas('pipe', function ($newQ) use ($company) {
                $newQ->whereHas('quoteitems', function ($query) use ($company) {
                    $query->whereHas('quote', function ($q) use ($company) {
                        $q->whereHas('client', function ($que) use ($company) {
                            $que->where('id', $company);
                        });
                    });
                });
            })->get();
        } else {
            $w = $w->get();
        }

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
        return  array('name' =>$name, 'data' =>$monster  );
        ;
    }

    public function getMonth($m)
    {
        $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
        return $months[$m];
    }


    public function marginanalysis()
    {

        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");

        $this->pageTitle = "Monthly Production Margin Analysis";
        BackendMenu::setContext('Bt.Production', 'production', 'marginanalysis');

        $current = Carbon::now();
        $startdate = $current->startOfMonth();
        $current = Carbon::today();
        $enddate = $current->endOfMonth();

        if (\Input::has('enddate')) {
            $enddate = new Carbon(\Input::get('enddate'));
        }
        if (\Input::has('startdate')) {
            $startdate = new Carbon(\Input::get('startdate'));
        }

        $startdate->hour = 0;
        $startdate->minute  = 0;
        $startdate->second  = 0;
        $enddate->hour = 23;
        $enddate->minute  = 59;
        $enddate->second  = 0;
        $pipe_calculated = array();
        $total_calculated = array();

        $pipe_list = PipeModel::where('id', '>', 0);
        $bp =  BlendedPurchase::where("locked_date", $startdate)->first();

        //Use pipe as subject for query to make sure we get the relevant pipes
        $pipe_list = $pipe_list->whereHas('qpush', function ($query) {
            $query->where('blendedprice_id', '>', 0);
        });
        $pipe_list = $pipe_list->with(['schedules'=> function ($query) use ($startdate, $enddate) {
            $query->whereBetween('production_date', array($startdate, $enddate));
        }
        ]);
        $pipe_list = $pipe_list->whereHas('schedules', function ($query) use ($startdate, $enddate) {
            $query->whereBetween('production_date', array($startdate, $enddate));
        });
        $pipe_list = $pipe_list->get();

        foreach ($pipe_list as $key => $pipeitem) {
            // CREATE PIPE OBJECT TO CALCULATE
            if ($pipeitem->schedules()->sum('total_units_passed_qc') > 0 && !empty($pipeitem->schedules)) {
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['quote'] = $pipeitem->quoteitems->quote->id;
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['client'] = $pipeitem->quoteitems->quote->company_name;
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['user'] = $pipeitem->quoteitems->quote->user->name . ' ' . $pipeitem->quoteitems->quote->user->surname ;
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['date'] = $pipeitem->qpush->date_of_accepted;
                foreach ($pipeitem->schedules as $s => $schedule) {
                    $pipe_calculated[$pipeitem->quoteitems->quote->id]['total_units'] = (isset($pipe_calculated[$pipeitem->quoteitems->quote->id]['total_units'])?$pipe_calculated[$pipeitem->quoteitems->quote->id]['total_units']:0) + $schedule->total_units_passed_qc;
                    $pipe_calculated[$pipeitem->quoteitems->quote->id]['kg_processed'] = (isset($pipe_calculated[$pipeitem->quoteitems->quote->id]['kg_processed'])?$pipe_calculated[$pipeitem->quoteitems->quote->id]['kg_processed']:0) + $schedule->total_kg_processed;
                    $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_scrap_kg'] = (isset($pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_scrap_kg'])?$pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_scrap_kg']:0) + $schedule->weight_scrap_kg;
                    $pipe_calculated[$pipeitem->quoteitems->quote->id]['over_weight_kg'] = (isset($pipe_calculated[$pipeitem->quoteitems->quote->id]['over_weight_kg'])?$pipe_calculated[$pipeitem->quoteitems->quote->id]['over_weight_kg']:0) + $schedule->over_weight_kg;
                }
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_quoted'] = $pipe_calculated[$pipeitem->quoteitems->quote->id]['total_units'] * $pipeitem->quoteitems->product->value;
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_to_process'] = $pipe_calculated[$pipeitem->quoteitems->quote->id]['total_units'] * $pipeitem->quoteitems->product->production_value;
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_advant'] =  $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_quoted'] - $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_to_process'];
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_advant_perc'] = $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_advant']/$pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_to_process'];
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['pricekg'] = (isset($pipe_calculated[$pipeitem->quoteitems->quote->id]['pricekg'])? $pipe_calculated[$pipeitem->quoteitems->quote->id]['pricekg']:0) + ($pipeitem->quoteitems->price/ $pipeitem->quoteitems->totalweight);
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['quote_price']  = (isset($pipe_calculated[$pipeitem->quoteitems->quote->id]['quote_price'])? $pipe_calculated[$pipeitem->quoteitems->quote->id]['quote_price']:0) + $pipeitem->quoteitems->price;
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['price'] = ($pipe_calculated[$pipeitem->quoteitems->quote->id]['kg_processed'] * $pipe_calculated[$pipeitem->quoteitems->quote->id]['pricekg']);
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['kg_price']  = ($pipe_calculated[$pipeitem->quoteitems->quote->id]['kg_processed']*$bp->price);
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['margin'] =  $pipe_calculated[$pipeitem->quoteitems->quote->id]['price'] - $pipe_calculated[$pipeitem->quoteitems->quote->id]['kg_price'];
                if ($pipe_calculated[$pipeitem->quoteitems->quote->id]['price'] != 0) {
                    $pipe_calculated[$pipeitem->quoteitems->quote->id]['planned_margin'] = ($pipe_calculated[$pipeitem->quoteitems->quote->id]['margin'] / $pipe_calculated[$pipeitem->quoteitems->quote->id]['price']) * 100;
                } else {
                    // Handle the division by zero case here, such as assigning a default value or displaying an error message
                    $pipe_calculated[$pipeitem->quoteitems->quote->id]['planned_margin'] = 0;
                }

                $pipe_calculated[$pipeitem->quoteitems->quote->id]['waste'] =  $pipe_calculated[$pipeitem->quoteitems->quote->id]['over_weight_kg'] - $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_scrap_kg'];
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['remove_weight'] = ($pipe_calculated[$pipeitem->quoteitems->quote->id]['over_weight_kg'] + $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_scrap_kg']) - $pipe_calculated[$pipeitem->quoteitems->quote->id]['weight_advant'];
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['net_cost'] = $pipe_calculated[$pipeitem->quoteitems->quote->id]['remove_weight'] * $bp->price;
                $pipe_calculated[$pipeitem->quoteitems->quote->id]['realised_margin'] =  $pipe_calculated[$pipeitem->quoteitems->quote->id]['margin'] - $pipe_calculated[$pipeitem->quoteitems->quote->id]['net_cost'];
                if ($pipe_calculated[$pipeitem->quoteitems->quote->id]['price'] != 0) {
                    $pipe_calculated[$pipeitem->quoteitems->quote->id]['realised_margin_perc'] = $pipe_calculated[$pipeitem->quoteitems->quote->id]['realised_margin'] / $pipe_calculated[$pipeitem->quoteitems->quote->id]['price'];
                } else {
                    $pipe_calculated[$pipeitem->quoteitems->quote->id]['realised_margin_perc'] = 0; // or any other appropriate value when denominator is zero
                };
            }
        }

        foreach ($pipe_calculated as $key => $pipe) {
            //ALL TOTALS
            $total_calculated['total_quote_price']  = (isset($total_calculated['total_quote_price'])?$total_calculated['total_quote_price']:0) + $pipe_calculated[$key]['quote_price'];
            $total_calculated['total_weight_quoted'] = (isset($total_calculated['total_weight_quoted'])?$total_calculated['total_weight_quoted']:0) + $pipe_calculated[$key]['weight_quoted'];
            $total_calculated['total_weight_to_process'] = (isset($total_calculated['total_weight_to_process'])?$total_calculated['total_weight_to_process']:0) + $pipe_calculated[$key]['weight_to_process'];
            $total_calculated['total_weight_advant'] =  (isset($total_calculated['total_weight_advant'])?$total_calculated['total_weight_advant']:0) + $pipe_calculated[$key]['weight_advant'];
            $total_calculated['total_weight_advant_per'] =  (isset($total_calculated['total_weight_advant_per'])?$total_calculated['total_weight_advant_per']:0) +  $pipe_calculated[$key]['weight_advant_perc'];
            $total_calculated['total_kg_processed'] = (isset($total_calculated['total_kg_processed'])?$total_calculated['total_kg_processed']:0) + $pipe_calculated[$key]['kg_processed'];
            $total_calculated['total_price'] = (isset($total_calculated['total_price'])?$total_calculated['total_price']:0) + $pipe_calculated[$key]['price'];
            $total_calculated['total_kg_price']  = (isset($total_calculated['total_kg_price'])?$total_calculated['total_kg_price']:0) + ($pipe_calculated[$key]['kg_processed']*$bp->price);
            $total_calculated['total_margin'] = (isset($total_calculated['total_margin'])?$total_calculated['total_margin']:0) + $pipe_calculated[$key]['margin'];
            $total_calculated['total_planned_margin'] = (isset($total_calculated['total_planned_margin'])?$total_calculated['total_planned_margin']:0) +  $pipe_calculated[$key]['planned_margin'];
            $total_calculated['total_scrap'] = (isset($total_calculated['total_scrap'])?$total_calculated['total_scrap']:0) +  $pipe_calculated[$key]['weight_scrap_kg'];
            $total_calculated['total_overweight'] = (isset($total_calculated['total_overweight'])?$total_calculated['total_overweight']:0) +  $pipe_calculated[$key]['over_weight_kg'];
            $total_calculated['total_waste'] = (isset($total_calculated['total_waste'])?$total_calculated['total_waste']:0) +  $pipe_calculated[$key]['waste'];
            $total_calculated['total_remove_weight'] = (isset($total_calculated['total_remove_weight'])?$total_calculated['total_remove_weight']:0) +  $pipe_calculated[$key]['remove_weight'];
            $total_calculated['total_net_cost'] = (isset($total_calculated['total_net_cost'])?$total_calculated['total_net_cost']:0) +   $pipe_calculated[$key]['net_cost'];
            $total_calculated['total_realised_margin'] = (isset($total_calculated['total_realised_margin'])?$total_calculated['total_realised_margin']:0) + $pipe_calculated[$key]['realised_margin'];
            $total_calculated['total_realised_margin_perc'] = (isset($total_calculated['total_realised_margin_perc'])?$total_calculated['total_realised_margin_perc']:0) + $pipe_calculated[$pipeitem->quoteitems->quote->id]['realised_margin_perc'];
        }

        //Pipe Object increase load speed
        $this->vars['pipe_calculated'] = $pipe_calculated;
        $this->vars['total_calculated'] = $total_calculated;
        $this->vars['enddate'] = $enddate;
        $this->vars['startdate'] = $startdate;
        $this->vars['bp'] = BlendedPurchase::where("locked_date", $startdate)->first();
    }

    public function stockanalysis()
    {
        $this->pageTitle = "Stock Analysis";
        BackendMenu::setContext('Bt.Production', 'production', 'stockanalysis');
        $pipeObj = array();
        $blended_price = BlendedPurchase::all();

        foreach ($blended_price as $blended) {
            $date = new \DateTime($blended->locked_date);
            $carb = $date->format('m');
            $purchase = Purchase::whereDate('date_of_puchase', '>', '2021-12-31 23:59:00')->whereMonth('date_of_puchase', $carb)->get();
            $received = RawMaterialReceivingModel::whereDate('date_of_receipt', '>', '2021-12-31 23:59:00')->whereMonth('date_of_receipt', $carb)->get();
            $srn = Srn::whereDate('schedule_date', '>', '2021-12-31 23:59:00')->whereMonth('schedule_date', $carb)->get();
            $formyear = $date->format('Y');
            $formmonth = $date->format('M');
            $pipeObj[$formmonth. '/' .$formyear]['month'] = $formmonth. '/' .$formyear;
            $pipeObj[$formmonth. '/' .$formyear]['blended'] = $blended->price;
            $pipeObj[$formmonth. '/' .$formyear]['received'] = $received->sum('weight');
            $pipeObj[$formmonth. '/' .$formyear]['purchase'] = $purchase->sum('weight');
            $pipeObj[$formmonth. '/' .$formyear]['purchasevalue'] = $purchase->sum('price');

            foreach ($srn as $s) {
                if ($s->fabrication < 1) {
                    $pipeObj[$formmonth. '/' .$formyear]['srn'] = (isset($pipeObj[$formmonth. '/' .$formyear]['srn'])?$pipeObj[$formmonth. '/' .$formyear]['srn']:0) + $s->items->sum('stockweight');
                }
                $pipeObj[$formmonth. '/' .$formyear]['srnvalue'] = (isset($pipeObj[$formmonth. '/' .$formyear]['srnvalue'])?$pipeObj[$formmonth. '/' .$formyear]['srnvalue']:0) + $s->items->sum('stockvalue');
            }
            $pipeObj[$formmonth. '/' .$formyear]['value_procured'] = $pipeObj[$formmonth. '/' .$formyear]['purchase'] *  $pipeObj[$formmonth. '/' .$formyear]['blended'];
        }

        $this->vars['list'] = $pipeObj;
    }

    public function onMyDate()
    {
        $_SESSION['openstart'] = Input::get('openstart');
        $_SESSION['openend'] = Input::get('openend');
        $type = Input::get('type');
        return Redirect::to('/admin/plan/pdf/'. $type);
    }

    public function onPlanExport()
    {
        $_SESSION['openstart'] = Input::get('openstart');
        $_SESSION['openend'] = Input::get('openend');
        $type = Input::get('type');
        return Redirect::to('/admin/plan/export');
    }
}
