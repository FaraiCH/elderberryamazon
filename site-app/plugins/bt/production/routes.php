<?php

use Bt\Production\Models\Line as LineModel;
use Bt\Production\Models\Pipestickeritem;
use Bt\Production\Models\Schedule as ScheduleModel;
use Carbon\Carbon;
#use Japps\Wall\Models\Wall as WallModel;
#use Modules\Cms\Classes\Controller as Controller;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\Srn as ModelSrn;
use Bt\Maintenance\Models\Schedule as ModelSchedule;

use Bt\Production\Models\Jobcard as ModelProductionJobCard;
use Bt\Production\Models\ControlSheet as ModelControlSheet;

use October\Rain\Support\Facades\Http;
use Bt\Maintenance\Models\Tools as ToolsModel;
use Bt\Production\Models\Push as PushModel;
use Bt\Inventory\Models\Exportpush;

use Bt\Production\Models\Pipe as PipeModel;
use Bt\Production\Models\PrintSticker as PrintStickerModel;

use Bt\Production\Models\ScrapCodes;

//use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel;
//use Vdomah\Excel\Classes\Excel;

use Maatwebsite\Excel\Facades\Excel;

#use Excel;
//use PDF;
use Renatio\DynamicPDF\Classes\PDF;

// // Route::any('/maintenance/item/download/schedule.pdf', function () {
//
// //   $quote = ModelSchedule::active()->orderBy('scheduledate')->get();
// //   $pdf = PDF::loadView('bt.maintenance::pdfschedule',array('quote'=>$quote));
// //   return $pdf->setPaper('a4', 'landscape')->download('schedule.pdf');
//
// //        });


Route::any('/productionqc/item/download/{id}.pdf', function ($id) {
    $quote = ModelControlSheet::find($id);
    $pdf = PDF::loadView('bt.production::pdfqcinspection',array('quote'=>$quote));
    return $pdf->setPaper('a3')->stream();
    return $pdf->setPaper('a3')->download("BT-CONTROLSHEET-".sprintf('%04d', $id).'.pdf');
});


Route::any('/productionjobcard/item/download/{id}.pdf', function ($id) {
    $quote = ModelProductionJobCard::find($id);
    $pdf = PDF::loadView('bt.production::pdfproductionjobarditem',array('quote'=>$quote));
    return $pdf->setPaper('a3')->download("BT-PRODUCTION-JOBCARD-".sprintf('%04d', $id).'.pdf');
});
Route::any('/productionjobcarddaily/item/download/{id}.pdf', function ($id) {
    $quote = ModelProductionJobCard::find($id);
    $pdf = PDF::loadView('bt.production::pdfproductionjobarditemdaily',array('quote'=>$quote));
    return $pdf->setPaper('a4')->download("BT-PRODUCTION-RUN-".sprintf('%04d', $id).'.pdf');
});

// // Route::any('/production/item/download/{id}', function ($id) {
//
// // 	$obj = new Exportpush($id);
// //   	return Excel::download($obj , 'users.xlsx');
//
// //        });
Route::any('/pipe/item/download/{id}', function ($id) {

    $quote = PipeModel::find($id);
    //dd($quote);
    $pdf = PDF::loadView('bt.production::pdfpipe',array('quote'=>$quote));
    $name = (!empty($quote->qpush->quote->invoice->name)?$quote->qpush->quote->invoice->name:"")." - ".$quote->qpush->quote->company_name." - ".$quote->quoteitems->description;
    return $pdf->setPaper('a4', 'landscape')->download($name.'.pdf');

});

