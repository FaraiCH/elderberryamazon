<?php namespace Bt\Sales\Models;

use Model;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\QuoteItemCatalogue;
use BackendAuth;
/**
 * QuoteProductionPlan Model
 */
class QuoteProductionPlan extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_quote_production_plans';

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
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        
        'item' => ['Bt\Sales\Models\Quoteitems','key'=>'quoteitem_id'],
        'catitem' => ['Bt\Sales\Models\QuoteItemCatalogue','key'=>'quotecatitem_id'],

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

    public function getItemOptions(){
         $urlArra = explode("/",$_SERVER['REQUEST_URI']);
        $q = 0;
        $q = $urlArra[count($urlArra)-1];
        $list = Quoteitems::where("quote_id",$q)->get();
        $obj = array();
        foreach ($list as $key => $value) {
            $obj[$value->id] = $value->description." / QTY MAX ($value->units)";
        }
        return $obj;
    }

    public function getCatitemOptions(){
         $urlArra = explode("/",$_SERVER['REQUEST_URI']);
        $q = 0;
        $q = $urlArra[count($urlArra)-1];
        $list = QuoteItemCatalogue::where("quote_id",$q)->get();
        $obj = array();
        foreach ($list as $key => $value) {
            $obj[$value->id] = $value->description." / QTY MAX ($value->units)";
        }
        return $obj;
    }

    public function getReasonIdOptions(){

        return array(1=>"Production Run",2=>"Backorder",3=>"Wish list");
    }

    public function getReasonIdOptionsSelect($id){

        $bt = array(1=>"Production Run",2=>"Backorder",3=>"Wish list");
        return $bt[$id];
    }

    public function listItems(){        
        $q = $this->quote->id;
        $list = Quoteitems::where("quote_id",$q)->get();
        $obj = array();
        foreach ($list as $key => $value) {
            $obj[$value->id] = $value->description." / QTY MAX ($value->units)";
        }
        return $obj;
    }

    public function listCats(){
         $q = $this->quote->id;
        $list = QuoteItemCatalogue::where("quote_id",$q)->get();
        $obj = array();
        foreach ($list as $key => $value) {
            $obj[$value->id] = $value->description." / QTY MAX ($value->units)";
        }
        return $obj;
    }
     

}
