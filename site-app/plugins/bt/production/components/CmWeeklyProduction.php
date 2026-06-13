<?php namespace Bt\Production\Components;

use Bt\Production\Models\Pipe;
use Cms\Classes\ComponentBase;
use Bt\Production\Models\Schedule as ScheduleModel;
use Bt\Production\Models\MaterialUsed as MaterialUsedModel;
use Carbon\Carbon;
use Input;
Use DB;
use Auth;
use Flash;
Use Validator;
use Redirect;
use ValidationException;
use GuzzleHttp\Client;
use Http;
use Mail;
use Config;
use Renatio\DynamicPDF\Classes\PDF;



class CmWeeklyProduction extends ComponentBase
{
    public $monster = array();
    public $startdate;
    public $enddate;
    public $listquote;
    public function componentDetails()
    {
        return [
            'name'        => 'CmWeeklyProduction Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }



     public function onRun(){
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
        $this->getWeeklyMaterial();
         $this->getWeeklyProductionGraph();


          $this->loadAssets();

    }

    public function loadAssets()
    {

        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs('https://code.highcharts.com/highcharts.js');
        $this->addJs('assets/js/formfilter.js', 'Bt.Sales');

    }


    private function getWeeklyProductionGraph(){

//       $w =  ScheduleModel::select(
//            DB::raw("sum(target_kg_processed) as target_kg_processed"),
//            DB::raw("sum(total_kg_processed) as total_kg_processed"),
//            DB::raw("sum(weight_scrap_kg) as weight_scrap_kg"),
//            DB::raw("sum(over_weight_kg) as over_weight_kg"),
//            DB::raw("sum(target_units_produced) as target_units_produced"),
//            DB::raw("sum(total_units_produced) as total_units_produced"),
//            DB::raw("sum(total_units_passed_qc) as total_units_passed_qc"),
//
//            DB::raw("week(production_date,1) as outweek"),
//            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Sunday'), '%x %v %W')  as outyear"))
//        ->whereBetween('production_date', array($this->startdate, $this->enddate." 23:59:00"))
//        ->groupBy("outweek","outyear")
//        ->orderBy("outyear")
//        ->orderBy("outweek")
//        ->get();
//        foreach ($w as $key => $value) {
//            $k =  $value->outweek.$value->outyear;
//            $this->monster[$k]["target_kg_processed"] =  $value->target_kg_processed;
//            $this->monster[$k]["total_kg_processed"] =  $value->total_kg_processed;
//            $this->monster[$k]["total_kg_processed_avg"] =  ((int)$value->total_kg_processed)/7;
//            $this->monster[$k]["weight_scrap_kg"] =  (int)$value->weight_scrap_kg;
//             $this->monster[$k]["over_weight_kg"] =  (int)$value->over_weight_kg;
//
//            $this->monster[$k]["target_units_produced"] =  (int)$value->target_units_produced;
//            $this->monster[$k]["total_units_produced"] =  (int)$value->total_units_produced;
//            $this->monster[$k]["total_units_produced_avg"] =  ((int)$value->total_units_passed_qc)/7;
//            $this->monster[$k]["fail_pipe"] =  (int)$value->total_units_produced - (int)$value->total_units_passed_qc;
//            $this->monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
//         }

        //Using Old way to get total_kg_produced

        $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);
        $pipes = ScheduleModel::whereBetween('production_date', array($this->startdate, $this->enddate." 23:59:00"))->get();
        $parra= array();
        foreach ($pipes as $v) {
            $parra[$v->pipe_id] = $v->pipe_id;
        }

        $quote = Pipe::whereIn('id',$parra)
            ->whereHas('schedules', function ($query) use ($data) {
                $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"));
            })
            ->with(['schedules' => function ($query) use ($data) {
                $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"));
            }])

            ->orderBy('start_date','desc')
            ->get();
        foreach ($quote as $qkey => $qitem) {
            if($qitem->id > 3)
            {
                if ($qitem->qpush->quote->id > 284 )
                {
                    foreach ($qitem->schedules as $schedule)
                    {
                        $w =  ScheduleModel::where('id', $schedule->id)->select(
                            "target_kg_processed",
                            "total_kg_processed",
                            "weight_scrap_kg",
                            "over_weight_kg",
                            "target_units_produced",
                            "total_units_produced",
                            "total_units_passed_qc",

                            DB::raw("week(production_date,1) as outweek"),
                            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(production_date,'%Y'),' ',week(production_date,1),' Sunday'), '%x %v %W')  as outyear"))
                            ->whereBetween('production_date', array($this->startdate, $this->enddate." 23:59:00"))
                            ->groupBy("outweek","outyear")
                            ->orderBy("outyear")
                            ->orderBy("outweek")
                            ->get();
                        $counter = 0;
                        foreach ($w as $key => $value) {
                            $counter++;
                            $k =  $value->outweek.$value->outyear;
                            $this->monster[$k]["numbers"] = (isset($this->monster[$k]["numbers"])? $this->monster[$k]["numbers"]:0) + $counter;
                            $this->monster[$k]["target_kg_processed"] = (isset($this->monster[$k]["target_kg_processed"])? $this->monster[$k]["target_kg_processed"]:0) + $value->target_kg_processed;
                            $this->monster[$k]["total_kg_processed"] =  (isset($this->monster[$k]["total_kg_processed"])? $this->monster[$k]["total_kg_processed"]: 0) + $value->total_kg_processed;
                            $this->monster[$k]["total_kg_processed_avg"] = (isset($this->monster[$k]["total_kg_processed_avg"])? $this->monster[$k]["total_kg_processed_avg"]: 0) + ((int)$value->total_kg_processed);
                            $this->monster[$k]["weight_scrap_kg"] =  (isset($this->monster[$k]["weight_scrap_kg"])? $this->monster[$k]["weight_scrap_kg"]:0) + $value->weight_scrap_kg;
                            $this->monster[$k]["over_weight_kg"] = (isset( $this->monster[$k]["over_weight_kg"])? $this->monster[$k]["over_weight_kg"]:0) + $value->over_weight_kg;

                            $this->monster[$k]["target_units_produced"] =  (isset($this->monster[$k]["target_units_produced"])? $this->monster[$k]["target_units_produced"]:0) + (int)$value->target_units_produced;
                            $this->monster[$k]["total_units_produced"] =  (isset($this->monster[$k]["total_units_produced"])?$this->monster[$k]["total_units_produced"]:0) + (int)$value->total_units_produced;
                            $this->monster[$k]["total_units_produced_avg"] = (isset($this->monster[$k]["total_units_produced_avg"])?$this->monster[$k]["total_units_produced_avg"]:0) + ((int)$value->total_units_passed_qc);
                            $this->monster[$k]["fail_pipe"] = (isset($this->monster[$k]["fail_pipe"])?  $this->monster[$k]["fail_pipe"]:0) + (int)$value->total_units_produced - (int)$value->total_units_passed_qc;
                            $this->monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
                        }
                    }

                }
            }
        }
    }