Route::any('/controlsheet/item/download/{id}.pdf', function ($id) {
    $quote = ModelControlSheet::find($id);
    $pdf = PDF::loadView('bt.production::pdfcontrolsheet',array('quote'=>$quote));
    return $pdf->setPaper('a3')->download("BT-CONTROLSHEET-".sprintf('%04d', $id).'.pdf');
});
Route::any('/controlsheetactuals/item/download/{id}.pdf', function ($id) {
    $quote = ModelControlSheet::find($id);
    $pdf = PDF::loadView('bt.production::pdfcontrolsheetactuals',array('quote'=>$quote));
    return $pdf->setPaper('a3')->download("BT-CONTROLSHEET-".sprintf('%04d', $id).'.pdf');
});
Route::any('/controlsheet/item/download/{id}', function ($id) {
    $quote = ModelControlSheet::find($id);
    $pdf = PDF::loadView('bt.production::pdfcontrolsheetactuals',array('quote'=>$quote));
    return $pdf->setPaper('a3')->stream();
});
Route::any('/productioninspection/item/download/{id}', function ($id) {
    $quote = ModelControlSheet::find($id);
    $pdf = PDF::loadView('bt.production::pdfproductioninspection',array('quote'=>$quote));
    return $pdf->setPaper('a3')->stream();
});
Route::any('/controlsheet/item/download/blank.pdf', function ($id) {

    $pdf = PDF::loadView('bt.production::pdfcontrolsheet',array('quote'=>null));
    return $pdf->setPaper('a3')->download("BT-CONTROLSHEET-blank.pdf");
});

Route::any('/printstickers/item/download/{id}', function ($id) {

    $quote = PrintStickerModel::find($id);
    //dd($quote);
    $pdf = PDF::loadView('bt.production::pdfstickers',array('quote'=>$quote));
    $name = "BT Sticker Batch ".$quote->id;
    return $pdf->setPaper('a4')->download($name.'.pdf');

});

Route::any('/print/production/scrapcodes.pdf', function () {
    $obj = ScrapCodes::all();
    $pdf = PDF::loadView('bt.production::pdfscrapcodes',array('obj'=>$obj));
    return $pdf->setPaper('a4')->download("pdfscrapcodes.pdf");
});


