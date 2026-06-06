<?php namespace Bt\Sales\Models;

use Bt\Sales\Models\Newquote;
use Bt\Sales\Updates\SeederReceivedNonReceived;
use Model;
use BackendAuth;
use Input;
use  Bt\Sales\Models\Invoice;
use Bt\Production\Models\Push as PushModel;
use Bt\Production\Models\Pipe as PipeModel;

/**
 * SrnItem Model
 */
class SrnItem extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_srn_items';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'pipe_id'                  => 'required',
        'quoteitem_id'                  => 'required',
        'units'                  => 'required'
    ];



    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'srn' => ['Bt\Sales\Models\Srn','key'=>'srn_id'],
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'quoteitem' => ['Bt\Sales\Models\Quoteitems','key'=>'quoteitem_id'],
        // 'product' => ['Bt\Sales\Models\Product','key'=>'product_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        // $user = BackendAuth::getUser();
        if (!$user) return;
        // $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        // $user = BackendAuth::getUser();
        if (!$user) return;
        // $this->updated_by = $user->id;
    }

    public function listFirstQuoteItems($fieldName, $value, $formData)
    {
        $srnURL = \Request::segment(6);
        $arrayName = array();
        $srnid = $srnURL;

        if($srnid > 0){

            $srn = Srn::find($srnid);
            $quote_id = $srn->quote_id;
            $inv =  Newquote::find($quote_id);


            if(!empty($inv->items)){
                foreach ($inv->items as $key => $item) {
                    $qc = $item->units;
                    $dlv = $item->getTotalDelivered();
                    $good = $qc - $dlv;

                    #if($good > 0){
                    $arrayName[$item->id] = "QUOTE ".$inv->id." DESC #".$item->description." : ORDERED QTY ($qc), DELIVERED ($dlv), TO DELIVER ($good)";
                    // }else{

                    // }
                }
            }

        }
        $srnFabrication = Srn::find($srnURL);
        if($srnFabrication->getFabrication() == 1){
            return [0 => 'Please Confirm Use of Straight Pipe for Fabrication'];
        }else{
            return $arrayName;
        }

    }


    public function listQuoteitems($fieldName, $value, $formData)
    {
        $arrayName = array();
        $srnid = $this->getSrnId();
        $srnURL = \Request::segment(6);
        #$i =  PushModel::where("quote_id",284)->first();
        $srnFabrication = Srn::find($srnURL);
        if($srnFabrication->getFabrication() == 1){
            $pipes =  PipeModel::where("push_id",41)->get();
            if(!empty($pipes)){
                foreach ($pipes as $key => $pipe) {
                    if($pipe->created_at > "2022-03-01 00:00:00"){

                        $qc = $pipe->getTotalProduced();
                        $dlv = $pipe->getTotalDelivered();

                        $good = $qc - $dlv;

                        #if($good > 0){
                        $arrayName[$pipe->id] = "BT ACCOUNT #ITEM ".$pipe->quoteitems->id." : DESC #".$pipe->quoteitems->description." : PASSED QC #".$qc." : DELIVERED #".$dlv." : MAX PIPES#".$good;


                        #}else{

                        // }
                    }


                }
            }
        }else{
            if($this->quoteitem_id > 0){

                if($srnid > 0){

                    $pipes = PipeModel::where('quoteitem_id',$this->quoteitem_id)->get();

                    if(!empty($pipes)){
                        foreach ($pipes as $key => $pipe) {

                            $qc = $pipe->getTotalProduced();
                            $dlv = $pipe->getTotalDelivered();

                            $good = $qc - $dlv;

                            if($good > 0){
                                $arrayName[$pipe->id] = "QUOTE ".$this->quoteitem->quote_id." - ITEM ".$pipe->quoteitems->id.",  DESC #".$pipe->quoteitems->description." : PASSED QC ($qc), DELIVERED (".$dlv."), MAX PIPES ($good)";

                            }else{
                                $arrayName[$pipe->id] = "QUOTE ".$this->quoteitem->quote_id." - ITEM ".$pipe->quoteitems->id.",  DESC #".$pipe->quoteitems->description." : PASSED QC ($qc), DELIVERED (".$dlv."), MAX PIPES ($good)";
                            }
                        }
                    }
                }

                $productid = $this->quoteitem->product_id;
                $unitlength = $this->quoteitem->unitlength;

                if(isset($quote_id)){
                    $q = Newquote::find($quote_id);

                    foreach ($q->pipesdeliver as $key => $pipe) {
                        if($pipe->quoteitems->product_id == $productid && $pipe->quoteitems->unitlength == $unitlength){
                            $qc = $pipe->getTotalProduced();
                            $dlv = $pipe->getTotalDelivered();
                            $good = $qc - $dlv;
                            #if($good > 0){
                            $arrayName[$pipe->id] = "ASSOCIATED #ITEM ".$pipe->quoteitems->id." : DESC #".$pipe->quoteitems->description." : PASSED QC ($qc), DELIVERED ($dlv), MAX PIPES ($good)";
                            #}
                        }

                    }
                }

                $pipes =  PipeModel::where("push_id",41)->get();

                if(!empty($pipes)){
                    foreach ($pipes as $key => $pipe) {
                        if($pipe->created_at > "2024-03-01 00:00:00"){

                            $qc = $pipe->getTotalProduced();
                            $dlv = $pipe->getTotalDelivered();

                            $good = $qc - $dlv;

                            #if($good > 0){
                            $arrayName[$pipe->id] = "BT ACCOUNT #ITEM ".$pipe->quoteitems->id." : DESC #".$pipe->quoteitems->description." : PASSED QC #".$qc." : DELIVERED #".$dlv." : MAX PIPES#".$good;


                            #}else{

                            // }
                        }


                    }
                }
            }
        }
        return $arrayName;
    }

    public function getUnitsOptions()
    {
        $quote_id = Srn::find(\Request::segment(6));
        $arrayName = array();
        if($this->pipe_id){
            $pipe = PipeModel::find($this->pipe_id);
            if(!empty($pipe)){

                $qc = $pipe->getTotalProduced();
                $dlv = $pipe->getTotalDelivered();

                $good = $qc - $dlv;

                if($good > 0){
                    for ($i=1; $i <= $good; $i++) {
                        $arrayName[$i] = $i." Pipes" ;
                    }
                }
            }
        }
        return $arrayName;
    }



    public function getSrnId(){

        if(!empty(Input::get('Srn'))){
            if(!empty(Input::get('Srn')["id"])){
                return Input::get('Srn')["id"];
            }
        }else{
            return $this->srn_id;
        }

    }

}
