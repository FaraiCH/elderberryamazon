<?php namespace Bt\JSEData\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\JSEData\Models\Property as PropertyModel;

class PropertyImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
             try {
                $subscriber = new PropertyModel;
              //  trace_log($data);
                $subscriber->fill($data);
                $subscriber->save();
                //trace_log($subscriber);

                $this->logCreated();
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }




        }
    }
}
