<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Inventory\Models\PartNames;
use Bt\Production\Models\Materials;
use Bt\Production\Models\Line as LineModel;
use Bt\Production\Models\Schedule as ScheduleModel;
use Carbon\Carbon;

/**
 * Line Back-end Controller
 */
class Line extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Production', 'production', 'line');
    }

     public function Plantstats(){
        $this->pageTitle = "Plant Utilisation Stats";

        $schedules = ScheduleModel::where('production_date','>','2019-12-31 23:59:59')->orderBy('production_date')->get();
        $data = array();

        $caplines = LineModel::all();
        $cap = $caplines->sum("capacity") * 24 * 30;
        $total  = 0;

        foreach ($schedules as $skey => $schedule) {
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

         foreach ($schedules as $skey => $schedule) {
            $line = $schedule->pipe->btline->name;
            $createdAt = Carbon::parse($schedule->production_date);
            $datetri = "01-".$createdAt->format('m-Y');
            $test =  Carbon::parse($datetri)->timestamp;
            $date_ =  $datetri;
            
           
            $line = "TOTAL";
            if(isset($data[$line]) && isset($data[$line][$date_]) ){
                $data[$line][$date_] = $data[$line][$date_]+$schedule->usedmaterials->sum("kg");
            }else{
                $data[$line][$date_] = $schedule->usedmaterials->sum("kg");
            }

            $total += $schedule->usedmaterials->sum("kg"); 

            $line = "MAX CAPACITY";
            
            $data[$line][$date_] = $cap;

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
        $this->vars['stats'] = $stats;
        $this->vars['capacity'] = $cap;
        $this->vars['avarage'] = (int)($total/count($data["TOTAL"]));
     }
}
