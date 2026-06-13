<?php

use Bt\Sales\Models\Newquote as QuoteModel;
use Bt\Sales\Models\Srn as SrnModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\TripSheet as ModelTrip;
use Bt\Sales\Models\QuoteReponse as QuoteReponse;
use Bt\Sales\Models\DeliveryPlan as DeliverPlanModel;
use Bt\Sales\Models\Srn as ModelSrn;

use Bt\Inventory\Models\Purchase as ModelPurchase;
use Bt\Sales\Models\DiscountItem;
use Bt\Sales\Models\RequestUnapproveSrn;

//use PDF;
use Renatio\DynamicPDF\Classes\PDF;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\Srn;
use Bt\Production\Models\Jobcard;
use Bt\Sales\Models\Newquote;
use Bt\Sales\Models\Fabrication;
use Bt\Sales\Models\StockOrder;
Route::any('rss/all', function(){

    $obj = WallModel::where('active',1)->orderBy('id', 'DESC')->get();
    return Response::view('japps.rssfeed::rss', ['wall' => $obj])->header('Content-Type', 'text/xml');
});

Route::any('/lazyfix', function () {

  $quote = ModelNewquote::all();
  foreach ($quote as $key => $value) {
     $value->fixTotal();
  }
  dd("done");
});

Route::any('/quote/item/download/{id}.pdf', function ($id) {

  $quote = ModelNewquote::find($id);
  if(!empty($quote)){
    $quote->fixTotal();
  }
  $pdf = PDF::loadView('bt.sales::pdfitem',array('quote'=>$quote, 'env' => env('APP_ENV')));
  return $pdf->setPaper('a4')->download("BT-QUOTE-".$id."v".count($quote->responses).'.pdf');

});

Route::any('/quote_discount/item/download/{id}.pdf', function ($id) {

  $quote = ModelNewquote::find($id);
  $disclist = DiscountItem::where("active",1)->orderby("order")->get();
  //dd($disclist);

  if(!empty($quote)){
    $quote->fixTotal();
  }
  $pdf = PDF::loadView('bt.sales::pdfitemdiscount',array('quote'=>$quote,'disclist'=>$disclist, 'env' => env('APP_ENV')));
  return $pdf->setPaper('a4')->stream();
 // return $pdf->setPaper('a4')->download("BT-QUOTE-".$id."v".count($quote->responses).'.pdf');

});

Route::any('/quote/item/downloaddollar/{id}.pdf', function ($id) {

  $quote = ModelNewquote::find($id);
  $dollar = 18.05 ;
    if(!empty($quote)){
        $quote->fixTotal();
    }
  $pdf = PDF::loadView('bt.sales::pdfitem_dollar',array('quote'=>$quote,'dollar'=>$dollar, 'env' => env('APP_ENV')));
  return $pdf->setPaper('a4')->download("BT-QUOTE-".$id."v".count($quote->responses).'.pdf');

});


Route::any('/quote/invoice/download/{id}', function ($id) {

  $quote = ModelNewquote::find($id);
  if(!empty($quote)){
    if($quote->invoice)
    foreach ($quote->invoice as $key => $value) {
      if(!empty($value->file)){
        $a = explode('storage',$value->file->path);
        $file = base_path('/storage'.$a[1]);
        if (file_exists($file)){
          return Response::download($file,'Invoice -'.$value->file->file_name);
        }
    }
    }

 }

});

Route::any('/quote/response/download/{id}/{status}', function ($id,$status) {

  $quote = QuoteReponse::where('quote_id',$id)->where('quote_status_id',$status)->first();
  if(!empty($quote)){
    //return $quote->file;
    if(!empty($quote->file)){
        $a = explode('storage',$quote->file->path);
        $file = base_path('/storage'.$a[1]);
        if (file_exists($file)){
          return Response::download($file,$quote->status->name.'-'.$quote->file->file_name);
        }
    }
 }


});

Route::any('/po/item/download/{id}.pdf', function ($id) {

  $quote = ModelPurchase::find($id);
  $pdf = PDF::loadView('bt.sales::pdfpo',array('quote'=>$quote));
  return $pdf->download("BT-PO-".$id.'.pdf');

});

