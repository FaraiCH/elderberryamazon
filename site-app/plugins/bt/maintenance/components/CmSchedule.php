<?php namespace Bt\Maintenance\Components;

use Cms\Classes\ComponentBase;
use Bt\Maintenance\Models\Schedule as ModelSchedule;
use Bt\Maintenance\Models\Status as MaintenanceStatus;
use Carbon\Carbon;
use Input;
Use DB;
class CmSchedule extends ComponentBase
{
    public $formstatus;
    public $startdate;
    public $enddate;
    public $listquote;
    public $dtimer;
    public function componentDetails()
    {
        return [
            'name'        => 'CmSchedule Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'isdashboard' => [
                 'title'             => 'Is Dashboard',
                 'description'       => 'Is Dashboard',
                 'default'           => "No",
                 'type'              => 'dropdown',
                 'options'     => ['No'=>'No', 'Yes'=>'Yes']
            ]
        ];
    }

    public function onRun(){

        $this->dtimer = 0;
        if(Input::has('enddate')){
            $this->enddate = Input::get('enddate');
        }else{
           # $this->enddate = Carbon::now();
            $current = Carbon::now();
            $this->enddate = $current->addDays(20);
        }

        if(Input::has('startdate')){
            $this->startdate = Input::get('startdate');
        }else{
            $current = Carbon::now();
            $this->startdate = $current->addDays(-1);
        }

        if(Input::has('showstatus')){
            $this->formstatus = Input::get('showstatus');
        }else{
            $this->formstatus = 0;
        }
        $this->loadAssets();

        if($this->formstatus > 0 ){
            $this->listquote = ModelSchedule::whereBetween('scheduledate', array($this->startdate, $this->enddate." 23:59:00"))
            ->where('status_id',$this->formstatus)
             ->get();
        }else{

             $this->listquote = ModelSchedule::whereBetween('scheduledate', array($this->startdate, $this->enddate." 23:59:00"))
             ->get();
        }

        foreach ($this->listquote as $mine)
        {
            if(!empty($mine->scheduledate))
            {
                $this->dtimer++;
            }
        }
    }

    public function getList(){
        return ModelSchedule::all();
    }

    public function loadStatus(){
        return MaintenanceStatus::all();
    }
    public function loadAssets()
    {
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs('assets/js/formfilter.js', 'Bt.Maintenance');
    }
}
