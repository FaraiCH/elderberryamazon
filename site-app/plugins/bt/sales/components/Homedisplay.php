<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;

use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Production\Models\Schedule as ScheduleModule;
use Bt\Floor\Models\DeliveryScrapPipe as DeliveryScrapPipeModule;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceivingModel;
use Bt\Production\Models\MaterialUsed as MaterialUsed;
use Bt\Sales\Models\SrnItem as SrnItemModel;
use Bt\Floor\Models\Scrappipe as ScrapPipeModel;
use Carbon\Carbon;
use DB;

class Homedisplay extends ComponentBase
{
    public $totaldisplay;
    public $totalfillorscrap;
    public $totalusedweight;
    public $totalfloorpipes;
    public $totalweightbought;
    public $totalregringused;
    public $totalscrap;
    public $totalincage;
    public $manualscrap;
    public function componentDetails()
    {
        return [
            'name'        => 'homedisplay Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        
        $current = Carbon::now();
        $startdate = $current->addDays(-7);
        $enddate = Carbon::now();

        $total = ModelNewquote::select(
            DB::raw("SUM(totalincvat) as totaldisplay"))
        ->active()
        ->whereBetween('bt_sales_newquote.created_at', array($startdate, $enddate." 23:59:00"))
        
        ->GroupBy("quote_status_id")        
        ->first();
        
        if(!empty($total))
        $this->totaldisplay = $total->totaldisplay;

        $obj = ScheduleModule::active()->get();
        $del_obj = DeliveryScrapPipeModule::all();
        $del_pipes = SrnItemModel::all();
        $manual_scrap = ScrapPipeModel::all();
        
        $this->totalfillorscrap = ($obj->sum('weight_scrap_kg') + $manual_scrap->sum('weight_kg')) - $del_obj->sum('weight_kg');
        
        $this->totalscrap = $obj->sum('weight_scrap_kg');
        $this->manualscrap = $manual_scrap->sum('weight_kg');

        $this->totalfloorpipes = $obj->sum('total_units_passed_qc') - $del_pipes->sum('units');

       // $this->totalusedweight = $obj->sum('total_kg_processed');

        



        $rawM = RawMaterialReceivingModel::notregrind()->where('date_of_receipt', '>=', date('2020-01-01 00:00:00'))->get();
        $this->totalweightbought = $rawM->sum('weight');
        foreach ($rawM as $v) {
            # code...
            $this->totalusedweight = $this->totalusedweight + $v->used->sum('kg');
        }
         
       
        $usedregringOb = RawMaterialReceivingModel::regrind()->with('used')->get();
        foreach ($usedregringOb as $key => $value) {
           $this->totalregringused += $value->used->sum('kg');
        }

        $incageOb = RawMaterialReceivingModel::get();
        foreach ($incageOb as $key => $value) {
            $incage = 0;
            foreach ($value->incage as $k => $v) {
                $incage = $v->kg;
            }
            $this->totalincage +=$incage; 
        }

        // dd($usedregringOb);

        // $usedregringOb = MaterialUsed::get();
        // dd($usedregringOb);
      
         //$this->totalregringused = $usedregringOb->used->sum('kg');
    }

}