Route::any('/concession/item/download/{id}.pdf', function ($id) {

  $quote = ModelNewquote::find($id);
  $pdf = PDF::loadView('bt.sales::pdfconcession',array('quote'=>$quote));
  return $pdf->download("BT-Concession-".$id.'.pdf');

});

Route::any('/tripsheet/item/download/{id}.pdf', function ($id) {

  $quote = ModelTrip::find($id);
  $pdf = PDF::loadView('bt.sales::pdftrip',array('quote'=>$quote));
  return $pdf->download("BT-TripSheet-".$id.'.pdf');

});

Route::any('/invoice/item/download/{id}.pdf', function ($id) {

  $quote = ModelNewquote::find($id);
  $pdf = PDF::loadView('bt.sales::pdfinvoice',array('quote'=>$quote));
  return $pdf->download($quote->invoice->name.'.pdf');

});

Route::any('/ccn/item/download/{id}.pdf', function ($id) {

  $quote = ModelSrn::find($id);
  $pdf = PDF::loadView('bt.sales::pdfcn',array('quote'=>$quote));
  return $pdf->download((($quote->prefix_srn)?$quote->prefix_srn:'BT-CCN').sprintf('%04d', $id).'.pdf');

});

Route::any('/srn/item/download/{id}.pdf', function ($id) {

  $quote = ModelSrn::find($id);
  $pdf = PDF::loadView('bt.sales::pdfsrn',array('quote'=>$quote));
  return $pdf->download((($quote->prefix_srn)?$quote->prefix_srn:'BT-SRN').sprintf('%04d', $id).'.pdf');

});

Route::any('/dn/item/download/{id}.pdf', function ($id) {
  $quote = ModelSrn::find($id);
    // return Response::view('bt.sales::pdfdn',array('quote'=>$quote));
  $pdf = PDF::loadView('bt.sales::pdfdn',array('quote'=>$quote, 'env' => env('APP_ENV')));
  return $pdf->download((($quote->prefix_dn)?$quote->prefix_dn:'BT-DN').sprintf('%04d', $id).'.pdf');
});
Route::any('/request_unapproval/item/download/{srn_id}/{id}.pdf', function ($srn_id,$id) {
  $quote = RequestUnapproveSrn::where('id',$id)->where('srn_id',$srn_id)->first();
  $pdf = PDF::loadView('bt.sales::pdfrequest',array('quote'=>$quote->srn,'srnunapprov'=>$quote, 'env' => env('APP_ENV')));
  return $pdf->download((($quote->prefix_request_unapproval)?$quote->prefix_request_unapproval:'BT-Request_Unapproval').sprintf('%04d', $id).'.pdf');
});

Route::any('/report/download/srn/today.pdf', function () {

  $quote = ModelSrn::reporting()->orderBy('schedule_date','desc')->get();
  $pdf = PDF::loadView('bt.sales::pdfsrntoday',array('quote'=>$quote, 'env' => env('APP_ENV')));
  return $pdf->setPaper('a4', 'landscape')->download("BT-SRN.pdf");

});

Route::any('/returnnote/item/download/{id}.pdf', function ($id) {
  $quote = ModelSrn::find($id);
  $pdf = PDF::loadView('bt.sales::pdfreturnnote',array('quote'=>$quote, 'env' => env('APP_ENV')));
  return $pdf->download((($quote->prefix_dn)?$quote->prefix_dn:'BT-RETURNNOTE-').sprintf('%04d', $id).'.pdf');
});

Route::any('/purchase_order/{id}', function ($id){
    $purchase = \Bt\Sales\Models\Purchase::find($id);

    $itemDetails = array();

    foreach ($purchase->purchaseitem as $item)
    {
        $myQuoitems = \Bt\Sales\Models\QuoteItemCatalogue::find($item->item_id);

        $itemDetails['name'][] =  $myQuoitems->description;
        $itemDetails['units'][] =  $item->units;

        $itemDetails['unitprice'][] =  $item->buy_price;
        $itemDetails['totalprice'] =  $item->sum('buy_price');
    }


    $pdf = PDF::loadView('bt.sales::pdfpurchase',array('purchase'=>$purchase, 'itemDetails' => $itemDetails, 'env' => env('APP_ENV')));
    return $pdf->setPaper('a4')->download("Purchase-Order-BT#" . $purchase->quote->id . "-" . $purchase->id . ".pdf");
});

