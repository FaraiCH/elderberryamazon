<?php namespace Bt\Production\Models;

use Model;
use BackendAuth;
use Bt\Sales\Models\Quoteitems;
/**
 * ProductionPlanItem Model
 */
class ProductionPlanItem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_production_plan_items';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'quote' => 'required',
        'item' => 'required',

        'qty' => 'required',
        'prodorder' => 'required',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'controlsheet' => ['Bt\Production\Models\ControlSheet'],
    ];
    public $hasMany = [];
    public $belongsTo = [
        'plan' => ['Bt\Production\Models\ProductionPlan','key'=>'plan_id'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id', 'order'=>'id desc'],
        'item' => ['Bt\Sales\Models\Quoteitems','key'=>'item_id'],
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
            $obj = Quoteitems::where('quote_id', $this->quote->id)->get();
            $list = array();
            foreach ($obj as $key => $value) {
                $list[$value->id] = $value->id.": ".$value->description.", QTY: ".$value->units.", Weight: ".$value->weight;
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
            $obj = Quoteitems::find($this->item->id);

            if (empty($obj)) {
                return $obj->units;
            }
        }
        return 0;
    }
}
