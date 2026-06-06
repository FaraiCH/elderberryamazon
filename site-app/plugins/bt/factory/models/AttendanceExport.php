<?php namespace Bt\Factory\Models;

use Model;
use BackendAuth;
use Input;
use Bt\Factory\Models\Attendance;

class AttendanceExport extends \Backend\Models\ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {
         $records = Attendance::with([
            'updatedby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'createdby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'attendancetypes' => function($query){ $query->addSelect(['id','attendancetype']); },

            

           
        ])->orderby('id','DESC')->get();

        $records->each(function($records) use ($columns) {
        $records->addVisible($columns);
        });
        
        $collection = collect($records->toArray());
        $data = $collection->map(function ($item) {
            if(is_array($item)){
                foreach($item as $key => $value) {

                    if(is_array($value) && isset($value["attendancetype"])) {
                        $item[$key] = $value["attendancetype"];
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