<?php namespace Bt\HR\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\HR\Models\Employee;

class EmployeeExport extends ExportModel {

    /**
     * @var array Fillable fields
     */
    // protected $fillable = [];

    public function exportData($columns, $sessionKey = null)
    {
        //Change: Farai Chakarisa
        //Description: Adding ethnicity to export
        $records = Employee::with([
            'department'  => function($query){ $query->addSelect(['id','name']); },
            'updatedby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'company' => function($query){ $query->addSelect(['id', 'name']); },
            'createdby' => function($query){ $query->addSelect(['id', 'first_name', 'last_name']); },
            'type' => function($query){ $query->addSelect(['id','name']); },
            'ethnicity' => function($query){ $query->addSelect(['id','name']); },
        ]);
        if(!empty($_SESSION['active'])){
            $records = $records->where('is_user_active', $_SESSION['active']);
        }else{
            $records = $records->where('is_user_active', 0);
        }
        if(!empty($_SESSION['age_format']) && !empty($_SESSION['age'])){
            if($_SESSION['age_format'] !== 'all')
                $records = $records->whereDate('dob', $_SESSION['age_format'], $_SESSION['age']);
        }
        if(!empty($_SESSION['gender'])){
            if($_SESSION['gender'] !== 'all')
                $records = $records->where('gender', $_SESSION['gender']);
        }else{
            $records = $records->where('gender', 0);
        }
        if(!empty($_SESSION['ethnicity'])){
            if($_SESSION['ethnicity'] !== 'all')
                $records = $records->where('ethnicity_id', $_SESSION['ethnicity']);
        }
        $records = $records->get();
        $records->each(function($record) use ($columns) {
            $record->addVisible($columns);
        });
        $collection = collect($records->toArray());
        $data = $collection->map(function ($item) {
            if(is_array($item)){
                foreach($item as $key => $value) {
                    if(is_array($value) && isset($value["name"])) {
                        $item[$key] = $value["name"];
                        if(is_array($value) && isset($value["surname"])) {
                            $item[$key] = $value["name"]." ".$value["surname"];
                        }
                    }
                    if($key == "company" ){
                        $item[$key] = "company";
                        if(is_array($value) && isset($value["name"])) {
                           $item[$key] = $value["name"];
                        }
                    }
                    if(is_array($value) && isset($value["first_name"])) {
                        $item[$key] = $value["first_name"]." ".$value["last_name"];
                    }
                    if($key == "is_user_active"){
                        $item[$key] = $value == 1? "Yes":"No";
                    }
                    if($key == "gender"){
                        $item[$key] = "Not Set";
                        $item[$key] = $value == 0? "Male":"Female";
                    }
                }
            }
            return $item;
        });
        return $data->toArray();
    }

}
