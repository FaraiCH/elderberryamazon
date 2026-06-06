<?php namespace Bt\Sales\Models;

use Db;
use \Backend\Models\ExportModel;
use \October\Rain\Support\Collection;
use \Bt\Sales\Models\TransportRatesDestination;
use \Bt\Sales\Models\TransportFee;

class TransportFeeImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

     public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
             try {
                if(isset($data['destination']) ){
                   $destination =  TransportRatesDestination::where('name', $data['destination'])->first();
                   if(!empty($destination)) {
                       $transport = TransportFee::where('transportratesdestination_id', $destination->id)->where("date", $data['date'])->first();
                       if (!empty($transport)) {
                           $transport->transportratesdestination_id = $destination->id??null;
                           $transport->date = $data['date']??null;
                           $transport->ton = $data['ton']??null;
                           $transport->four_ton_trailer = $data['four_ton_trailer']??null;
                           $transport->ton_trailer = $data['ton_trailer']??null;
                           $transport->ton_trailer_min_6m = $data['ton_trailer_min_6m']??null;
                           $transport->ten_ton_12m_trailer = $data['ten_ton_12m_trailer']??null;
                           $transport->trailer_18m = $data['trailer_18m']??null;
                           $transport->trailer_12m = $data['trailer_12m']??null;
                           $transport->eight_ton = $data['eight_ton']??null;
                           $transport->bt_ton = $data['bt_ton']??null;
//                           $transport->four_ton_trailer = $data['four_ton_trailer'];
                           $transport->bt_ton_trailer = $data['bt_ton_trailer']??null;
                           $transport->bt_ton_trailer_min_6m = $data['bt_ton_trailer_min_6m']??null;
                           $transport->bt_ten_ton_12m_trailer = $data['bt_ten_ton_12m_trailer']??null;
                           $transport->bt_four_ton_trailer = $data['bt_four_ton_trailer']??null;
                           $transport->bt_eight_ton = $data['bt_eight_ton']??null;
                           $transport->bt_trailer_18m = $data['bt_trailer_18m']??null;
                           $transport->bt_trailer_12m = $data['bt_trailer_12m']??null;
                           $transport->active = $data['active']??null;
                           $transport->save();
                           $this->logUpdated();
                       } else {
                           $transport = new TransportFee();
                           $transport->transportratesdestination_id = $destination->id;
                           $transport->date = $data['date'];
                           $transport->ton = $data['ton'];
//                           $transport->four_ton_trailer = $data['four_ton_trailer'];
                           $transport->ton_trailer = $data['ton_trailer'];
                           $transport->ton_trailer_min_6m = $data['ton_trailer_min_6m'];
                           $transport->ten_ton_12m_trailer = $data['ten_ton_12m_trailer'];
                           $transport->trailer_18m = $data['trailer_18m'];
                           $transport->trailer_12m = $data['trailer_12m'];
                           $transport->bt_ton = $data['bt_ton'];
//                           $transport->four_ton_trailer = $data['four_ton_trailer'];
                           $transport->bt_ton_trailer = $data['bt_ton_trailer'];
                           $transport->bt_ton_trailer_min_6m = $data['bt_ton_trailer_min_6m'];
                           $transport->bt_ten_ton_12m_trailer = $data['bt_ten_ton_12m_trailer'];
                           $transport->bt_trailer_18m = $data['bt_trailer_18m'];
                           $transport->bt_trailer_12m = $data['bt_trailer_12m'];
                           $transport->active = $data['active'];
                           $transport->save();
                           $this->logCreated();
                       }

                       $updateTransport = TransportFee::where('transportratesdestination_id', $destination->id)->where('date', '!=',  $data['date'])->get();
                       foreach ($updateTransport as $trasport){
                           $trasport->active = 0;
                           $trasport->save();
                       }
                   }
                }
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }
}