Route::any('/srn/qc-srn/{id}', function ($id){
    $quote = ModelSrn::find($id);
    $counter = 0;
    $filler = array();
    $batch = array();
    foreach($quote->quote->items as $item) {
        if(isset($item->pipe) && !empty($item->pipe->id)) {
            $schedules = \Bt\Production\Models\Schedule::where('pipe_id', $item->pipe->id)->first();
            if(!empty($schedules)) {
                if(isset($schedules->controlsheet)) {
                    $filler[$schedules->id] = $schedules->controlsheet->id;
                }
                else {
                    $filler['None'. $counter] = 0;
                    $counter++;
                }
            }
        }
    }
    foreach ($filler as $sch) {
        $counter++;
        $schedule = \Bt\Production\Models\Schedule::where('controlsheet_id', $sch)->first();
        if(isset($schedule)) {
            $batch[] = $schedule->controlsheet->jobcard_id . '-'. $schedule->controlsheet->batch_id;
        }
        else {
            $batch[] = '-';
        }
    }
    $pdf = PDF::loadView('bt.sales::pdfQcSrn',array('quote'=>$quote, 'batch'=>$batch, 'env' => env('APP_ENV')));
    return $pdf->download((($quote->prefix_srn)?$quote->prefix_srn:'BT-QC-SRN').sprintf('%04d', $id).'.pdf');
});


Route::any('/admin/sales/invoices/export',function () {
    return Excel::download(new \Bt\Sales\Models\InvoiceExport(), 'Invoice-Export.xlsx');
});

Route::any('/admin/sales/orders/export',function () {
    return Excel::download(new \Bt\Sales\Models\OrdersExport(), 'Orders-Export.xlsx');
});

Route::any('/admin/sales/orders/production/export',function () {
    return Excel::download(new \Bt\Sales\Models\ExportProductionBalance(), 'Orders-Export.xlsx');
});

Route::any('/admin/sales/pbitem/export',function () {
    return Excel::download(new \Bt\Sales\Models\PbItemExport(), 'ProductionBalItem-Export.xlsx');
});

Route::any('/admin/sales/deliveries/export',function () {
    return Excel::download(new \Bt\Sales\Models\DeliveryExport(), 'Delivery-Export.xlsx');
});

