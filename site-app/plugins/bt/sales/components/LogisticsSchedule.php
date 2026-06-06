<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;
use Bt\Sales\Models\DeliveryPlan as DeliverPlanModel;
use Carbon\Carbon;

/**
 * LogisticsSchedule Component
 */
class LogisticsSchedule extends ComponentBase
{   

    public $delivery = "";
    public function componentDetails()
    {
        return [
            'name' => 'LogisticsSchedule Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $now = Carbon::now();
        $this->delivery = DeliverPlanModel::where('schedule_date', '>=', $now)->get();
        
    }
}
