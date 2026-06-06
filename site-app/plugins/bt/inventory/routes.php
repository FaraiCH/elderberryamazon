<?php

use Bt\Production\Models\Pipe;
use Bt\Sales\Models\Srn;
use Carbon\Carbon;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceiving;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Inventory\Models\BagBatch as BagBatch;

use Bt\Inventory\Models\PrintSticker as PrintStickerModel;

use October\Rain\Support\Facades\Http;
use Renatio\DynamicPDF\Classes\PDF;
use Bt\Production\Models\Schedule as ScheduleModel;


Route::any('/report/download/inventory/today.pdf', function () {
    $date = Carbon::now();
    $quote = RawMaterialReceiving::active()->orderBy("supplier_batch")->get();
    $pdf = PDF::loadView('bt.inventory::pdftoday',array('quote'=>$quote));
    return $pdf->setPaper('a4', 'landscape')->download('Inventory_'.$date->format('d-m-Y').'.pdf');

});

Route::any('/report/download/{state}/{company_id}/pipes/today.pdf', function ($state, $company_id) {
    $mon = array();
    $date = Carbon::now();
    if(isset($_SESSION['enddate'])){
        $this->enddate = $_SESSION['enddate'];
    }else{
        $this->enddate = Carbon::now()->setTime(23, 59, 0);
    }

    if(isset($_SESSION['prostart'])){;
        $this->startdate = $_SESSION['prostart'];
    }else{
        $current = Carbon::now();
        $this->startdate = $current->addDays(-7);
    }
    $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);
    $pipes = ScheduleModel::whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))->where('is_stock', 0)->get();
    $parra= array();
    foreach ($pipes as $v) {
        $parra[$v->pipe_id] = $v->pipe_id;
    }
    $quote = getPipeModel($state, $parra, $data, $company_id);
    $reasons = array();
    $oparatorname = [];
    $monster = [];
    $totals = [];
    //Place Quote Here
    foreach ($quote as $qkey => $qvalue) {
        foreach ($qvalue->schedules as $key => $value) {
            $oparator = "Unkown";
            $oparatorid = 0;
            if(!empty($value->assignedto) && $value->assignedto->name){
                $oparator = $value->assignedto->name;
                $oparatorid = $value->assignedto_id;
            }


            $oparatorname[$oparatorid] = $oparator;
            $date_ = Carbon::parse($value->production_date);
            $d = $date_->format('Y-m-d');

            if(isset($monster[$d]) ){
                if(isset($monster[$d][$oparatorid]) ){

                    $monster[$d][$oparatorid]["total_kg_processed"] += $value->total_kg_processed;
                    $monster[$d][$oparatorid]["weight_scrap_kg"] += $value->weight_scrap_kg;
                }else{
                    $monster[$d][$oparatorid]["total_kg_processed"] = $value->total_kg_processed;
                    $monster[$d][$oparatorid]["weight_scrap_kg"] = $value->weight_scrap_kg;
                }
            }else{
                $monster[$d][$oparatorid]["total_kg_processed"] = $value->total_kg_processed;
                $monster[$d][$oparatorid]["weight_scrap_kg"] = $value->weight_scrap_kg;

            }

            $d = "Totals";
            if(isset($totals[$d]) ){
                if(isset($totals[$d][$oparatorid]) ){

                    $totals[$d][$oparatorid]["total_kg_processed"] += $value->total_kg_processed;
                    $totals[$d][$oparatorid]["weight_scrap_kg"] += $value->weight_scrap_kg;
                }else{
                    $totals[$d][$oparatorid]["total_kg_processed"] = $value->total_kg_processed;
                    $totals[$d][$oparatorid]["weight_scrap_kg"] = $value->weight_scrap_kg;
                }
            }else{
                $totals[$d][$oparatorid]["total_kg_processed"] = $value->total_kg_processed;
                $totals[$d][$oparatorid]["weight_scrap_kg"] = $value->weight_scrap_kg;

            }
            foreach ($value->scrapcodes as $key_ => $value_) {

                if(isset($reasons[$value_->code])){
                    $reasons[$value_->code]['value'] += 1;
                }else{
                    $reasons[$value_->code]['value'] = 1;
                    $reasons[$value_->code]['reason'] = $value_->reason;
                    $reasons[$value_->code]['code'] = $value_->code;
                }
            }
        }
    }
    //Place Deliveries and Collections Here if necessary
    $months = array();
    $startdate = "2023/01/01";
    $w = getScheduleModel($state, $startdate, $this->enddate ." 23:59:00", $company_id);

    $mon = useSchedule($w, $mon);

    foreach ($mon as $sk => $value){
        $months[$value['year'].$value['month']] = (isset($months[$value['year'].$value['month']])?$months[$value['year'].$value['month']]:0) + 1;
    }

    $starter = new \DateTime($this->startdate);
    $ender = new \DateTime($this->enddate);
    $pdf = PDF::loadView('bt.inventory::pdfproductiontoday',array('quote'=>$quote,'data'=> $data,'reasons'=>$reasons,'monster'=>$monster,'mypeople'=>$oparatorname,'totals'=>$totals, 'scheduleObj'=> $mon, 'months' => $months));
    return $pdf->setPaper('a3', 'landscape')->download('BT Weekly Production Report '. $starter->format('d-m-Y') .' - '. $ender->format('d-m-Y') .'.pdf');

});

