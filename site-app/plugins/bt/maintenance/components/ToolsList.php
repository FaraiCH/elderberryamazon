<?php namespace Bt\Maintenance\Components;

use Cms\Classes\ComponentBase;
use Bt\Maintenance\Models\Tools as ModelTools ;
use Bt\Maintenance\Models\EquipmentType as ModelEquipmentType ;
use Carbon\Carbon;
use Input;
Use DB;

class ToolsList extends ComponentBase
{
    public $formstatus;  
    public $listquote;

    public function componentDetails()
    {
        return [
            'name'        => 'ToolsList Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        
        
        if(Input::has('showstatus')){
            $this->formstatus = Input::get('showstatus');
        }else{
            $this->formstatus = 0;
        }
      
        if($this->formstatus > 0 ){
            $this->listquote = ModelTools::where('equipment_type_id',$this->formstatus)->get();
        }else{
           
             $this->listquote = ModelTools::all();
        }
    }


    public function getList(){
        return ModelTools::all();
    }
    
    public function EquipmentType(){
        return ModelEquipmentType::all();
    }
}
