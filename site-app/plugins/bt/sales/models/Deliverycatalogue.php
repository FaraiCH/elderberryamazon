<?php namespace Bt\Sales\Models;

use Model;
use Backend\Facades\BackendAuth;
/**
 * Deliverycatalogue Model
 */
class Deliverycatalogue extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_deliverycatalogues';

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
        'catalogue' => ['Bt\Sales\Models\QuoteItemCatalogue','key'=>'quoteitemcatalgue_id','order'=>'id desc'],
        'delivery' => ['Bt\Sales\Models\DeliveryPlan','key'=>'delivery_id','order'=>'id desc'],
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

    public function getCatalogueOptions(){

        $urlArra = explode("/",$_SERVER['REQUEST_URI']);

        $q = $urlArra[count($urlArra)-1];

        $obj = array();
        $o = DeliveryPlan::where('id',$q)->first();
        foreach ($o->quote->itemscat as $key => $value) {

            $obj[$value->id] = $value->description . " (". $value->units . " Units Ready)";


        }


        return $obj;

    }

    public function getCatalogueAttribute()
    {
        $value = array_get($this->attributes, 'catalogue');
        return array_get($this->getCatalogueOptions(), $value);
    }
}
