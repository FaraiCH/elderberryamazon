<?php namespace Bt\Floor\Components;

use Bt\Production\Models\Pipestickeritem;
use Cms\Classes\ComponentBase;
use Bt\Floor\Models\Scrappipe as ScrappipeModel;
use Bt\Floor\Models\Stockpipe as StockpipeModel;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Production\Models\Schedule as ScheduleModel;
use Bt\Sales\Models\Client as ClientModel;
use Carbon\Carbon;
use Auth;
use Flash;
use Input;
Use Validator;
use Redirect;
use Session;
use ValidationException;
use GuzzleHttp\Client;
use Http;
use Mail;
use Config;
use Renatio\DynamicPDF\Classes\PDF;
use DB;

class FloorGraph extends ComponentBase
{
    public $startdate;
    public $enddate;
    public $company_name;

    public function componentDetails()
    {
        return [
            'name'        => 'FloorGraph Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        //dd($this->ScrapGraph());
        //dd($this->producedPipes());
        if(Input::has('enddate')){
            $this->enddate = Input::get('enddate');
        }else{
            $this->enddate = Carbon::now();
        }

        if(Input::has('startdate')){
            $this->startdate = Input::get('startdate');
        }else{
            $current = Carbon::now();
            $this->startdate = $current->subDays(30)->toDateString();
        }

        $this->loadAssets();
        $this->page['company_id'] = 0;
        if(Input::get('company_only') != 0 && Input::get('company_exclude') != 0){
            $this->page['state'] = "error";
        }else{
            if(Input::get('company_only') != 0){
                $this->page['state'] = "only";
                $this->page['company_id_on'] = Input::get('company_only');
            } elseif(Input::get('company_exclude') != 0){
                $this->page['state'] = "exclude";
                $this->page['company_id_ex'] = Input::get('company_exclude');
            }else{
                $this->page['state'] = "standard";

            }
        }

    }

    public function loadAssets()
    {

        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs('https://code.highcharts.com/highcharts.js');
        $this->addJs('/plugins/bt/floor/assets/js/formfilter.js');

    }

    public function getClient(){
        return ClientModel::all();
    }

    public function producedPipes(){
        if(Input::has('enddate')){
            $this->enddate = Input::get('enddate');
        }else{
            $this->enddate = Carbon::now();
        }

        if(Input::has('startdate')){
            $this->startdate = Input::get('startdate');
        }else{
            $current = Carbon::now();
            $this->startdate = $current->subDays(7)->toDateString();
        }
        Session::put('prostart', $this->startdate);
        Session::put('enddate', $this->enddate);

        $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);

        $parra = ScheduleModel::whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))
            ->where('is_stock', 0)
            ->whereNotNull('pipe_id')
            ->distinct()
            ->pluck('pipe_id')
            ->toArray();

        if (empty($parra)) {
            return collect();
        }

        $mycompany = Input::get('company_only') ?: Input::get('company_exclude');

        $produced =  PipeModel::whereIn('id',$parra)
             ->whereHas('schedules', function ($query) use ($data) {
                 $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"));
             })
             ->with(['schedules' => function ($query) use ($data) {
                 $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))
                       ->with('usedmaterials', 'assignedto', 'scrapcodes');
             }, 'quoteitems.quote.client', 'qpush.status', 'delivered'])
            ->orderBy('start_date','desc')
            ->limit(50);

        if(Input::get('company_only') != 0 && Input::get('company_exclude') != 0){
            $produced = $produced->get();
            $this->page['state'] = "error";
        }else{
            if(Input::get('company_only') != 0){
                $produced = $produced->whereHas('quoteitems.quote.client', function($query) use($mycompany){
                    $query->where('id', $mycompany);
                })->get();
            } elseif(Input::get('company_exclude') != 0){
                $produced = $produced->whereHas('quoteitems.quote.client', function($query) use($mycompany){
                    $query->where('id', '<>', $mycompany);
                })->get();
            } else {
                $produced = $produced->get();
            }
        }

        return $produced;
    }
    public function loadPipes(){
        $list =  StockpipeModel::select(DB::raw("quantity as y"),DB::raw("datestored as outdate"),"name")->get();
       #$list2 =  StockpipeModel::select(DB::raw("weight_kg as y"),DB::raw("datestored as outdate"),DB::raw("'Floor Pipes' as name"))->get();
        $tempArray =  array();

        foreach ($list as $key => $value) {
            $dates = strtotime($value->outdate)*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
            $tempArray[$value->name]['data'][] = array($dates,floatval($value->y));
            $tempArray[$value->name]['name'] = $value->name;
        }
        // foreach ($list2 as $key => $value) {
        //     #$dates = strtotime(date('Y-m-d H:00',strtotime($value->outdate)))*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
        //      $dates = strtotime($value->outdate)*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
        //     $tempArray[$value->name]['data'][] = array($dates,floatval($value->y));
        //     $tempArray[$value->name]['name'] = $value->name;
        // }

        $monster  =  array();
        foreach ($tempArray as $key => $value) {
            $monster[] =  array('name' => $key, 'data'=> $value['data'] );
        }

        return json_encode($monster);

    }

    public function ScrapGraph(){
        if(Input::has('enddate')){
            $this->enddate = Input::get('enddate');
        }else{
            $this->enddate = Carbon::now();
        }

        if(Input::has('startdate')){
            $this->startdate = Input::get('startdate');
        }else{
            $current = Carbon::now();
            $this->startdate = $current->subDays(7)->toDateString();
        }


        $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);

        $parra = ScheduleModel::whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))
            ->whereNotNull('pipe_id')
            ->distinct()
            ->pluck('pipe_id')
            ->toArray();

        if (empty($parra)) {
            return json_encode([]);
        }

        $quote = PipeModel::whereIn('id',$parra)
                ->with(['schedules' => function ($query) use ($data) {
                $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))
                      ->where('weight_scrap_kg', '>', 0)
                      ->with('scrapcodes');
            }])
            ->orderBy('start_date','desc')
            ->limit(50)
            ->get();
            $tempArray =  array();
        foreach ($quote as $qkey => $qvalue) {
            foreach ($qvalue->schedules as $key => $value) {
                if($value->weight_scrap_kg > 0){
                      foreach ($value->scrapcodes as $key_ => $value_) {

                        $dates = strtotime($value->production_date)*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
                        $tempArray[$value_->code." - ".$value_->reason]['data'][] = array($dates,floatval($value->weight_scrap_kg));
                        $tempArray[$value_->code." - ".$value_->reason]['name'] = $value_->code." - ".$value_->reason;

                        // if(isset($reasons[$value_->code])){
                        //     $reasons[$value_->code]['value'] += 1;
                        // }else{
                        //     $reasons[$value_->code]['value'] = 1;
                        //     $reasons[$value_->code]['reason'] = $value_->reason;
                        //     $reasons[$value_->code]['code'] = $value_->code;
                        // }
                      }
                }
            }
          }

          $monster  =  array();
        foreach ($tempArray as $key => $value) {
            $monster[] =  array('name' => $key, 'data'=> $value['data'] );
        }

        return json_encode($monster);

        // foreach ($obj as $key => $value) {
        //     //dd($value->schedules()->sum('total_units_passed_qc'));
        // }


    }

    public function OparatorGraph(){
        if(Input::has('enddate')){
            $this->enddate = Input::get('enddate');
        }else{
            $this->enddate = Carbon::now();
        }

        if(Input::has('startdate')){
            $this->startdate = Input::get('startdate');
        }else{
            $current = Carbon::now();
            $this->startdate = $current->subDays(7)->toDateString();
        }

        $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);

        $parra = ScheduleModel::whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))
            ->whereNotNull('pipe_id')
            ->distinct()
            ->pluck('pipe_id')
            ->toArray();

        if (empty($parra)) {
            return json_encode([]);
        }

        $quote = PipeModel::whereIn('id', $parra)
            ->with(['schedules' => function ($query) use ($data) {
                $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))
                      ->where('weight_scrap_kg', '>', 0)
                      ->with('assignedto');
            }])
            ->orderBy('start_date','desc')
            ->limit(50)
            ->get();

        if ($quote->isEmpty()) {
            return json_encode([]);
        }

        $tempArray =  array();
        foreach ($quote as $qkey => $qvalue) {
            foreach ($qvalue->schedules as $key => $value) {
                if($value->weight_scrap_kg > 0){

                    $oparator = "Unknown";
                    if(!empty($value->assignedto) && isset($value->assignedto->name))
                         $oparator = $value->assignedto->name;


                    $dates = strtotime($value->production_date)*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
                    $tempArray[$oparator]['data'][] = array($dates,floatval($value->weight_scrap_kg));
                    $tempArray[$oparator]['name'] = $oparator;

                }
            }
          }

          $monster  =  array();
        foreach ($tempArray as $key => $value) {
            $monster[] =  array('name' => $key, 'data'=> $value['data'] );
        }

        return json_encode($monster);

        // foreach ($obj as $key => $value) {
        //     //dd($value->schedules()->sum('total_units_passed_qc'));
        // }


    }

    public function stickerPipes()
    {
        $stickerObj = Pipestickeritem::with(['controlsheets.jobcard.pipe.quoteitems', 'product' => function ($query) {
            $query->with('Diameter', 'PNRating');
        }])
        ->where('sticker_scanned_date', '>', '2024-03-01 00:00:00')
            ->where('is_active', 1)
        ->orderBy('sticker_id', 'Desc')
        ->orderBy('counter', 'Desc')
        ->get();
        return $stickerObj;
    }
}
