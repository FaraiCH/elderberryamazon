<?php namespace Bt\JSEData\Models;

use Db;
use \Backend\Models\ExportModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Bt\JSEData\Models\Company;
use Bt\JSEData\Models\Property as PropertyModel;
use Bt\JSEData\Models\DataMine as DataMineModel;
class DataMineImport implements ToCollection
{

     public $name;


      function __construct($name) {
        $this->name = $name;
      }

    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    public function collection(Collection $rows)
    {

        $objCompany = Company::all();
        $objProperty = PropertyModel::all();
        $monster = array();

       // trace_log("name id = ".$this->name);
        $countrow = 0;
        foreach ($rows as $row)
        {

            $countrow++;
            $propertyId = 0;
            if($countrow > 6){
                if(!empty($row[1])){ ##if id date
                    $propertyId = $this->getPropertyName($objProperty,$row[1],$this->name);
                }
            }

            for ($i=3; $i < count($row) ; $i++) {
                if($countrow == 1){
                    ##INITIALISE ARRAY MONSERT
                    $companyid = $this->getCompanyName($objCompany,$row[$i]);
                    if($companyid > 0){
                        $monster["col-".$i]["companyid"] = $companyid;
                        $monster["col-".$i]["status"] = true;
                    }
                }

                if($countrow == 2){
                    if(isset($monster["col-".$i])){
                        if($monster["col-".$i]["status"]){
                            if($row[$i]){ ##if id date
                                    $monster["col-".$i]["datea"] = $this->setTODate($row[$i]) ;
                            }else{
                                $monster["col-".$i]["status"] = false;
                            }
                        }

                    }
                }

                if($countrow == 5){
                    if(isset($monster["col-".$i])){
                        if($monster["col-".$i]["status"]){
                            if($row[$i]){ ##if id date
                                $monster["col-".$i]["cur"] = $row[$i];
                            }else{
                                $monster["col-".$i]["status"] = false;
                            }
                        }

                    }
                }

                if($countrow == 6){
                    if(isset($monster["col-".$i])){
                        if($monster["col-".$i]["status"]){
                            if($row[$i]){ ##if id date
                                    $monster["col-".$i]["dateb"] = $this->setTODate($row[$i]);
                            }else{
                                $monster["col-".$i]["status"] = false;
                            }
                        }

                    }
                }

                if($countrow > 6 && $propertyId > 0){
                    if(isset($monster["col-".$i])){
                        if($monster["col-".$i]["status"]){

                            if(!empty($row[$i])){ ##if id date
                                #$monster["col-".$i]["value"] = $row[$i];
                                $monster["col-".$i]["propertyId"] = $propertyId;
                                $monster["col-".$i]["status"] = true;
                                if($propertyId == 6 && $monster["col-".$i]["companyid"] == 268 ){
                                }
                                $find = DataMineModel::
                                where("company_id",$monster["col-".$i]["companyid"])
                                ->where("property_id",$monster["col-".$i]["propertyId"])
                                ->where("cur",$monster["col-".$i]["cur"])
                                ->where("datea","=",$monster["col-".$i]["datea"])
                                ->where("value",$row[$i])
                                ->first();
                                if(empty($find)){
                                    $n = new DataMineModel();
                                    $n->company_id = $monster["col-".$i]["companyid"];
                                    $n->property_id = $monster["col-".$i]["propertyId"];
                                    $n->datea = $monster["col-".$i]["datea"];
                                    $n->dateb = $monster["col-".$i]["dateb"];
                                    $n->cur = $monster["col-".$i]["cur"];
                                    $n->value =$row[$i];
                                    $n->save();
                                }

                            }

                        }
                    }

                }
            }
        }
        //trace_log($monster);
    }

    private function getPropertyName($obj,$val,$parentid){
        if(!empty($val))
            foreach ($obj as $key => $value) {
                if($value->parent_id == $parentid && ($val == $value->name || $val == $value->altnamea))
                    return $value->id;
            }
        return null;
    }

      private function getCompanyName($obj,$val){
        if(!empty($val))
            foreach ($obj as $key => $value) {
                if($val == $value->name || $val == $value->ticker || $val == $value->altticker ){
                    return $value->id;
                }
            }

        return null;
    }

    private function setTODate($value,$format = 'Y-m-d'){
        if(is_numeric($value)){
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
             try {
                return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            } catch (\ErrorException $e) {
                return \Carbon\Carbon::createFromFormat($format, $value);
            }
        }else{

            return null;
        }

    }

     private function setSimpledate($value,$format = 'Y-m-d'){
          return \Carbon\Carbon::createFromFormat($format, $value);

        }
}

