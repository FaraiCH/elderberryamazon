<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;

/**
 * Quoteitems Model
 */
class Quoteitems extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_quoteitems';

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
    public $hasOne = [
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'quoteitem_id'],

    ];
    public $hasMany = [
        'delivered' => ['Bt\Sales\Models\SrnItem','key'=>'quoteitem_id'],
        // 'production_daily_report_items' => ['Bt\Reporting\Models\ControlSheetMassData','key'=>'quot_id'],
        'pipesticker' => ['Bt\Production\Models\Pipestickeritem', 'key' => 'quote_item_id']
    ];

    public $belongsTo = [

        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'product' => ['Bt\Sales\Models\Product','key'=>'product_id'],
          'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],

    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function filterFields($fields, $context = null)
    {
        if (empty($this->product))
            return;
        $unitlength = 0;
        if (!empty($this->unitlength))
            $unitlength = $this->unitlength;

        $fields->description->value = $this->product->name." ".$unitlength."m length ";
    }

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        if(!empty($user) && isset($user->id)){
            $this->created_by = $user->id;
            $this->makeupQuote();
        }else{
            $this->created_by = 1;
        }
        // $this->created_by = $user->id;

    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;

        if(!empty($user) && isset($user->id)){
             $this->updated_by = $user->id;
             $this->makeupQuote();
        }else{
            $this->updated_by = 1;
        }
    }

    public function beforeDelete()
    {
        // Check the quote item pipe relation to see if the pipe is in production and approved
        if(isset($this->pipe->id))
        {
            $pipeQuanities = $this->pipe->qpush->approved->status_id;

            if($pipeQuanities > 0)
            {
                \Flash::error('Pipe Cannot Be Deleted Because It Was Approved BY EXCO For Production');
                return false;
            }

        }
    }

    public function afterCreate()
    {

        $this->UpdateQuote($this->quote_id);
    }

    public function afterUpdate()
    {

        $this->UpdateQuote($this->quote_id);
    }


    private function makeupQuote(){
        $this->weight =  $this->product->value*$this->unitlength;
        $this->totalweight = $this->product->value*$this->unitlength*$this->units;
        $this->unitprice = round($this->product->value*$this->priceperkg*$this->unitlength, 2);
        $this->price =  $this->unitprice*$this->units;;
    }

     private function UpdateQuote($id){
        $quote = Newquote::find($id);
        $quote->fixTotal();
    }

    protected $appends = [
        'pnrating_id',
        'flagit',
        'pricemargperc'
    ];

    public function getPnratingIdAttribute() {
        return 1;
        return $this->srn->type->name;
    }

     public function getPricemargpercAttribute() {
         $p = 0 ;
         $v =  0;
        if(isset($this->product))
        {
            $p =  $this->priceperkg - $this->product->PNRating->premiumprice ;
            $v =  ($p/$this->product->PNRating->premiumprice)*100;
        }

        return number_format($v, 1, ',', ' ');;

    }

    public function getFlagitAttribute() {
        $p =  0;
        $v =  0;
        if(isset($this->product))
        {
            $p =  $this->priceperkg - $this->product->PNRating->premiumprice ;
            $v =  ($p/$this->product->PNRating->premiumprice)*100;
        }
        if($v == 0){
            return 0;
        }elseif ($v > 0) {
            return 1;
        }else{
            if(isset($this->product)) {
                if ($this->product->PNRating->alert == 1) {
                    return 2;
                } else {
                    return 3;
                }
            }else{
                return 3;
            }

        }


    }

    public function scopeFilterByPnrating($query, $filter)
    {
        return $query->whereHas('product', function($group) use ($filter) {
            $group->whereIn('pn_ratings_id', $filter);
        });
    }

    public function getTotalDelivered() {
        $total = 0;
        foreach ($this->delivered as $s => $delivered) {
            $total += $delivered->units;

        }
        return $total;

    }

    /*
        Get's the object of all pipes (even linked ones or BT Account) with the same length and product specification for the quote
        This is a cleaner way to get pipes delivered and can be used for pick slip downloads as well.
    */
    public function getSameItemDelivered($quote_id, $product_id, $unitlength, $startdate, $enddate){
        if($startdate == '' && $enddate == ''){
            return SrnItem::whereHas('srn', function ($query) use ($quote_id){
                $query->where('quote_id', $quote_id);
            })->whereHas('quoteitem', function ($query) use ($product_id, $unitlength){
                $query->where('product_id', $product_id)->where('unitlength', $unitlength);
            });
        }else{
            return SrnItem::whereHas('srn', function ($query) use ($quote_id){
                $query->where('quote_id', $quote_id);
            })->whereHas('quoteitem', function ($query) use ($product_id, $unitlength){
                $query->where('product_id', $product_id)->where('unitlength', $unitlength);
            })->whereBetween('created_at', [$startdate, $enddate]);
        }

    }

}
