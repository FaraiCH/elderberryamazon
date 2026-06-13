<?php namespace Bt\Production\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Schedule as ScheduleModel;

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

class RunningScheduleGraphs extends ComponentBase
{
    public $startdate;
    public $enddate;

    public function componentDetails()
    {
        return [
            'name'        => 'RunningScheduleGraphs Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onRun(){
        //dd($this->getWeeklyProductionGraphPipes());
        //getWeeklyProductionGraphPipes
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

        $this->addJs('https://code.highcharts.com/highcharts.js');
    }
    public function getWeeklyProductionGraph(){
       $w =  ScheduleModel::select(
            DB::raw("sum(target_kg_processed) as x"),
            DB::raw("sum(total_kg_processed) as y"),
            DB::raw("sum(weight_scrap_kg) as z"),
            DB::raw("week(production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Sunday'), '%x %v %W')  as outyear"))
        //->where("scheduled",1)
       ->whereBetween('production_date', array($this->startdate, $this->enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
        ->orderBy("outyear")
        ->orderBy("outweek")
        ->get();

        $target_kg_processed = array();
        $total_kg_processed = array();
        $total_kg_processed_avg = array();
        $weight_scrap_kg = array();

        foreach ($w as $key => $value) {
            $target_kg_processed[] =  (int)$value->x;
            $total_kg_processed[] =  (int)$value->y;
            $total_kg_processed_avg[] =  ((int)$value->y)/7;
            $weight_scrap_kg[] =  (int)$value->z;
         }



         $monster  =  array();
         $name  =  array();
         foreach ($w as $key => $value) {
             $name[] = "Wk ".$value->outweek."/".$value->outyear;
         }

        $monster[] =  array('name' => 'Target', 'data'=> $target_kg_processed );
        $monster[] =  array('name' => 'Total Processed', 'data'=> $total_kg_processed );
        $monster[] =  array('name' => 'Weight Scrap', 'data'=> $weight_scrap_kg );
        $monster[] =  array('name' => 'Total Processed AVG', 'data'=> $total_kg_processed_avg );
       return  array('name' =>$name, 'data' =>$monster  );;
    }

    public function getWeeklyProductionGraphPipes(){
       $w =  ScheduleModel::select(
            DB::raw("sum(target_units_produced) as x"),
            DB::raw("sum(total_units_produced) as y"),
            DB::raw("sum(total_units_passed_qc) as z"),
            DB::raw("week(production_date,1) as outweek"),
            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Sunday'), '%x %v %W')  as outyear"))
        //->where("scheduled",1)
       ->whereBetween('production_date', array($this->startdate, $this->enddate." 23:59:00"))
        ->groupBy("outweek","outyear")
        ->orderBy("outyear")
        ->orderBy("outweek")
        ->get();

        $target_units_produced = array();
        $total_kg_processed = array();
        $total_kg_processed_avg = array();
        $weight_scrap_kg = array();
        $fail_pipe = array();

        foreach ($w as $key => $value) {
            $target_units_produced[] =  (int)$value->x;
            $total_kg_processed[] =  (int)$value->y;
            $total_kg_processed_avg[] =  ((int)$value->z)/7;
            $weight_scrap_kg[] =  (int)$value->z;
            $fail_pipe[] =  (int)$value->y - (int)$value->z;
         }



         $monster  =  array();
         $name  =  array();
         foreach ($w as $key => $value) {
             $name[] = "Wk ".$value->outweek."/".$value->outyear;
         }

        $monster[] =  array('name' => 'Target', 'data'=> $target_units_produced );
        $monster[] =  array('name' => 'Total Produced', 'data'=> $total_kg_processed );
        $monster[] =  array('name' => 'Total Passed QC', 'data'=> $weight_scrap_kg );
        $monster[] =  array('name' => 'Total Passed QC AVG', 'data'=> $total_kg_processed_avg );
        $monster[] =  array('name' => 'Failed Pipes', 'data'=> $fail_pipe );
       return  array('name' =>$name, 'data' =>$monster  );;
    }


}