Route::any('/admin/sales/delivery/export', function () {
    ini_set('memory_limit', '1024M');
    $collectionObj = array();
    $doneObj = array();
    $fabObj = array();
    $weeklyObj = array();
    $now = Carbon::now();
    // $thirtyDays = Carbon::now()->subDays(14);
    $thirtyDays = Carbon::createFromDate(2023, 1, 1);

    // $thirtyDays->hour = 0;
    // $thirtyDays->minute  = 0;
    // $thirtyDays->second  = 0;

    #Filter dates to count
    $srnObj  = SrnModel::where('schedule_date', '>', "2023-01-01 00:00:00")->orderBy('schedule_date', 'desc')->get();
    $delievries = DeliverPlanModel::where('schedule_date', '>=', $now)->orderBy('schedule_date', 'desc')->get();
    $deliveries_done = SrnModel::where('schedule_date','<', $now)->where('schedule_date', '>=', $thirtyDays)->where('fabrication', 0)->orderBy('schedule_date', 'desc')->get();
    $fabrication_done = SrnModel::where('schedule_date','<', $now)->where('schedule_date', '>=', $thirtyDays)->where('fabrication', 1)->orderBy('schedule_date', 'desc')->get();

    $weekly_done = SrnModel::where('schedule_date','>', "2023-01-01 00:00:00")->orderBy('schedule_date', 'desc')->where('fabrication', 0)->get();
    $week =  DB::table('bt_sales_srns')
        ->join(
            'bt_sales_srn_items',
            'bt_sales_srns.id',
            '=', 'bt_sales_srn_items.srn_id')
        ->leftjoin(
            'bt_sales_delivery_types',
            'bt_sales_srns.type_id',
            '=' , 'bt_sales_delivery_types.id')
        ->select(
            DB::raw("sum(bt_sales_srn_items.stockweight) as stockweight"),
            DB::raw("GROUP_CONCAT(bt_sales_delivery_types.id) as type"),
            DB::raw("week(schedule_date,1) as outweek"),
            DB::raw("monthname(schedule_date) as outmonth"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(schedule_date,'%Y'),' ',week(schedule_date,1),' Monday'), '%x %v %W')  as outyear"))
        ->where('schedule_date', '>', " 2023-01-01 00:00:00")
        ->where('fabrication', 0)
        ->groupBy("outweek","outyear")
        ->orderBy("outweek",'desc')
        ->get();

        $weekc =  DB::table('bt_sales_srns')
        ->join(
            'bt_sales_srn_catalogues',
            'bt_sales_srns.id',
            '=', 'bt_sales_srn_catalogues.srn_id')
        ->select(
            DB::raw("sum(bt_sales_srn_catalogues.stockweight) as kg"),
            DB::raw("sum(bt_sales_srn_catalogues.stockvalue) as stockvalue"),
            DB::raw("week(schedule_date,1) as outweek"),
            DB::raw("monthname(schedule_date) as outmonth"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(schedule_date,'%Y'),' ',week(schedule_date,1),' Monday'), '%x %v %W')  as outyear"))
        ->where('schedule_date', '>', " 2023-01-01 00:00:00")
        ->where('fabrication', 0)
        ->groupBy("outweek","outyear")
        ->orderBy("outweek",'desc')
        ->get();

    foreach ($delievries as $key => $delivery) {
        $date = Carbon::parse($delivery->schedule_date);
        $dateFormat = $date->format('Y-m-d');
        if($delivery->type->id == 1){
            $collectionObj[$dateFormat]['Delivery'] = (isset($collectionObj[$dateFormat]['Delivery'])? $collectionObj[$dateFormat]['Delivery']:0) + 1;
        }
        if($delivery->type->id == 2){
            $collectionObj[$dateFormat]['Collection'] = (isset($collectionObj[$dateFormat]['Collection'])? $collectionObj[$dateFormat]['Collection']:0) + 1 ;
        }
        if($delivery->vehicle_id ==  1){
            $collectionObjObj[$dateFormat]['Truck'] = (isset($collectionObj[$dateFormat]['Truck'])? $collectionObj[$dateFormat]['Truck']:0) + 1;
        }
        if($delivery->vehicle_id ==  2){
            $collectionObj[$dateFormat]['Bakkie'] = (isset($collectionObj[$dateFormat]['Bakkie'])? $collectionObj[$dateFormat]['Bakkie']:0) + 1;
        }
        if(isset($delivery->quote->company_name)){
            $collectionObj[$dateFormat]['Clients'][$delivery->quote->company_name] = $delivery->quote->company_name;
        }

        $collectionObj[$dateFormat]['Weight'] = 0;
        $collectionObj[$dateFormat]['svalue'] = 0;
    }

    foreach ($deliveries_done as $key => $done){
        $date = Carbon::parse($done->schedule_date);
        $dateFormat = $date->format('Y-m-d');
        $doneObj[$dateFormat]['month'] = $date->format('M');
        $doneObj[$dateFormat]['year'] = $date->format('Y');
        $doneObj[$dateFormat]['week'] = $date->format('W');

        if($done->type_id == 1){
            $doneObj[$dateFormat]['Delivery'] = (isset($doneObj[$dateFormat]['Delivery'])? $doneObj[$dateFormat]['Delivery']:0) + 1;
        }
        if($done->type_id == 2){
            $doneObj[$dateFormat]['Collection'] = (isset($doneObj[$dateFormat]['Collection'])? $doneObj[$dateFormat]['Collection']:0) + 1 ;
        }
        if($done->vehicle_id ==  1){
            $doneObj[$dateFormat]['Truck'] = (isset($doneObj[$dateFormat]['Truck'])? $doneObj[$dateFormat]['Truck']:0) + 1;
        }
        if($done->vehicle_id ==  2){
            $doneObj[$dateFormat]['Bakkie'] = (isset($doneObj[$dateFormat]['Bakkie'])? $doneObj[$dateFormat]['Bakkie']:0) + 1;
        }
        $quote =  $done->quote_id;
        $new_quote = ModelNewquote::find($quote);

        if(isset($new_quote->company_name)){
        $doneObj[$dateFormat]['Clients'][$new_quote->company_name] = $new_quote->company_name;
        }

        foreach ($done->items as $srn) {
            $doneObj[$dateFormat]['Weight'] = (isset($doneObj[$dateFormat]['Weight'])?$doneObj[$dateFormat]['Weight']: 0) + $srn->stockweight;
        }

        foreach ($done->itemscat as $ca) {
            $doneObj[$dateFormat]['sweight'] = (isset($doneObj[$dateFormat]['sweight'])?$doneObj[$dateFormat]['sweight']: 0) + $ca->stockweight;
            $doneObj[$dateFormat]['svalue'] = (isset($doneObj[$dateFormat]['svalue'])?$doneObj[$dateFormat]['svalue']: 0) + $ca->stockvalue;
        }
    }

    foreach ($fabrication_done as $key => $done){
        $date = Carbon::parse($done->schedule_date);
        $dateFormat = $date->format('Y-m-d');
        $fabObj[$dateFormat]['month'] = $date->format('M');
        $fabObj[$dateFormat]['year'] = $date->format('Y');
        $fabObj[$dateFormat]['week'] = $date->format('W');

        if($done->type_id == 1){
            $fabObj[$dateFormat]['Delivery'] = (isset($fabObj[$dateFormat]['Delivery'])? $fabObj[$dateFormat]['Delivery']:0) + 1;
        }
        if($done->type_id == 2){
            $fabObj[$dateFormat]['Collection'] = (isset($fabObj[$dateFormat]['Collection'])? $fabObj[$dateFormat]['Collection']:0) + 1 ;
        }
        if($done->vehicle_id ==  1){
            $fabeObj[$dateFormat]['Truck'] = (isset($fabObj[$dateFormat]['Truck'])? $fabObj[$dateFormat]['Truck']:0) + 1;
        }
        if($done->vehicle_id ==  2){
            $fabObj[$dateFormat]['Bakkie'] = (isset($fabObj[$dateFormat]['Bakkie'])? $fabObj[$dateFormat]['Bakkie']:0) + 1;
        }
        $quote =  $done->quote_id;
        $new_quote = ModelNewquote::find($quote);

        if(isset($new_quote->company_name)){
        $fabObj[$dateFormat]['Clients'][$new_quote->company_name] = $new_quote->company_name;
        }

        foreach ($done->items as $srn) {
            $fabObj[$dateFormat]['Weight'] = (isset($fabObj[$dateFormat]['Weight'])?$fabObj[$dateFormat]['Weight']: 0) + $srn->stockweight;
        }

        foreach ($done->itemscat as $ca) {
            $fabObj[$dateFormat]['svalue'] = (isset($fabObj[$dateFormat]['svalue'])?$fabObj[$dateFormat]['svalue']: 0) + $ca->stockvalue;
        }
    }
    foreach ($week as $key =>  $done){
            $collection_delivery = explode(',', $done->type);
            $date = Carbon::parse($done->outyear);
            $myyear = $date->format('Y');
            $dateFormat = $done->outweek. '/' . $done->outmonth.'/'. $myyear;
            $weeklyObj[$dateFormat]['week'] = $done->outweek;
            $weeklyObj[$dateFormat]['month'] = $done->outmonth;
            $weeklyObj[$dateFormat]['year'] = $myyear;
            foreach ($collection_delivery as $mydone){
                if($mydone == 1){
                    $weeklyObj[$dateFormat]['Delivery'] = (isset($weeklyObj[$dateFormat]['Delivery'])? $weeklyObj[$dateFormat]['Delivery']:0) + 1;
                }
                if($mydone == 2){
                    $weeklyObj[$dateFormat]['Collection'] = (isset($weeklyObj[$dateFormat]['Collection'])? $weeklyObj[$dateFormat]['Collection']:0) + 1 ;
                }
            }
            $weeklyObj[$dateFormat]['Weight'] = (isset($weeklyObj[$dateFormat]['Weight'])?$weeklyObj[$dateFormat]['Weight']: 0) + $done->stockweight;
    }

    foreach ($weekc as $key =>  $done){
            $date = Carbon::parse($done->outyear);
            $myyear = $date->format('Y');
            $dateFormat = $done->outweek. '/' . $done->outmonth.'/'. $myyear;
            $weeklyObj[$dateFormat]['week'] = $done->outweek;
            $weeklyObj[$dateFormat]['month'] = $done->outmonth;
            $weeklyObj[$dateFormat]['year'] = $myyear;

            $weeklyObj[$dateFormat]['svalue'] = (isset($weeklyObj[$dateFormat]['svalue'])?$weeklyObj[$dateFormat]['svalue']: 0) + $done->stockvalue;
                $weeklyObj[$dateFormat]['sweight'] = (isset($weeklyObj[$dateFormat]['sweight'])?$weeklyObj[$dateFormat]['sweight']: 0) + $done->kg;
    }

    $months = array();
    $weeks = array();
    foreach ($weeklyObj as $sk => $value){
        $months[$value['year'].$value['month']] = (isset($months[$value['year'].$value['month']])?$months[$value['year'].$value['month']]:0) + 1;
    }

    foreach ($doneObj as $sk => $value){
        $weeks[$value['year'].$value['week']] = (isset($weeks[$value['year'].$value['week']])?$weeks[$value['year'].$value['week']]:0) + 1;
    }
    $pdf = PDF::loadView('bt.sales::pdfDeliveries',array('doneObj' => $doneObj, 'deliveryObj' => $collectionObj, 'weeklyObj' => $weeklyObj, 'month' => $months, 'weeks' => $weeks, 'fabObj' => $fabObj, 'srns' => $srnObj, 'env' => env('APP_ENV')));
    return $pdf->setPaper('a3', 'landscape')->download('Deliveries_'.$now.'.pdf');
});

