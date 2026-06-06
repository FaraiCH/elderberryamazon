<?php namespace Bt\Production\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Schedule as ScheduleModel;
class DayToDayScrap extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'DayToDayScrap Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function loadList(){
        return ScheduleModel::active()->orderby('production_date','asc')->get();
    }

    public function ScrapGraph(){
      

        $quote = ScheduleModel::active()->orderby('production_date','asc')->get();
        $tempArray =  array();
        foreach ($quote as $key => $value) {           
            if($value->weight_scrap_kg > 0){
                  foreach ($value->scrapcodes as $key_ => $value_) {
                    
                    $dates = strtotime($value->production_date)*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
                    $tempArray[$value_->code." - ".$value_->reason]['data'][] = array($dates,floatval($value->weight_scrap_kg));
                    $tempArray[$value_->code." - ".$value_->reason]['name'] = $value_->code." - ".$value_->reason;

                    // if(isset($reasons[$value_->code])){
                    //     $reasons[$value_->code]['value'] += 1;
                    // }else{
                    //     $reasons[$value_->code]['value'] = 1;
                    //     $reasons[$value_->code]['reason'] = $value_->reason; 
                    //     $reasons[$value_->code]['code'] = $value_->code; 
                    // }
                  }
            }
            
        }

          $monster  =  array();
        foreach ($tempArray as $key => $value) {
            $monster[] =  array('name' => $key, 'data'=> $value['data'] );
        }

        return json_encode($monster);

        // foreach ($obj as $key => $value) {
        //     //dd($value->schedules()->sum('total_units_passed_qc'));
        // }
    
        
    }

    public function OparatorGraph(){
        $quote = ScheduleModel::active()->orderby('production_date','asc')->get();
        $tempArray =  array();
        foreach ($quote as $key => $value) {
                if($value->weight_scrap_kg > 0){
                    $oparator = "Unkown";
                    if(!empty($value->assignedto) && $value->assignedto->name)
                         $oparator = $value->assignedto->name;
                     
                        
                    $dates = strtotime($value->production_date)*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
                    $tempArray[$oparator]['data'][] = array($dates,floatval($value->weight_scrap_kg));
                    $tempArray[$oparator]['name'] = $oparator;

                }
            
          }

          $monster  =  array();
        foreach ($tempArray as $key => $value) {
            $monster[] =  array('name' => $key, 'data'=> $value['data'] );
        }

        return json_encode($monster);
        
        // foreach ($obj as $key => $value) {
        //     //dd($value->schedules()->sum('total_units_passed_qc'));
        // }
    
        
    }
}
