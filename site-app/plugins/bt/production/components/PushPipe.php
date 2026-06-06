<?php namespace Bt\Production\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Inventory\Models\PartNames;
use Bt\Production\Models\Materials;
use Bt\Production\Models\Line as LineModel;
use Bt\Production\Models\Schedule as ScheduleModel;
use Carbon\Carbon;

use Auth;
use Flash;
use Input;
Use Validator;
use Redirect;
use ValidationException;
use Http;
use Config;


class PushPipe extends ComponentBase
{
    public $pipe;
    public function componentDetails()
    {
        return [
            'name'        => 'PushPipe Component',
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
            ],'pipe' => [
                'title'       => 'Business Item',
                'description' => 'Slug for business item',
                'default'     => '{{ :pipe }}',
                'type'        => 'string'
            ]
        ];
    }

     public function onRun(){
        if($this->property('item') > 0  && $this->property('pipe') > 0){
            $this->pipe = PipeModel::find($this->property('pipe'));
            //dd($this->pipe);
        }
         $this->loadAssets();
       
    }
     public function loadAssets()
    {
        
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs('assets/js/formfilter.js', 'Bt.Production');

    }
    public function loadPartNames(){
        return PartNames::all();
    }
    public function loadProductionLines(){
        return LineModel::all();
    }

    

    public function onSaveMaterial(){      

        $user = Auth::getUser();
            $validator = Validator::make(
                [
                    'part_name_id' =>  Input::get('part_name_id'),
                    'mixratio' =>  Input::get('mixratio')
                ],
                [
                    'part_name_id' => 'required',
                    'mixratio' => 'required'
                ]
            );
        

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

              
       
        if($user->id > 0){
            $pipe = PipeModel::find($this->property('pipe'));
         
            $mt = new Materials();
            $mt->user_id = $user->id;
            $mt->pipe_id = $pipe->id;
            $mt->part_name_id =  Input::get('part_name_id');
            $mt->mixratio =  Input::get('mixratio');
            $mt->save();
            
            if(!empty($mt) && $mt->id > 0){
                $i =  PipeModel::find($this->property('pipe'));
                $this->page['response'] = $i->materials;
                Flash::success("New qoute saved");
                return;
            }else{
              Flash::error("Error: Could not save email...");
              return;   
            }

        }else{
              Flash::error("Use need ...");
              return; 
        }
    }

    public function onSaveProductionDetails(){      

        $user = Auth::getUser();
            $validator = Validator::make(
                [
                    'start_date' =>  Input::get('start_date'),
                    'due_date' =>  Input::get('due_date')
                ],
                [
                    'start_date' => 'required',
                    'due_date' => 'required'
                ]
            );
        

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

              
       
        if($user->id > 0){
            $pipe = PipeModel::find($this->property('pipe'));
            $pipe->start_date = Input::get('start_date');     
            $pipe->due_date = Input::get('due_date');     
            $pipe->line_id = Input::get('line_id');             
            $pipe->pipe_target_weight = Input::get('pipe_target_weight');
            $pipe->production_rate = Input::get('production_rate');
            $pipe->target_scrap_rate = Input::get('target_scrap_rate');
            $pipe->target_availability = Input::get('target_availability');
            
            $pipe->changeover_days = Input::get('changeover_days');
            $pipe->save(); 
            
            if($pipe->id > 0){
               
                Flash::success("Update was successfully saved");
                return Redirect::refresh();
            }else{
              Flash::error("Error: Could not update...");
              return;   
            }

        }else{
              Flash::error("Use need ...");
              return; 
        }
    }

    public function onCreateSchedule(){      
        $user = Auth::getUser();
        $pipe = PipeModel::find($this->property('pipe'));

        #loop start date to end date
        if($pipe->start_date){
            $totalmass = $pipe->quoteitems->units * $pipe->pipe_target_weight;

            $effective_production_rate =  (($pipe->production_rate*($pipe->target_availability/100)*(1-($pipe->target_scrap_rate/100))));

            $productiondays =$totalmass/($effective_production_rate * 24);
            $dailproduction = $effective_production_rate * 24;
            $count = 0;
            for ($i=0; $i < $productiondays ; $i++) { 
                $sc = new ScheduleModel(); 
                $date = new Carbon($pipe->start_date);
                $sc->user_id = $user->id;
                $sc->pipe_id = $pipe->id;
                $sc->production_days = $i+1;
                $sc->production_date = $date->addDay($i);
                $sc->target_kg_processed = $dailproduction;
                $sc->target_units_produced = $dailproduction/$pipe->pipe_target_weight;
                $sc->save();
                $count++;
            }

            if($count > 0){
                Flash::success("Your post was updated succesfully..");
                  return Redirect::refresh();
            }else{
                Flash::error("1. Schedule could not be created...");
            }
          
        }else{
            Flash::error("no start date".$pipe->start_date);
        }

    }

     public function onGetWallEdit(){
        $user = Auth::getUser();  
        if(Input::get('id')){
            $objL =  ScheduleModel::where('id',  Input::get('id'))->first();
            if($objL && $objL->id > 0){
                $this->page['item'] = $objL;
               
            }else{
                $this->page['item'] = null;
            }
        }

    }


    public function onUpdateSchedule(){
        $user = Auth::getUser();
        $w =  ScheduleModel::where('id',  Input::get('id'))->first();
        if($w && $w->id > 0){
            
            $w->target_kg_processed = Input::get('target_kg_processed');
            $w->target_units_produced = Input::get('target_units_produced');
            $w->total_kg_processed = Input::get('total_kg_processed');
            $w->total_units_produced = Input::get('total_units_produced');
            $w->total_units_passed_qc = Input::get('total_units_passed_qc');
            $w->weight_scrap_kg = Input::get('weight_scrap_kg');
            $w->over_weight_kg = Input::get('over_weight_kg');
            $w->reason_deviation_processed = Input::get('reason_deviation_processed');
            $w->reason_qc_Fail = Input::get('reason_qc_Fail');
            $w->reason_overweight = Input::get('reason_overweight'); 
            $w->recovery_plan = Input::get('recovery_plan');
            $w->material_used = Input::get('material_used');
            $w->batch_numbers = Input::get('batch_numbers'); 
            $w->running_hours = Input::get('running_hours');
            $w->maintenance = Input::get('maintenance'); 
            $w->save();
            $w->publisheddate = $w->created_at;            
            Flash::success("Your post was updated succesfully");
            
            return Redirect::refresh();
        }else{
            Flash::success("Permision denied");
        }
    }


     public function onNewSchedule(){
        $user = Auth::getUser();
        $pipe = PipeModel::find($this->property('pipe'));
        if($pipe && $pipe->id > 0){
            $w = new ScheduleModel();
            $w->user_id = $user->id;
            $w->pipe_id = $pipe->id;
            $w->production_days = Input::get('production_days');
            $w->production_date = Input::get('production_date');

            $w->target_kg_processed = Input::get('target_kg_processed');
            $w->target_units_produced = Input::get('target_units_produced');
            $w->total_kg_processed = Input::get('total_kg_processed');
            $w->total_units_produced = Input::get('total_units_produced');
            $w->total_units_passed_qc = Input::get('total_units_passed_qc');
            $w->weight_scrap_kg = Input::get('weight_scrap_kg');
            $w->over_weight_kg = Input::get('over_weight_kg');
            $w->reason_deviation_processed = Input::get('reason_deviation_processed');
            $w->reason_qc_Fail = Input::get('reason_qc_Fail');
            $w->reason_overweight = Input::get('reason_overweight'); 
            $w->recovery_plan = Input::get('recovery_plan');
            $w->material_used = Input::get('material_used');
            $w->batch_numbers = Input::get('batch_numbers'); 
            $w->running_hours = Input::get('running_hours');
            $w->maintenance = Input::get('maintenance'); 
            $w->save();
                     
            Flash::success("New schedule succesfully created...");
            
            return Redirect::refresh();
        }else{
            Flash::success("Could not find pipe...");
        }
    }
    
}
