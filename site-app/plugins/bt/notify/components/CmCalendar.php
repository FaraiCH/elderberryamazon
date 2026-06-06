<?php namespace Bt\Notify\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Sales\Models\DeliveryPlan as DeliveryPlanModel;
use Bt\Maintenance\Models\Schedule as ScheduleMaintenanceModel;
use Bt\Production\Models\Schedule as ProductionScheduleModel;
use Bt\Sales\Models\Srn as SRNModel;


class CmCalendar extends ComponentBase
{
    public $events = array();
    public $item;
    public function componentDetails()
    {
        return [
            'name'        => 'CmCalendar Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'item' => [
                'title'       => 'Business Item',
                'description' => 'Slug for business item',
                'default'     => '{{ :item }}',
                'type'        => 'string'
            ]
        ];
    }

    public function OnRun(){
        $this->item = $this->property('item');
        if($this->property('item') < 4 ){
            $this->GetPipeSchudels($this->item);
            $this->GetProductionSchudels($this->item);
        }
        
        if($this->property('item') == 4 ){
            $this->GetDeliverSchudels();
            $this->GetSRNSchudels();
        }
        if($this->property('item') == 5 ){
            $this->GetScheduleMaintenance();
        }
    }

    private function GetPipeSchudels($pipeid){
        $obj = PipeModel::where("line_id",$pipeid)->get();
        foreach ($obj as $key => $value) {
            $color = '#c1c50e';
            if($value->btline->id == 2){
                $color = '#c1c50e';
            }
            if($value->btline->id == 1){
                $color = '#e06bc7';
            }
            if($value->btline->id == 3){
                $color = '#4497e0';
            }
            $desc = $value->qpush->quote->company_name." : ".$value->quoteitems->description." (Project Start: ".$value->start_date.", End: ".$value->due_date.")".", Production Id: ".$value->qpush->id.". Running on ".$value->btline->name;
            // $desc = $value->btline->name." : ".$value->qpush->quote->company_name." : ".$value->quoteitems->description." (Project Start: ".$value->start_date.",End: ".$value->due_date.")";
            $this->events[] =  array('title' => $desc, 'start'=> $value->start_date,'end'=> $value->due_date,'color'=>$color );
        }
    }

    private function GetDeliverSchudels(){
        $obj = DeliveryPlanModel::all();
        foreach ($obj as $key => $value) {
            $desc = $value->type->name." : ".$value->client->company_name." : ". $value->invoice->name;
            $this->events[] =  array('title' => $desc, 'start'=> $value->schedule_date,'color'=>'#ff9f89' );
        }
    }
    private function GetSRNSchudels(){
        $obj = SRNModel::all();
        foreach ($obj as $key => $value) {
            $desc = (($value->type)?$value->type->name:"")." : ".(($value->client)?$value->client->company_name:"")." : "."(".(($value->items)?$value->items->sum("units"):"0")." Pipes)";
            $this->events[] =  array('title' => $desc, 'start'=> $value->schedule_date,'color'=>'#ea3f17' );
        }
    }
    

    private function GetScheduleMaintenance(){
        $obj = ScheduleMaintenanceModel::all();
        foreach ($obj as $key => $value) {
            $desc = $value->btline->name." : ".$value->actiontype->name." : ". $value->job_summary;
            $this->events[] =  array('title' => $desc, 'start'=> $value->scheduledate,'color'=>'#ffb811' );
        }
    }

    private function GetProductionSchudels($pipeid){
        $obj = ProductionScheduleModel::active()->with(['pipe' => function ($query) use ($pipeid) {
            $query->where('line_id', $pipeid);
            }])->get();
        //dd($obj);

        foreach ($obj as $key => $value) {
            $color = '#009a7f';
            // if($value->pipe->btline->id == 2){
            //     $color = '#a00a7f';
            // }
            // if($value->pipe->btline->id == 3){
            //     $color = '#4497e0';
            // }
            if(!empty($value->pipe) && !empty($value->pipe->quoteitems) ){
                $desc = " Day ".$value->production_days.": ".$value->pipe->qpush->quote->company_name." : ".$value->pipe->quoteitems->description." (Target Units: ".$value->target_units_produced.", Unit Produced: ".$value->total_units_produced.", Scrap: ".$value->weight_scrap_kg." kg). Running on ".$value->pipe->btline->name.". Quote Number: ".$value->pipe->qpush->quote->id;
                $this->events[] =  array('title' => $desc,'title' => $desc, 'start'=> $value->production_date,'color'=>$color );
            }
        }
    }


    


}
