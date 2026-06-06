<?php namespace Bt\Production\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Push as PushModel;
use Carbon\Carbon;
use Input;
Use DB;

class Summary extends ComponentBase
{
    public $startdate;
    public $enddate;
    public $listquote;
    public function componentDetails()
    {
        return [
            'name'        => 'Summary Component',
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
        
        
         $this->listquote = PushModel::whereBetween('created_at', array($this->startdate, $this->enddate." 23:59:00"))
         ->get();
        
          $this->loadAssets();
        
    }

      public function loadAssets()
    {
        
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs('assets/js/formfilter.js', 'Bt.Sales');

    }


}
