<?php namespace Bt\Sales\Models;

use Model;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\sales\Models\Catalogue;

class CatalogueImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {

            try {
                $catalogue = new Catalogue;
                $catalogue->fill($data);
                $catalogue->save();

                $this->logCreated();
            }



            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }

        }
    }
}