Route::any('/admin/plan/pdf/{type}', function ($type) {

    if(isset($_SESSION['openstart'])){
        $now = $_SESSION['openend'];
        $end = $_SESSION['openstart'];
        $obj = \Bt\Production\Models\ProductionPlan::whereBetween('startdate', [$_SESSION['openstart'], $_SESSION['openend']])
            ->where('type', $type)->where('status_id', '!=', 5)
            ->with(['btline' => function($query){
                $query->orderBy('sort_order', 'asc');
            }])
            ->get();
    }else{
        $now = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();
        $obj = \Bt\Production\Models\ProductionPlan::whereBetween('startdate', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('type', $type)->where('status_id', '!=', 5)
            ->with(['btline' => function($query){
                $query->orderBy('sort_order', 'asc');
            }])
            ->get();
    }
    $sortObj = $obj->sortBy('btline.sort_order');
    $plitems = array();
    $total_weight = 0;
    foreach ($sortObj as $sub){
        foreach($sub->planitems as $planitem){
            $total_weight += $planitem->item->sum('weight');
            if(isset($planitem->item->pipe->id)){
                $datess = new \DateTime($planitem->item->pipe->created_at);
                $date1 = $datess->format('Y-m-d');
                $date2 = date('Y-m-d');
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $difference = $timestamp2 - $timestamp1;
                $plitems[$planitem->item->id] = $datess->format('d-M') . ' ('. $difference/(24*60*60) . ' days)';
            }

        }

        foreach ($sub->planitemscat as $planitem)
        {
            if(isset($planitem->itemscat->btproduct_id))
            {
                $total_weight += $planitem->itemcat->sum('weight');
            }

        }

    }

    $pdf = PDF::loadView('bt.production::pdfplans',array('obj'=>$sortObj, 'start' => $end, 'end' => $now, 'plitem' => $plitems, 'type' => $type, "now" => Carbon::now(), 'total_weight' => $total_weight));
    if($type == 0){
        return $pdf->setPaper('a3', 'landscape')->download("BT Weekly Production Plan - ". date('F d Y', strtotime($now)) .".pdf");
    }else{
        return $pdf->setPaper('a3', 'landscape')->download("BT Order Plan - ". date('F d Y', strtotime($now)) .".pdf");
    }


});

Route::any('/admin/push/export',function (){
    return Excel::download(new \Bt\Production\Models\ExperiEpxort(), 'Production.xlsx');
});

Route::any('/update-baila/{val}',function ($val){
    if(isset($_SESSION['prostart'])){
        $schedules = ScheduleModel::whereBetween('production_date', [$_SESSION['prostart'], $_SESSION['proend']])->orderBy('production_date')->get();
    }else{
        $now = Carbon::now();
        $week = Carbon::now()->subDays(7);
        $schedules = ScheduleModel::whereBetween('production_date', [$week, $now])->orderBy('production_date')->get();
    }
    $data = array();
    $caplines = LineModel::all();
    $cap = $caplines->sum("capacity") * 24 * 30;
    $total  = 0;

    foreach ($schedules as $skey => $schedule) {
        if($schedule->pipe->btline->id == $val){
            $line = $schedule->pipe->btline->name;
            $createdAt = Carbon::parse($schedule->production_date);
            $datetri = "01-".$createdAt->format('m-Y');
            $test =  Carbon::parse($datetri)->timestamp;
            $date_ =  $datetri;

            if(isset($data[$line]) && isset($data[$line][$date_]) ){
                $data[$line][$date_] = $data[$line][$date_]+$schedule->usedmaterials->sum("kg");
            }else{
                $data[$line][$date_] = $schedule->usedmaterials->sum("kg");
            }
        }


    }

    foreach ($schedules as $skey => $schedule) {
        if($schedule->pipe->btline->id == $val) {
            $line = $schedule->pipe->btline->name;
            $createdAt = Carbon::parse($schedule->production_date);
            $datetri = "01-" . $createdAt->format('m-Y');
            $test = Carbon::parse($datetri)->timestamp;
            $date_ = $datetri;


            $line = "TOTAL";
            if (isset($data[$line]) && isset($data[$line][$date_])) {
                $data[$line][$date_] = $data[$line][$date_] + $schedule->usedmaterials->sum("kg");
            } else {
                $data[$line][$date_] = $schedule->usedmaterials->sum("kg");
            }

            $total += $schedule->usedmaterials->sum("kg");

        }
    }
    $stats = array();
    foreach ($data as $name => $arrdata) {
        $content = array();
        foreach ($arrdata as $key => $value) {
            $content[] = array(Carbon::parse($key)->timestamp*1000 + 2*3600*1000, $value );
        }
        if($name == "MAX CAPACITY"){
            $stats[] = array('name' =>  $name , 'data' => $content,'color'=>'transparent' );
        }else{
            $stats[] = array('name' =>  $name , 'data' => $content);
        }

    }
    return $stats;
});

Route::any('/admin/plan/export',function (){
    return Excel::download(new \Bt\Production\Models\MultiSheetPlanExport(), 'Plan Export.xlsx');
});


use Bt\Production\Classes\CustomResponse;

Route::post('/weighbridge-demo-api-endpoint', function(){
    return response()->json([
        'message' => 'Server response',
        'data' => post()
    ]);
})->middleware(Bt\Production\Classes\Cors::class);

/**
 * weigh bridge integration api routes
 */
Route::group(['middleware' => [Bt\Production\Classes\Cors::class], 'prefix' => '/api/v1/production'], function () {
    /**
     * get multiple srns
     */
    Route::get('/srns', function() {
        $searchQuery = request('query');
        $res = null;
        if($searchQuery) {
            $res = Bt\Sales\Models\Srn::where('id', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhereHas('client', function ($query) use ($searchQuery) {
                        $query->where('company_name', 'LIKE', '%' . $searchQuery . '%');
                    })
                    ->with('client:id,company_name', 'type:id,name')
                    ->select('id', 'client_id', 'type_id')
                    ->orderBy('id', 'DESC')
                    ->paginate(5);
        } else {
            $res = Bt\Sales\Models\Srn::with('client:id,company_name', 'type:id,name')
                ->select('id', 'client_id', 'type_id')
                ->orderBy('id', 'DESC')
                ->paginate(5);
        }

        $data = $res->map(function($item) {
            return [
                'id' => $item->id,
                'company_name' => $item->client->company_name,
                'type' => optional($item->type)->name
            ];
        });

        return CustomResponse::api('success', null, $data);
    });

    /**
     * get single srn
     */
    Route::get('/srns/{id}', function($id){
        $res = Bt\Sales\Models\Srn::where('id', $id)
                ->with('client', 'type')
                ->first();

        $data = [
            'id' => $res->id,
            'company_name' => $res->client->company_name,
            'type' => optional($res)->type->name
        ];

        return CustomResponse::api('success', null, $data);
    });

    /**
     * weigh vehicle
     */
    Route::put('/srns/{id}', function($id){
        $srn = Bt\Sales\Models\Srn::where('id', $id)
                ->with('client')
                ->first();

        if(!$srn) {
            return response()->json([
                'status' => 'success',
                'message' => 'No data found',
                'data' => null
            ]);
        }

        return CustomResponse::api('success', null, $srn);
    });

    /**
     * get multiple dispatch
     */
    Route::get('/dispatches', function() {
        $searchQuery = request('query');
        $res = [];

        if($searchQuery) {
            $res = Bt\Production\Models\Dispatch::where('exit_weight', null)
                   ->where(function($query) use ($searchQuery) {
                        $query->where('id', 'LIKE', '%' . $searchQuery . '%')
                              ->orWhere('company_name', 'LIKE', '%' . $searchQuery . '%');
                   })
                   ->orderBy('id', 'DESC')
                   ->paginate(100);
        } else {
            $res = Bt\Production\Models\Dispatch::where('exit_weight', null)
                    ->orderBy('id', 'DESC')
                    ->paginate(100);
        }

        $data = $res->map(function($item) {
            return [
                'id' => $item->id,
                'transport_type' => $item->transport_type,
                'company_name' => $item->company_name,
                'driver_full_names' => $item->driver_full_names,
                'vehicle_registration' => $item->vehicle_registration,
                'trailers_registration' => $item->trailers_registration,
                'entry_weight' => $item->entry_weight,
                'srn_id' => $item->srn_id,
                'srn_items_weight' => number_format((float)$item->srn->items_weight, 2, '.', '')
            ];
        });

        return CustomResponse::api('success', null, $data);
    });

    /**
     * create dispatch
     */
    Route::post('/dispatches', function(){
        $validator = Validator::make(Input::all(), [
            'srn_id' => 'required',
            'company_name' => 'required',
            'transport_type' => 'required',
            'vehicle_registration' => 'required',
            'trailers_registration' => '',
            'driver_full_names' => 'required',
            'entry_weight' => 'required',
        ]);

        if ($validator->fails()) {
            return CustomResponse::api('validation', null, [
                'srn_id' => $validator->errors()->get('srn_id'),
                'company_name' => $validator->errors()->get('company_name'),
                'transport_type' => $validator->errors()->get('transport_type'),
                'vehicle_registration' => $validator->errors()->get('vehicle_registration'),
                'trailers_registration' => $validator->errors()->get('trailers_registration'),
                'driver_full_names' => $validator->errors()->get('driver_full_names'),
                'entry_weight' => $validator->errors()->get('entry_weight')
            ]);
        }

        $res = Bt\Production\Models\Dispatch::create(post());
        return CustomResponse::api('success', null, $res);
    });

    /**
     * get single dispatch
     */
    Route::get('/dispatches/{id}', function($id){
        $res = Bt\Production\Models\Dispatch::where('id', $id)->with('srn')->first();

        $data = [
            'id' => $res->id,
            'transport_type' => $res->transport_type,
            'company_name' => $res->company_name,
            'driver_full_names' => $res->driver_full_names,
            'vehicle_registration' => $res->vehicle_registration,
            'trailers_registration' => $res->trailers_registration,
            'entry_weight' => $res->entry_weight,
            'srn_items_weight' => number_format((float)$res->srn->items_weight, 2, '.', '')
        ];

        return CustomResponse::api('success', null, $data);
    });

    /**
     * update dispatch
     */
    Route::post('/dispatches/{id}', function($id){
        $validator = Validator::make(Input::all(), [
            'weight' => 'required',
        ]);

        if ($validator->fails()) {
            return CustomResponse::api('validation', null, [
                'weight' => $validator->errors()->get('weight')
            ]);
        }

        $res = Bt\Production\Models\Dispatch::where('id', $id)->first();
        $res->exit_weight = post('weight');
        $res->save();
        return CustomResponse::api('success', null, $res);
    });
});

Route::get('/sticker/data', function ()
{
   return Pipestickeritem::where('production_date','>=', "2023-07-10 00:00:00")->where('is_active', 1)->where('dispatch_date', null)->get();
});
