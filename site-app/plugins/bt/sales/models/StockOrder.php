<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;

/**
 * StockOrder Model
 */
class StockOrder extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_stock_orders';

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
        'quote' => 'required',
        'deadline_date' => 'required',
        'transport_type' => 'required',
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
        'srn' => ['Bt\Sales\Models\Srn','key'=>'stock_order_id'],
    ];
    public $hasMany = [
        'items' => ['Bt\Sales\Models\Stockoderitem','key'=>'stock_order_id'],
        'itemscat' => ['Bt\Sales\Models\Stockoderitemcatalogue','key'=>'stock_order_id'],
    ];
    public $belongsTo = [
        'transport_type' =>     ['Bt\Sales\Models\TransportType','key'=>'transport_type_id'],
        'client' =>     ['Bt\Sales\Models\Client','key'=>'client_id','order'=>'company_name'],
        'quote' =>      ['Bt\Sales\Models\Newquote','key'=>'quote_id',],
        'createdby' =>  ['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>  ['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }

    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }

    public function getQuoteOptions(){
        $quoteObj = array();


        $quotes = Newquote::orderBy('id', 'desc')->get();
        foreach ($quotes as $quote){
            $quoteObj[$quote->id] = $quote->id . ' ' . $quote->company_name;
        }


        return $quoteObj;
    }
}
