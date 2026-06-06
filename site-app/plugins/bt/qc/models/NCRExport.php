<?php namespace Bt\QC\Models;

use Bt\QC\Models\NCR as NCRModel;

class NCRExport extends \Backend\Models\ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {
        
         $records = NCRModel::with([
            'updatedby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'createdby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'type' => function($query){ $query->addSelect(['id','name']); },   
            'department' => function($query){ $query->addSelect(['id','name']); },            
           
        ])->orderby('id','DESC')->get();

   
        $records->each(function($record) use ($columns) {
            $record->addVisible($columns);
        });
        
        $collection = collect($records->toArray());
        $data = $collection->map(function ($item) {
            if(is_array($item)){
                foreach($item as $key => $value) {
                    if($key == "type" || $key == "department" ){
                        $item[$key] = "";
                        if(is_array($value) && isset($value["name"])) {
                           $item[$key] = $value["name"];
                            
                        }
                    }
                    if(is_array($value) && isset($value["first_name"])) {
                        $item[$key] = $value["first_name"]." ".$value["last_name"];
                    }

                    if($key == "isresolved"){
                        $item[$key] = $value == 1? "Yes":"No";    
                    }
                }
            }
            return $item;
        });

        return $data->toArray();
    }
}
?>