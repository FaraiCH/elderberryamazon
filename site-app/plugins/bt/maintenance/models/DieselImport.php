<?php namespace Bt\Maintenance\Models;

use Backend\Models\ImportModel;

class DieselImport extends ImportModel
{
    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
            try {
                $subscriber = new Diesel();
                $subscriber->fill($data);
                $subscriber->save();
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }
}
