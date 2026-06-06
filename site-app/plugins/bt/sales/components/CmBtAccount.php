<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;
use Bt\Floor\Models\Scrappipe as ScrappipeModel;
use Bt\Floor\Models\Stockpipe as StockpipeModel;
use Bt\Production\Models\Pipe as PipeModel;
use Carbon\Carbon;
use Auth;
use Flash;
use Input;
Use Validator;
use Redirect;
use ValidationException;
use GuzzleHttp\Client;
use Http;
use Mail;
use Config;
use Renatio\DynamicPDF\Classes\PDF;
use DB;

class CmBtAccount extends ComponentBase
{
    public $startdate;
    public $enddate;

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
        //dd($this->loadPipes());
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
            $this->startdate = $current->addDays(-30);
        }

        $this->loadAssets();


    }

     public function loadAssets()
    {
        
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs('assets/js/formfilter.js', 'Bt.Sales');

    }


    public function producedPipes(){
        // if(Input::has('enddate')){
        //     $this->enddate = Input::get('enddate');
        // }else{
        //     $this->enddate = Carbon::now();
        // }

        // if(Input::has('startdate')){
        //     $this->startdate = Input::get('startdate');
        // }else{
        //     $current = Carbon::now();
        //     $this->startdate = $current->addDays(-7);
        // }

        $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);

       return  PipeModel::active()
            
            ->orderBy('start_date','desc')
            ->get();
        // foreach ($obj as $key => $value) {
        //     //dd($value->schedules()->sum('total_units_passed_qc'));
        // }
    
        
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
}
