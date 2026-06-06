<?php namespace Bt\Production\Models;

use Model;
use Bt\Inventory\Models\RawMaterialReceiving;
/**
 * RawProductionPlanItem Model
 */
class RawProductionPlanItem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_production_raw_production_plan_items';

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

        'receiving' => 'required',

        'weight_kg' => 'required',
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
    public $hasMany = [

    ];
    public $belongsTo = [
        'receiving' => ['Bt\Inventory\Models\RawMaterialReceiving', 'key' => 'receiving_id'],
        'raw_material_plan' => ['Bt\Production\Models\RawProductionPlan', 'key' => 'raw_production_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getReceivingOptions(){
        $data = [];

        $recievings = RawMaterialReceiving::with('productname')->orderBy('id', 'DESC')->get();
        //$recievings = RawMaterialReceiving::with('productname')->first();
        //dd($recievings);

        foreach($recievings as $recieving) {
            $data[$recieving->id] = $recieving->id . ', Name: ' . $recieving->productname->name . ', Batch: ' . $recieving->supplier_batch;
        }

        return $data;
    }
}
