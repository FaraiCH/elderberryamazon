<?php namespace Bt\Sales\Models;


use Bt\Sales\Models\Newquote;
use Bt\Sales\Updates\SeederReceivedNonReceived;
use Model;
use BackendAuth;
use Input;
use  Bt\Sales\Models\Invoice;
use Bt\Production\Models\Push as PushModel;
use Bt\Production\Models\Pipe as PipeModel;
use BT\Sales\Models\StockOrder as StockOrderModel;

/**
 * Stockoderitem Model
 */
class Stockoderitem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_stockoderitems';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        //'stockorder' => ['Bt\Sales\Models\StockOrder','key'=>'stock_order_id'],
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


    public function listFirstQuoteItems($fieldName, $value, $formData)
    {
        $srnURL = \Request::segment(6);
        $arrayName = array();
        $srnid = $srnURL;

        if($srnid > 0){

            $srn = StockOrderModel::find($srnid);
            $quote_id = $srn->quote_id;
            $inv =  Newquote::find($quote_id);


            if(!empty($inv->items)){
                foreach ($inv->items as $key => $item) {
                    $qc = $item->units;
                    $dlv = $item->getTotalDelivered();
                    $good = $qc - $dlv;

                    #if($good > 0){
                    //$arrayName[$item->id] = "QUOTE ".$inv->id." DESC #".$item->description." : ORDERED QTY ($qc), DELIVERED ($dlv), TO DELIVER ($good)";
                    $arrayName[$item->id] = $item->description." : ORDERED QTY ($qc), DELIVERED ($dlv), TO DELIVER ($good)";
                    // }else{

                    // }
                }
            }

        }


        return $arrayName;


    }


    public function listQuoteitems($fieldName, $value, $formData)
    {
        $arrayName = array();
        $srnid = $this->getSrnId();
        $srnURL = \Request::segment(6);
        #$i =  PushModel::where("quote_id",284)->first();


        if($this->quoteitem_id > 0){

            $quoteitem = Quoteitems::find($this->quoteitem_id);

            if(!empty($quoteitem)){

                //$arrayName[$quoteitem->id] = "QUOTE ".$this->quoteitem->quote_id." - ITEM ".$quoteitem->id.",  DESC #".$quoteitem->description." :  ORDERED PIPES ($quoteitem->units)";
                $arrayName[$quoteitem->id] = $quoteitem->description." :  ORDERED PIPES ($quoteitem->units)";

            }
        }

        return $arrayName;
    }

    public function getUnitsOptions()
    {
        $arrayName = [];
        $quoteitem = Quoteitems::find($this->quoteitem_id);

        if(!empty($quoteitem)){

            $good = $quoteitem->units;

            if($good > 0){
                for ($i=1; $i <= $good; $i++) {
                    $arrayName[$i] = $i." Pipes" ;
                }
            }
        }

        return $arrayName;
    }


    public function getSrnId(){

        if(!empty(Input::get('StockOrder'))){
            if(!empty(Input::get('StockOrder')["id"])){
                return Input::get('StockOrder')["id"];
            }
        }else{
            return $this->stock_order;
        }

    }
}