Route::any('/srn/V2/download/{id}.pdf', function ($id) {
    $srn = ModelSrn::find($id);
    $email = $srn->logisticsignature->createdby->email;
    $employee = \Bt\HR\Models\Employee::where('email', $email)->first();
    $quote = ModelSrn::find($id);
    $pdf = PDF::loadView('bt.sales::pdfsrnv2',array('quote'=>$quote, 'emp' => $employee, 'env' => env('APP_ENV')));
    return $pdf->download((($quote->prefix_srn)?$quote->prefix_srn:'BT-SRN').sprintf('%04d', $id).'.pdf');

});

Route::any('/srn/V2/preview/download/{id}.pdf', function ($id) {
    $srn = ModelSrn::find($id);
    $email = $srn->logisticsignature->createdby->email;
    $employee = \Bt\HR\Models\Employee::where('email', $email)->first();
    $quote = ModelSrn::find($id);
    $pdf = PDF::loadView('bt.sales::pdfsrnv2',array('quote'=>$quote, 'emp' => $employee, 'env' => env('APP_ENV')));
    return $pdf->setPaper('a4')->stream();

});


Route::any('/admin/sales/orders/export/pdf', function () {
    $im_id = 9999;

    if(isset($_SESSION['starter'])){
        $enddate = $_SESSION['ender'];
    }else{
        $enddate = Carbon::now()->setTime(00, 00, 00);;
    }

    if(isset($_SESSION['starter'])){
        $startdate = $_SESSION['starter'];
    }else{
        $current = Carbon::now();
        $startdate = $current->addDays(-30)->setTime(00, 00, 00);;
    }

    if(isset($_SESSION['user_sales'])){
        $im_id = $_SESSION['user_sales'] ;
    }
    $quoteModel = QuoteModel::where('ponumber',"<>","")->whereNotnull('ponumber')->whereBetween('created_at', array($startdate, $enddate))
        ->whereHas('user', function ($query) use ($im_id)  {
            if($im_id != 9999){
                $query->where('id', $im_id);
            }
            $query->orderby("name","asc");
        })->orderby("user_id","asc")->orderby("created_at","desc")->get();
    $blend = new \Bt\Sales\Controllers\Mydashboard();
    $blended = $blend->getProductionBalance($startdate, $enddate, $im_id);
    $pdf = PDF::loadView('bt.sales::pdfOrders',array('quote' => $quoteModel, 'balance' => $blended, 'env' => env('APP_ENV')));
    return $pdf->setPaper('a3', 'landscape')->download('Production-Balance'.'.pdf');
});

