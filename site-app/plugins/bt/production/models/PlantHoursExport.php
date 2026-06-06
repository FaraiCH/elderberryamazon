<?php namespace Bt\Production\Models;

use Model;
// use BackendAuth;
// use Backend\Classes\Controller;

class PlantHoursExport extends \Backend\Models\ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {

    	$records = PlantHours::with([
            'updatedby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'createdby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'employee' => function($query){ $query->addSelect(['id','employeenumber', 'firstname', 'lastname']); },

            

           
        ])->orderby('id','DESC')->get();

        $records->each(function($records) use ($columns) {
        $records->addVisible($columns);
        });
        
        $collection = collect($records->toArray());
        $data = $collection->map(function ($item) {
            if(is_array($item)){
                foreach($item as $key => $value) {
                    if($key == "employee" ){
                        $item[$key] = "employee";
                        $item['name'] = "employee";
                        if(is_array($value) && isset($value["employeenumber"])) {
                           $item[$key] = $value["employeenumber"];
                           $item['name'] = $value["firstname"];
                           $item['surname'] = $value["lastname"];    
                        }
                    }

                    if($key == "employee_id" ){
                        $item[$key] = "Noezan";
                    }
                }
            }
            return $item;
        });

        return $data->toArray();


    }
}