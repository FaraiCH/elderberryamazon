<?php namespace Bt\Sales\Models;

use Model;

/**
 * QuoteItemCatalogue Model
 */
class QuoteItemCatalogue extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_quote_item_catalogues';

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
    public $hasMany = [
        'delivered' => ['Bt\Sales\Models\SrnCatalogue','key'=>'quotecat_id'],
    ];
    public $belongsTo = [
        'catalogue' => ['Bt\Sales\Models\Catalogue','key'=>'product_id'],

        'product' => ['Bt\Sales\Models\Product','key'=>'btproduct_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {

        $this->makeupQuote();

    }
    public function beforeUpdate()
    {

        $this->makeupQuote();
    }


    public function getTotalDelivered() {
        $total = 0;
        foreach ($this->delivered as $s => $delivered) {
            $total += $delivered->units;

        }
        return $total;

    }

    private function makeupQuote(){
        if(!empty($this->catalogue->btproduct)){
            $this->btproduct_id = $this->catalogue->bt_product_id;
            $this->unitlength = $this->catalogue->bt_unitlength;
            $this->weight =  $this->catalogue->btproduct->value*$this->catalogue->bt_unitlength;
            $this->totalweight = $this->catalogue->btproduct->value*$this->catalogue->bt_unitlength*$this->units;
            $this->priceperkg = $this->catalogue->priceperkg;

            $this->priceweightunit = $this->weight*$this->priceperkg;
            $this->priceweighttotal = $this->priceweightunit*$this->units;
        }

        if((is_null($this->unitprice) ||  $this->unitprice == 0) && !empty($this->catalogue) ){
            $this->unitprice = $this->catalogue->price;
        }

        $this->price =  $this->unitprice*$this->units;;

    }

     public function filterFields($fields, $context = null)
    {
        if($context == "update")
            return;
        if (empty($this->catalogue))
            return;
        $fields->description->value = $this->catalogue->name;
    }

}
