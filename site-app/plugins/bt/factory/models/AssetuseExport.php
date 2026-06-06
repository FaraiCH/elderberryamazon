<?php namespace Bt\Factory\Models;

use Model;
use BackendAuth;
use Input;
use Bt\HR\Models\Employee;
use Bt\Factory\Models\Assettype;
use Bt\Factory\Models\Assetuse;

class AssetuseExport extends \Backend\Models\ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {

        $records = Assetuse::with([
            // 'updatedby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            // 'createdby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'employee' => function($query){ $query->addSelect(['id','employeenumber', 'firstname', 'lastname']); },
            'asset' => function($query){ $query->addSelect(['id','assettype', 'brand']); },

            'updatedby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'createdby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },

           
        ])->orderby('id','DESC')->get();

        

        $records->each(function($records) use ($columns) {
        $records->addVisible($columns);
        });
        
        $collection = collect($records->toArray());
        $data = $collection->map(function ($item) {
            if(is_array($item)){
                foreach($item as $key => $value) {
                    
                    if($key == "employee" ){
                        if(is_array($value) && isset($value["employeenumber"])) {
                           $item[$key] = $value["employeenumber"];
                           $item['name'] = $value["firstname"];
                           $item['surname'] = $value["lastname"];    
                        }
                    }

                    if($key == "asset" ){
                           $item['asset'] = $value["assettype"];
                           $item['brand'] = $value["brand"];
                    }

                    if(is_array($value) && isset($value["first_name"])) {
                        $item[$key] = $value["first_name"]." ".$value["last_name"];
                    }
                }
            }
            return $item;
        });

        return $data->toArray();

    }
}