<?php namespace Bt\Maintenance\Components;

use Cms\Classes\ComponentBase;
use Bt\Maintenance\Models\JobCard as ModelJobCard;
use Bt\Maintenance\Models\Status as MaintenanceStatus;
use Carbon\Carbon;
use Input;
Use DB;
class CmJobCard extends ComponentBase
{
    public $formstatus;
    public $startdate;
    public $enddate;
    public $listquote;

    public function componentDetails()
    {
        return [
            'name'        => 'CmJobCard Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function getList(){
        return ModelJobCard::all();
    }

     public function onRun(){
        if(Input::has('enddate')){
            $this->enddate = Input::get('enddate');
        }else{
           # $this->enddate = Carbon::now();
            $current = Carbon::now();
            $this->enddate = $current->addDays(10);
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
            $this->listquote = ModelJobCard::whereBetween('opendate', array($this->startdate, $this->enddate." 23:59:00"))
            ->where('status_id',$this->formstatus)
             ->get();
        }else{
           
             $this->listquote = ModelJobCard::whereBetween('opendate', array($this->startdate, $this->enddate." 23:59:00"))
             ->get();
        }

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
