<?php namespace Bt\Production\Models;

use Bt\Sales\Models\QuoteItemCatalogue;
use Model;
use Backend\Facades\BackendAuth;

/**
 * ProductionPlanItemCat Model
 */
class ProductionPlanItemCat extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_production_production_plan_item_cats';

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
        'plan' => ['Bt\Production\Models\ProductionPlan','key'=>'plan_id'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id', 'order'=>'id desc'],
        'item' => ['Bt\Sales\Models\QuoteItemCatalogue','key'=>'item_id'],
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

    public function getItemOptions()
    {
        $list = array();
        if (isset($this->quote)) {
            $objcatalogue = QuoteItemCatalogue::where('quote_id', $this->quote->id)->get();
            $list = array();

            foreach ($objcatalogue as $item) {
                if (!empty($item->btproduct_id)) {
                    $list[$item->id] = $item->id.": ".$item->description.", QTY: ".$item->units.", Weight: ".$item->weight;
                }
            }
        }
        return $list;
    }


    public function getPlan()
    {
        if (isset($this->plan)) {
            $crested = ProductionPlan::find($this->plan->id);
            if (empty($crested)) {
                return $crested->startdate;
            }
        }

        return 0;
    }


    public function getQty()
    {
        $list = array();
        if (isset($this->item)) {
            $obj = QuoteItemCatalogue::find($this->item->id);

            if (empty($obj)) {
                return $obj->units;
            }
        }
        return 0;
    }
}
