<?php namespace Bt\Production\Components;


use Bt\Production\Models\ControlSheet;
use Cms\Classes\ComponentBase;
use Input;
use Carbon\Carbon;
use Bt\Production\Models\Schedule as ScheduleModel;

class Schedule extends ComponentBase
{
    public $startdate;
    public $enddate;
    public $listquote;
    public $dtimer;

    public function componentDetails()
    {
        return [
            'name'        => 'Schedule Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){

        $this->dtimer = 0;
        $current = Carbon::now();
        $this->enddate = $current;
        $current = Carbon::now()->subDays(1);
        $this->startdate = $current;


         $this->listquote = ControlSheet::with(['citem', 'btline', 'jobcard.pipe'])->whereBetween('opendate', array($this->startdate, $this->enddate." 23:59:00"))
         ->orderBy('opendate', 'ASC')->get();

        foreach ($this->listquote as $mine)
        {
            if(!empty($mine->opendate))
            {
                $this->dtimer++;
            }
        }

    }
}
