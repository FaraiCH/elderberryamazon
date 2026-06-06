<?php namespace Bt\Sales\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Sales\Models\Client;

class ClientImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = ['id' => 'required'];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {

            try {
                if(array_key_exists('id', $data)){


                    $client = Client::find($data['id']);
                    if(!empty($client)){
                        unset($data['id']);
                        $client->fill($data);
                        $client->save();

                        $this->logUpdated();    
                    }else{
                         $this->logError($row, "Could not find id ($data->id)");
                    }
               } 
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }

        }
    }
}