    private function getWeeklyMaterial(){

        $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);
        $pipes = ScheduleModel::whereBetween('production_date', array($this->startdate, $this->enddate." 23:59:00"))->get();
        $parra= array();
        foreach ($pipes as $v) {
            $parra[$v->pipe_id] = $v->pipe_id;
        }

        $quote = Pipe::whereIn('id',$parra)
            ->whereHas('schedules', function ($query) use ($data) {
                $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"));
            })
            ->with(['schedules' => function ($query) use ($data) {
                $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"));
            }])

            ->orderBy('start_date','desc')
            ->get();
        foreach ($quote as $qkey => $qitem) {
            if ($qitem->id > 3) {
                if ($qitem->qpush->quote->id > 284) {
                    foreach ($qitem->schedules as $schedule) {
                        $w =  MaterialUsedModel::where('schedule_id', $schedule->id)->select(
                            DB::raw("sum(bt_production_material_useds.kg) as kg"),
                            DB::raw("week(bt_production_schedules.production_date,1) as outweek"),
                            DB::raw("STR_TO_DATE(CONCAT(DATE_FORMAT(bt_production_schedules.production_date,'%Y'),' ',week(bt_production_schedules.production_date,1),' Sunday'), '%x %v %W')  as outyear"))
                            ->join('bt_production_schedules', 'bt_production_schedules.id', '=', 'bt_production_material_useds.schedule_id')
                            ->whereBetween('bt_production_schedules.production_date', array($this->startdate, $this->enddate." 23:59:00"))
                            ->groupBy("outweek","outyear")
                            ->orderBy("outyear")
                            ->orderBy("outweek")
                            ->get();

                        foreach ($w as $key => $value) {
                            $k =  $value->outweek.$value->outyear;
                            $this->monster[$k]["used_kg"] = (isset($this->monster[$k]["used_kg"])? $this->monster[$k]["used_kg"]:0) + $value->kg;

                            $this->monster[$k]["name"] =  "Wk ".$value->outweek."/".$value->outyear;
                        }
                    }
                }
            }
        }

    }



}