Route::any('/materialprintstickers/item/download/{id}', function ($id) {
    $quote = PrintStickerModel::find($id);
    $pdf = PDF::loadView('bt.inventory::pdfstickers',array('quote'=>$quote));
    $name = "BT Material Sticker Batch ".$quote->id;
    return $pdf->setPaper('a4')->download($name.'.pdf');
});

function getPipeModel($state, $parra, $data, $company_id){
    $pipe = PipeModel::whereIn('id',$parra)
        ->whereHas('schedules', function ($query) use ($data) {
            $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))->where('is_stock', 0)->has('usedmaterials');
        })
        ->with(['schedules' => function ($query) use ($data) {
            $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))->where('is_stock', 0)->has('usedmaterials');
        },
            'quoteitems.product'=> function ($query) {
                $query->orderBy('diameter_id', 'desc');
            }
        ])->orderBy('line_id');
    if($state === "standard")
        $pipe = $pipe->get();
    elseif($state === "only")
        $pipe = $pipe->whereHas('quoteitems', function($query) use($company_id){
            $query->whereHas('quote', function($q) use ($company_id){
                $q->whereHas('client', function($que) use($company_id){
                    $que->where('id', $company_id);
                });
            });
        })->get();
    elseif($state === "exclude")
        $pipe = $pipe->whereHas('quoteitems', function($query) use($company_id){
            $query->whereHas('quote', function($q) use ($company_id){
                $q->whereHas('client', function($que) use($company_id){
                    $que->where('id', '<>', $company_id);
                });
            });
        })->get();
    else{
        $pipe = $pipe->get();
    }
    $pipe = $pipe->sortByDesc('quoteitems.product.diameter_id');
    return $pipe;
}