Route::any('/pickslip/get-latest/{id}/{pick}/{type?}', function ($id, $pick,$type = null){
    $quote = \Bt\Sales\Models\Newquote::find($id);
    $quoteObj = array();
    $myassoc = null;
    $jobcard = Jobcard::orderBy('id', 'desc');
    if(isset($quote->id) && $quote->id > 0) {
        $chosen_quote = $quote->id;

        //Get the pipes belonging to the quote with a batch
        $jobcard = $jobcard->whereHas('pipe', function ($query) use ($chosen_quote) {
            $query->where('id', '<>', null)->whereHas('qpush', function ($query) use ($chosen_quote) {
                $query->where('id', '<>', null)->whereHas('quote', function ($query) use ($chosen_quote) {
                    $query->where('id', $chosen_quote);
                });
            });
        });

        //Get the pipes belonging to the quote without a batch
        $batch_less = Quoteitems::where('quote_id', $chosen_quote)->get();

        //Set the quoteObj with the batchless pipes
        foreach ($batch_less as $item){
            $totalbtaccount = 0;
            //get all Items Delivered for this quote
            $srnObj = \Bt\Sales\Models\Srn::where('quote_id', $chosen_quote)->get();
            if(!empty($srnObj)){
                foreach ($srnObj as $srn){
                    if(!empty($srn->items)){
                        foreach ($srn->items as $srnitem){
                            //Compare Items delivered for the quote with QuoteItems
                            if(($item->product_id === $srnitem->pipe->quoteitems->product_id) && ($item->unitlength === $srnitem->pipe->quoteitems->unitlength)){
                                if($srnitem->pipe->quoteitems->id !== $item->id ){
                                    $totalbtaccount = $totalbtaccount + $srnitem->units;
                                }
                            }
                        }
                    }
                }
            }

            $quoteObj[$item->id]['batch'] = 'No Batch';
            $quoteObj[$item->id]['item'] = $item->description;
            $quoteObj[$item->id]['order'] = $item->units;
            $quoteObj[$item->id]['already_delivered'] = $totalbtaccount;
            $quoteObj[$item->id]['delivered'] = $quoteObj[$item->id]['already_delivered'];
            $quoteObj[$item->id]['todeliver'] = $quoteObj[$item->id]['order'] - $quoteObj[$item->id]['delivered'];
        }

        //Get Pipes with batches including associations
        if (!empty($jobcard)) {
            $jobcard = $jobcard->get();
            foreach ($jobcard as $job) {
                foreach ($job->batch as $b) {
                    $batch_key = $b->id;
                    if (isset($job->pipe->quoteitems->description)) {
                        $quoteObj[$job->pipe->quoteitems->id]['batch'] = $job->id . "-" . $b->id;
                        $quoteObj[$job->pipe->quoteitems->id]['item'] = $job->pipe->quoteitems->description;
                        $quoteObj[$job->pipe->quoteitems->id]['ponumber'] = $job->pipe->qpush->quote->ponumber;
                        $quoteObj[$job->pipe->quoteitems->id]['date'] = $job->pipe->quoteitems->created_at;
                        $quoteObj[$job->pipe->quoteitems->id]['client'] = $job->pipe->qpush->quote->company_name;
                        $quoteObj[$job->pipe->quoteitems->id]['quote'] = $job->pipe->qpush->quote_id;
                        $quoteObj[$job->pipe->quoteitems->id]['order'] = $job->pipe->quoteitems->units;
                        $quoteObj[$job->pipe->quoteitems->id]['produced'] = $job->pipe->getTotalProduced() + $job->pipe->getTotalExtras();
                        if ($quoteObj[$job->pipe->quoteitems->id]['produced'] == 0) {
                            $quoteObj[$job->pipe->quoteitems->id]['extra'] = 0;
                        } else {
                            $quoteObj[$job->pipe->quoteitems->id]['extra'] = $quoteObj[$job->pipe->quoteitems->id]['produced'] - $quoteObj[$job->pipe->quoteitems->id]['order'];
                        }

                        if(!isset($quoteObj[$job->pipe->quoteitems->id]['already_delivered']))
                            $quoteObj[$job->pipe->quoteitems->id]['delivered'] = $job->pipe->getDeliveredByQuote($job->pipe->quoteitems->quote_id);
                        else
                        {
                            $quoteObj[$job->pipe->quoteitems->id]['delivered'] = $job->pipe->getDeliveredByQuote($job->pipe->quoteitems->quote_id) + $quoteObj[$job->pipe->quoteitems->id]['already_delivered'];
                        }

                        $quoteObj[$job->pipe->quoteitems->id]['yard'] = $quoteObj[$job->pipe->quoteitems->id]['produced'] - $job->pipe->getTotalDelivered();
                        $quoteObj[$job->pipe->quoteitems->id]['todeliver'] = $quoteObj[$job->pipe->quoteitems->id]['order'] - $quoteObj[$job->pipe->quoteitems->id]['delivered'];

                        $q = Newquote::find($quoteObj[$job->pipe->quoteitems->id]['quote']);

                        foreach ($q->pipesdeliver as $key => $pipe) {

                            $qc = $pipe->getTotalProduced();
                            $dlv = $pipe->getTotalDelivered();
                            $good = $qc - $dlv;
                            $assoc = $pipe->quoteitems->description;
                            $original = $quoteObj[$job->pipe->quoteitems->id]['item'];
                            $newassoc = null;
                            if(strpos($assoc,'.00m' ))
                                $newassoc = str_replace(".00m","m",$assoc);
                            else{
                                $newassoc = $assoc;
                            }
                            if($original == $newassoc){
                                if($good > 0){
                                    $myassoc .= $pipe->quoteitems->quote_id . " ";
                                    if($original == $job->pipe->quoteitems->description)
                                        $quoteObj[$job->pipe->quoteitems->id]['associate'] = (isset($quoteObj[$job->pipe->quoteitems->id]['associate'])?$quoteObj[$job->pipe->quoteitems->id]['associate']:0) + $good;

                                }
                            }
                        }

                    }
                }
            }
        }
    }
    $pickslip = \Bt\Sales\Models\Pickslip::find($pick);
    $pdf = PDF::loadView('bt.qc::pdfslip',array('quote'=>$quote, 'quoteObj' => $quoteObj, 'pick'=> $pickslip, 'assoc' => $myassoc,'type' => $type, 'env' => env('APP_ENV')));
    return $pdf->setPaper('a4')->download("BT-Pick Slip-".$id."v".count($quote->responses).'.pdf');

});


