<?php namespace Bt\JSEData\Updates;

use Lang;
use Seeder;

use Bt\JSEData\Models\Company;
use Bt\JSEData\Models\Property as PropertyModel;
use Bt\JSEData\Models\ShareData;

class UpdatesJEY extends Seeder
{
    public function __construct()
    {
       $this->sFilePath = 'bt/jsedata/updates/csv/sharedata.csv';
    }

    public function run()
    {
    }

    private function getPropertyName($obj,$val,$parentid){
        if(!empty($val))
            foreach ($obj as $key => $value) {
                if($value->parent_id == $parentid && $val == $value->name)
                    return $value->id;
            }

        return null;
    }

    private function getCompanyName($obj,$val,$alt = null){
        if(!empty($val))
            foreach ($obj as $key => $value) {
                if($val == $value->name || $val == $value->ticker || $val == $value->altticker ){
                    return $value->id;
                }
                if($alt && ($alt == $value->name || $alt == $value->ticker || $alt == $value->altticker)){
                     return $value->id;
                }
            }

        return null;
    }

    private function setTODate($value,$format = 'j F Y'){
        return null;
    }

     private function setSimpledate($value,$format = 'Y-m-d'){
          return \Carbon\Carbon::createFromFormat($format, $value);

        }
}