function useSchedule($w, $mon){
    foreach ($w as $key => $value) {
        $k =  $value->outweek.$value->outyear;
        $mon[$k]["total_kg_processed"] =  $value->total_kg_processed;
        $mon[$k]["total_kg_processed_avg"] =  ((int)$value->total_kg_processed)/7;
        $mon[$k]["weight_scrap_kg"] =  (int)$value->weight_scrap_kg;
        $mon[$k]["over_weight_kg"] =  (int)$value->over_weight_kg;
        $mon[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;

        $date_ = Carbon::parse($value->outyear.' 00:00:00');
        $mon[$k]["month"] = $date_->format("F");
        $mon[$k]["year"] = $date_->year;
    }
    return $mon;
}

function getScheduleModel($state, $startdate, $enddate, $company_id){
    $w = ScheduleModel::select(
        DB::raw("sum(total_kg_processed) as total_kg_processed"),
        DB::raw("sum(weight_scrap_kg) as weight_scrap_kg"),
        DB::raw("sum(over_weight_kg) as over_weight_kg"),
        DB::raw("week(production_date,1) as outweek"),
        DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Monday'), '%x %v %W')  as outyear"))
        ->where('production_date','>', $startdate)
        ->where('is_stock', 0)
        ->has('usedmaterials')
        ->groupBy("outweek","outyear")
        ->orderBy("outyear",'desc')
        ->orderBy("outweek",'desc');

    if($state === "standard")
        $w = $w->get();
    elseif($state === "only")
        $w = $w->whereHas('pipe', function ($newQ) use($company_id){
            $newQ->whereHas('quoteitems', function($query) use($company_id){
                $query->whereHas('quote', function($q) use ($company_id){
                    $q->whereHas('client', function($que) use($company_id){
                        $que->where('id', $company_id);
                    });
                });
            });
        })->get();
    elseif($state === "exclude")
        $w = $w->whereHas('pipe', function ($newQ) use($company_id){
            $newQ->whereHas('quoteitems', function($query) use($company_id){
                $query->whereHas('quote', function($q) use ($company_id){
                    $q->whereHas('client', function($que) use($company_id){
                        $que->where('id','<>', $company_id);
                    });
                });
            });
        })->get();

    return $w;
}
function getDelCol(){
    #Create Collection Array to hold all the values
    $collectionObj = array();
    #Filter dates to count
    $delievries = \Bt\Sales\Models\Srn::whereBetween('schedule_date',array($data['startdate'], $data['enddate']." 23:59:00"))->orderBy('schedule_date')->get();
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
        $collectionObj[$dateFormat]['Clients'][$delivery->quote->company_name] = $delivery->quote->company_name;

        foreach ($delivery->items as $srn) {
            $collectionObj[$dateFormat]['Weight'] = (isset($collectionObj[$dateFormat]['Weight'])?$collectionObj[$dateFormat]['Weight']: 0) + $srn->stockweight;
        }
    }
}

Route::any('/report/download/{state}/{company_id}/pipes/excel', function ($state, $company_id) {
    $_SESSION['state'] = $state;
    $_SESSION['company_id'] = $company_id;
    return Excel::download(new \Bt\Inventory\Models\MultipleSheetProduction(), 'Production Report.xlsx');
});

Route::any('/report/download/{state}/{company_id}/pipes/scrap/today.pdf', function ($state, $company_id) {
    $mon = array();
    $date = Carbon::now();
    if(isset($_SESSION['enddate'])){
        $this->enddate = $_SESSION['enddate'];
    }else{
        $this->enddate = Carbon::now()->setTime(23, 59, 0);
    }

    if(isset($_SESSION['prostart'])){;
        $this->startdate = $_SESSION['prostart'];
    }else{
        $current = Carbon::now();
        $this->startdate = $current->addDays(-7);
    }
    $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);
    $pipes = ScheduleModel::whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))->where('is_stock', 0)->get();
    $parra= array();
    foreach ($pipes as $v) {
        $parra[$v->pipe_id] = $v->pipe_id;
    }
    $quote = getPipeModel($state, $parra, $data, $company_id);
    $reasons = array();
    $oparatorname = [];
    $monster = [];
    $totals = [];
    //Place Quote Here
    foreach ($quote as $qkey => $qvalue) {
        foreach ($qvalue->schedules as $key => $value) {
            $oparator = "Unkown";
            $oparatorid = 0;
            if(!empty($value->assignedto) && $value->assignedto->name){
                $oparator = $value->assignedto->name;
                $oparatorid = $value->assignedto_id;
            }


            $oparatorname[$oparatorid] = $oparator;
            $date_ = Carbon::parse($value->production_date);
            $d = $date_->format('Y-m-d');

            if(isset($monster[$d]) ){
                if(isset($monster[$d][$oparatorid]) ){

                    $monster[$d][$oparatorid]["total_kg_processed"] += $value->total_kg_processed;
                    $monster[$d][$oparatorid]["weight_scrap_kg"] += $value->weight_scrap_kg;
                }else{
                    $monster[$d][$oparatorid]["total_kg_processed"] = $value->total_kg_processed;
                    $monster[$d][$oparatorid]["weight_scrap_kg"] = $value->weight_scrap_kg;
                }
            }else{
                $monster[$d][$oparatorid]["total_kg_processed"] = $value->total_kg_processed;
                $monster[$d][$oparatorid]["weight_scrap_kg"] = $value->weight_scrap_kg;

            }

            $d = "Totals";
            if(isset($totals[$d]) ){
                if(isset($totals[$d][$oparatorid]) ){

                    $totals[$d][$oparatorid]["total_kg_processed"] += $value->total_kg_processed;
                    $totals[$d][$oparatorid]["weight_scrap_kg"] += $value->weight_scrap_kg;
                }else{
                    $totals[$d][$oparatorid]["total_kg_processed"] = $value->total_kg_processed;
                    $totals[$d][$oparatorid]["weight_scrap_kg"] = $value->weight_scrap_kg;
                }
            }else{
                $totals[$d][$oparatorid]["total_kg_processed"] = $value->total_kg_processed;
                $totals[$d][$oparatorid]["weight_scrap_kg"] = $value->weight_scrap_kg;

            }
            foreach ($value->scrapcodes as $key_ => $value_) {

                if(isset($reasons[$value_->code])){
                    $reasons[$value_->code]['value'] += 1;
                }else{
                    $reasons[$value_->code]['value'] = 1;
                    $reasons[$value_->code]['reason'] = $value_->reason;
                    $reasons[$value_->code]['code'] = $value_->code;
                }
            }
        }
    }
    //Place Deliveries and Collections Here if necessary
    $months = array();
    $startdate = "2023/01/01";
    $w = getScheduleModel($state, $startdate, $this->enddate ." 23:59:00", $company_id);

    $mon = useSchedule($w, $mon);

    foreach ($mon as $sk => $value){
        $months[$value['year'].$value['month']] = (isset($months[$value['year'].$value['month']])?$months[$value['year'].$value['month']]:0) + 1;
    }

    $pdf = PDF::loadView('bt.inventory::pdfproductionscrap',array('quote'=>$quote,'data'=> $data,'reasons'=>$reasons,'monster'=>$monster,'mypeople'=>$oparatorname,'totals'=>$totals, 'scheduleObj'=> $mon, 'months' => $months));
    return $pdf->setPaper('a3', 'landscape')->download('Produced_Pipes_'.$date->format('d-m-Y').'.pdf');

});

Route::post('save-actual-weight/{batchNumber}',   function ($batchNumber)
    {
        $bagBatch = BagBatch::where('batch_number', $batchNumber)->first();
        $bagBatch->actual_weight = post('actual_weight');
        $bagBatch->save();
        return $bagBatch;

    });

Route::any('/rawmaterialreceiving/item/download/{id}', function ($id) {
    $quote = RawMaterialReceiving::with('bagBatches')->find($id);
    $pdf = PDF::loadView('bt.inventory::pdfrawmaterialreceiving',array('quote'=>$quote));
    $name = "BT Material Sticker Batch ".$quote->id;
    return $pdf->setPaper('a4')->download($name.'.pdf');

});