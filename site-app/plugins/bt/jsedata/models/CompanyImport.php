<?php namespace Bt\JSEData\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\JSEData\Models\Company as CompanyMoney;

class CompanyImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
             try {

                 $subscriber = CompanyMoney::where("name",$data["name"])->first();
                 if(!empty($subscriber)){
                    $subscriber->isspecial = 1;
                    $subscriber->save(); 
                    // trace_log("updated ".$data["name"]);
                 }else{
                         // trace_log("could not update ".$data["name"]);
                 }

                // $subscriber = new CompanyMoney;
                // trace_log($data);
                // $subscriber->fill($data);
                // $subscriber->save();
                //trace_log($subscriber);

                $this->logCreated();
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }




        }
    }
}
