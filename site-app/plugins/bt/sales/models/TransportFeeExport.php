<?php namespace Bt\Sales\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Sales\Models\TransportFee;

class TransportFeeExport extends ExportModel {

    /**
     * @var array Fillable fields
     *  
     */
    // protected $fillable = [];

      public $table = 'bt_sales_transport_fees';

      public $appends = [
            'destination_name'
      ];
    
     public function exportData($columns, $sessionKey = null)
    {
        
        $query = self::make();
        return $query->get()->toArray();
    }

    public function getDestinationNameAttribute(){
        $destination = TransportFee::find($this->id);

        if(isset($destination->transportratesdestination->name)){
            return $destination->transportratesdestination->name;
        }
       
    }
}