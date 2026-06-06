<?php namespace Bt\SHEQ\Components;

use Cms\Classes\ComponentBase;
use Bt\SHEQ\Models\Injuries as InjuriesModel;
use Bt\SHEQ\Models\CovidScreens as CovidScreensModel;
use DB;

class CmCovid extends ComponentBase
{
    public $data_inj;
    public $data_covid;
    public $total_screening;
    public $total_temp;
    public  $injurytype = array(1 => 'Minor', 2 => 'Moderate', 3=>'Serious');

    public function componentDetails()
    {
        return [
            'name'        => 'CmCovid Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onRun(){
        $this->data_inj = InjuriesModel::select(DB::raw("count(scale_of_injury) as noinjuries"),"scale_of_injury")
        ->groupBy("scale_of_injury")
        ->get();
        $this->data_covid = $this->getCovid();
     }

    public function getCovid(){
       $w =  CovidScreensModel::orderBy('capturedate', 'ASC')->get();

        $no_screen = array();
        $potential_infection = array();
        $no_infected = array();
        $highest_temperature = array();

        foreach ($w as $key => $value) {
            $no_screen[] =  (int)$value->no_screen;
            $this->total_screening = $this->total_screening + (int)$value->no_screen;
            $this->total_temp = $this->total_temp + (int)$value->potential_infection;
            $potential_infection[] =  (int)$value->potential_infection;
            $no_infected[] =  (int)$value->no_infected;
            $highest_temperature[] =  (int)$value->highest_temperature;
         }



         $monster  =  array();
         $name  =  array();
         foreach ($w as $key => $value) {
            $dates = strtotime($value->capturedate);
             $name[] =date("d/m/Y", $dates);
         }

        $monster[] =  array('name' => 'Screenings', 'data'=> $no_screen );
        $monster[] =  array('name' => 'Potential Infection/Risks', 'data'=> $potential_infection );
        #$monster[] =  array('name' => 'no_infected', 'data'=> $no_infected );
        $monster[] =  array('name' => 'Highest Temperature Reading in Celsius;', 'data'=> $highest_temperature );
        
       return  array('name' =>$name, 'data' =>$monster  );;
    }
}
