<?php namespace Bt\Sales\Models;

use Bt\Production\Models\Pipe;
use Model;
/**
 * Piperequest Model
 */
class Piperequest extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_piperequests';
    public $available_total = 0;
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
    public $rules = [
           'from_quote_id' => 'required',
           'quote_item_id' => 'required',
           'to_quote_id' => 'required',
//           'note' => 'required',
//           'qty' => 'required',
    ];

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
    public $hasOne = [
        'piperapprove' => ['Bt\Sales\Models\Piperapprove', 'key' => 'piperequest_id']
    ];
    public $hasMany = [];
    public $belongsTo = [
        'from_quote' => ['Bt\Sales\Models\Newquote'],
        'to_quote' => ['Bt\Sales\Models\Newquote'],
        'quote_item' => ['Bt\Sales\Models\Quoteitems'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        $user = \BackendAuth::getUser();
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        $user = \BackendAuth::getUser();
        $this->updated_by = $user->id;
    }
    public function getFromQuoteIdOptions(){
        $quote = Newquote::select('id',\Db::raw("concat(id, ' > ', company_name) as full_name"))->
        where('ponumber',"<>","")->orderBy('id', 'desc')->lists('full_name','id');
        return $quote;
    }
    public function getQuoteItemIdOptions(){
        $array_items = array();
        if(isset($this->from_quote->id)){
            $quoteitem = Quoteitems::where('quote_id', $this->from_quote->id)->get();
            foreach($quoteitem as $item){
                $array_items[$item->id] = $item->description;
            }
        }else{
            return [];
        }
        return $array_items;
    }

    public function getToQuoteIdOptions(){
        if(isset($this->from_quote->id))
            $quote = Newquote::select('id',\Db::raw("concat(id, ' > ', company_name) as full_name"))->
            where('ponumber',"<>","")->where('id','<>', $this->from_quote->id)->orderBy('id', 'desc')->lists('full_name','id');
        else
            return [];
        return $quote;
    }
//    public function getQtyStart(){
//        $quoteitem = null;
//        $full_range = null;
//        $number_range = array();
//        $available = 0;
//        if(isset($this->quote_item->id)){
//            $request_done = self::where('from_quote_id', $this->from_quote_id)->where('quote_item_id', $this->quote_item_id)->get();
//            $pipe = Quoteitems::find($this->quote_item->id)->pipe;
//            if(isset($pipe->id)){
//                $qc = $pipe->getTotalProduced();
//                $dlv = $pipe->getTotalDelivered();
//
//                $good = $qc - $dlv;
//                if($request_done->sum('qty') > 0){
//                    $available = $good - $request_done->sum('qty');
//                }else{
//                    $available = $good;
//                }
//                if($available > 0){
//                    $full_range = range(1,$available);
//                }else{
//                    $full_range = range(0,$available);
//                }
//                foreach ($full_range as $key => $range) {
//                    if($range > 0){
//                        $number_range[$range] = $range;
//                    }
//
//                }
//            }
//        }
//        else
//            return [];
//        return $number_range;
//    }
//
//    public function getQtyOptions()
//    {
//        $quoteitem = null;
//        $full_range = null;
//        $number_range = array();
//        if(isset($this->quote_item->id)){
//            $pipe = Quoteitems::find($this->quote_item->id)->pipe;
//            if(isset($pipe->id)){
//                $number = $pipe->schedules->sum('total_units_passed_qc');
//                $delivered = $pipe->delivered->sum('units');
//                $available = $number - $delivered;
//                if($available > 0){
//                    $full_range = range(1,$available);
//
//                }else{
//                    $full_range = range(0,$available);
//                }
//                foreach ($full_range as $key => $range) {
//                    $number_range[$range] = $range;
//                }
//            }
//        }
//        else
//            return [];
//        return $number_range;
//    }

}
