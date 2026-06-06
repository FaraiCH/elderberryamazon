<?php namespace Bt\Maintenance\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Maintenance\Models\Electricity as ElectricityMeter;

class ElectricityImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
             try {
                 if(isset($_SESSION['machine'])){
                     $model = Electricity::firstOrCreate([
                         'rdate' => $data['rdate'],
                         'rtime' => $data['rtime'],
                         'kwh' => $data['kwh'],
                         'kVArh' => $data['kVArh'],
                         'kva' => $data['kva'],
                         'pf' => $data['pf'],
                         'status' => $data['status'],
                         'meter_no' => $_SESSION['machine'],
                     ]);
                     $model->save();
                 }
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }

}