Route::any('/fab/item/{state}/download/{id}.pdf', function ($state, $id) {
    $fabrication = Fabrication::find($id);
    $pdf = PDF::loadView('bt.sales::fabrication',array('quote'=>$fabrication, 'state'=> $state, 'env' => env('APP_ENV')));
    if($state == 'out'){
        return $pdf->download('Fabrication Release-'. $fabrication->quote->id. "-" .$fabrication->id.'.pdf');
    }else{
        return $pdf->download('Fabrication Return-'. $fabrication->quote->id. "-" .$fabrication->id.'.pdf');
    }

});

Route::any('/admin/bt/sales/export/quote/items/', function (){
    return Excel::download(new \Bt\Sales\Models\QuoteItemExport(), 'Quote-Item-Export.xlsx');
});

Route::any('/admin/bt/sales/export/srn/items/', function (){
    return Excel::download(new \Bt\Sales\Models\SrnItemExport(), 'Srn-Item-Export.xlsx');
});

Route::any('/stockorder/item/download/{id}.pdf', function ($id) {

    $quote = StockOrder::find($id);
    $pdf = PDF::loadView('bt.sales::pdfStockOrder',array('quote'=>$quote));
    return $pdf->download((($quote->prefix_srn)?$quote->prefix_srn:'BT-Available Ordered Notification').sprintf('%04d', $id).'.pdf');

  });


Route::any('/quote/item/download/{key_pass}/{id}.pdf', function ($key_pass, $id) {

    $quote = ModelNewquote::where('id', $id)->where('key_pass', $key_pass)->first();
    if(!empty($quote)){
        $quote->fixTotal();
    }
    $pdf = PDF::loadView('bt.sales::pdfitem',array('quote'=>$quote, 'env' => env('APP_ENV')));
    return $pdf->setPaper('a4')->stream();
});

// api end point to update scroll position of terms and conditions on quote
Route::patch('/quote/approval/{key_pass}/{id}', function($key_pass, $id){
    return 'Hello World!';
});

Route::any('/admin/bt/sales/export/fabrication/items/', function (){
    return Excel::download(new \Bt\Sales\Models\FabItemExport(), 'Srn-Item-Export.xlsx');
});

Route::any('/admin/bt/sales/newquote/converted',function () {
    return Excel::download(new \Bt\Sales\Models\ConvertedQuotes(), 'Converted-Quotes.xlsx');
});
