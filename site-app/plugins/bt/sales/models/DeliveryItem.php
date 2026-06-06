<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\DeliveryPlan;

/**
 * DeliveryItem Model
 */
class DeliveryItem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_delivery_items';

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
      'quotecat'                  => 'required',
      'units'                  => 'required'
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
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'quotecat' => ['Bt\Sales\Models\Quoteitems','key'=>'quoteitem_id','order'=>'id desc'],
        'delivery' => ['Bt\Sales\Models\DeliveryPlan','key'=>'delivery_id','order'=>'id desc'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'upload_file' => 'System\Models\File'
    ];

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

      public function getQuotecatOptions(){

        $urlArra = explode("/",$_SERVER['REQUEST_URI']);
        $q = 0;
        $q = $urlArra[count($urlArra)-1];

        $obj = array();
        $o = DeliveryPlan::where('id',$q)->first();
        foreach ($o->quote->items as $key => $value) {

                $obj[$value->id] = $value->description;


        }


        return $obj;

    }
    public function getQuoteitemIdOptions($id){

        $urlArra = explode("/",$_SERVER['REQUEST_URI']);
        $q = 0;
        $q = $urlArra[count($urlArra)-1];

        $obj = array();
        $o = DeliveryPlan::where('id',$q)->first();
       foreach ($o->quote->items as $key => $value) {
            $obj[$value->id] = $value->description;
        }


        return $obj;
    }
}
