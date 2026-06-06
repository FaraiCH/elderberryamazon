<?php namespace Bt\JSEData\Models;

use Db;
use \Backend\Models\ExportModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

use Bt\JSEData\Models\Company;
use Bt\JSEData\Models\Property as PropertyModel;
use Bt\JSEData\Models\ShareData;
#use Bt\JSEData\Models\DataMine as ShareData;
class DataMineImportShare implements ToCollection,WithCustomCsvSettings
{

     public $name;


      function __construct() {
        $this->name = 169;
      }

    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ","
        ];
    }

    public function collection(Collection $rows)
    {

        $objCompany = Company::all();
        $monster = array();

        $countrow = 0;
        $dates = array();
        foreach ($rows as $row)
        {

            $countrow++;
            if($countrow > 1){
                //dd($row);
                $propertyId = 170;
                $companyid = $this->getCompanyName($objCompany,$row[0],$row[1]);
                $cur = "NA";
                if($companyid > 0){
                     for ($i=5; $i < count($row) ; $i++) {
                        if($row[$i] > 0){
                            if(!empty($row[$i]) && isset($dates[$i])){ ##if id date

                                    // $datea = $this->setTODate($rows[0][$i]) ;
                                    // trace_log("Date = ".$rows[0][$i]);


                                    // $find = ShareData::
                                    // where("company_id",$companyid)
                                    // ->where("property_id",$propertyId)
                                    // ->where("cur",$cur)
                                    // ->where("datea",$dates[$i]->format('Y-m-d'))
                                    // ->where("value",$row[$i])
                                    // ->first();
                                    // if(empty($find)){
                                        $n = new ShareData();
                                        $n->company_id = $companyid;
                                        $n->property_id = $propertyId  ;
                                        $n->datea = $dates[$i]->format('Y-m-d');
                                        $n->dateb = $dates[$i]->format('Y-m-d');
                                        $n->cur = $cur;
                                        $n->value =$row[$i];
                                        $n->save();
                                    // }

                                }
                        }

                     }
                }else{
                 //   trace_log("Not found".$row[0]);
                }

            }else{
                // if(!empty($row[$i]))
                for ($i=5; $i < count($row) ; $i++) {
                    if(!empty($row[$i])){
                        $pieces = explode(" ", $row[$i]);
                        if(count($pieces) == 3 && preg_match('/^\d{2}$/', $pieces[0]) && preg_match('/^\d{4}$/', $pieces[2])){
                            $dates[$i] = $this->setTODate($row[$i]);
                        }else{
                          //       trace_log("Invali Date = ".$row[$i]);
                        }

                    }
                }

              //  break;
            }


        }
        //trace_log($monster);
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
        // if(is_numeric($value)){
        //         return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
        //      try {
        //         return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        //     } catch (\ErrorException $e) {
        //         return \Carbon\Carbon::createFromFormat($format, $value);
        //     }
        // }else{
        //      try {
        //         return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        //     } catch (\ErrorException $e) {
         try {
                return \Carbon\Carbon::createFromFormat($format, $value);
                 } catch (\ErrorException $e) {
                    //trace_log("dateinvalit".$value);
                    return null;
                 }
        //     }
        // }

    }

     private function setSimpledate($value,$format = 'Y-m-d'){
          return \Carbon\Carbon::createFromFormat($format, $value);

        }
}

