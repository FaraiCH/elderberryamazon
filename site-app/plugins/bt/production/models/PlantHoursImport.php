<?php namespace Bt\Production\Models;

use Model;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Production\Models\PlantHours;
use \Bt\HR\Models\Employee;

// use BackendAuth;
use Backend\Classes\Controller;

class PlantHoursImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
          
            try {

                if(isset($data['employee']) ){
                   $emp =  Employee::where("employeenumber",$data['employee'])->first();
                   if(!empty($emp)){

                        if(isset($data['id']) && $data['id'] > 0){
                            ##update existing record
                            $planthour = PlantHours::find($data['id']);
                            if($planthour->employee_id == $emp->id){
                                $planthour->employee_id = $emp->id;
                                $planthour->hours = $data['hours'];
                                $planthour->workDate = $data['workDate'];
                                $planthour->save();    
                            }else{
                                $this->logError($row, "Emplyee Number dont match");  
                            }
                            

                        }else{
                            ##ADD NEW RECORD
                            $planthour = new PlantHours;
                            $planthour->employee_id = $emp->id;
                            $planthour->hours = $data['hours'];
                            $planthour->workDate = $data['workDate'];
                            $planthour->save();    
                        }
                        $this->logCreated();
                   }else{
                        $this->logError($row, "Eployeer does not exist");
                   }
                }else{
                        $this->logError($row, "Eployeer field not found");
                   }
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }

        }
    }
}