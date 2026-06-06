<?php namespace Bt\Production\Models;

use Bt\Inventory\Models\RawMaterialReceiving;
use Bt\Inventory\Models\StockRelease;
use Model;

/**
 * Controlmaterial Model
 */
class Controlmaterial extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_production_controlmaterials';

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
        'measurement' => 'required',
        'kg_per_measurement' => 'required',
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
        'controlsheet' => ['Bt\Production\Models\ControlSheet']
    ];
    public $hasMany = [];
    public $belongsTo = [
        'material' =>['Bt\Inventory\Models\RawMaterialReceiving','key'=>'material_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    public function getmaterialOptions()
    {
        $obj = RawMaterialReceiving::active()->get();
        $listarray = array();

        foreach ($obj as $key => $value) {
            $listarray[$value->id] =  $value->productname->name." -> Date Recieved: ".\Carbon\Carbon::parse($value->date_of_receipt)->format('d/m/Y').", Batch: ".$value->supplier_batch.", Weight: ".$value->weight." kg, MFI: ".$value->mfi;
        }

        return $listarray;
    }

    public function getMeasurementOptions()
    {
        return [1=> 'Bag', 2=> 'Bucket', 3=> 'Cup'];
    }

    public function getMeasures()
    {
        $value = array_get($this->attributes, 'measurement');
        if (!isset($value)) {
            return null;
        }
        return array_get($this->getMeasurementOptions(), $value);
    }
    public function filterFields($fields, $context = null)
    {
        $control_mat_obj = Controlmaterial::find($this->id);
        if ($context == 'update') {
            if ($control_mat_obj->measurement == $this->measurement) {
                $fields->kg_per_measurement->value = $control_mat_obj->kg_per_measurement;
            } else {
                if ($this->getMeasures() == 'Bag') {
                    $fields->kg_per_measurement->value = 25;
                }
                if ($this->getMeasures() == 'Bucket') {
                    $fields->kg_per_measurement->value = 10;
                }
                if ($this->getMeasures() == 'Cup') {
                    $fields->kg_per_measurement->value = 3;
                }
            }
        } else {
            if ($this->getMeasures() == 'Bag') {
                $fields->kg_per_measurement->value = 25;
            }
            if ($this->getMeasures() == 'Bucket') {
                $fields->kg_per_measurement->value = 10;
            }
            if ($this->getMeasures() == 'Cup') {
                $fields->kg_per_measurement->value = 3;
            }
        }
    }
}
