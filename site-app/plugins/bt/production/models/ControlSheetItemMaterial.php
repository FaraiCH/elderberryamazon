<?php namespace Bt\Production\Models;

use Model;

/**
 * ControlSheetItemMaterial Model
 */
class ControlSheetItemMaterial extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_cs_item_materials';

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
        'controlsheetitem' => ['Bt\Production\Models\ControlSheetItem','key'=>'control_sheet_item_id'],
        'controlsheetqcitem' => ['Bt\Production\Models\ControlSheetQcItem','key'=>'control_sheet_qc_item_id'],
        'material' => ['Bt\Production\Models\Controlmaterial','key'=>'material_id'],
      
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
     ];
     public $belongsToMany = [];
     public $morphTo = [];
     public $morphOne = [];
     public $morphMany = [];
     public $attachOne = [];
     public $attachMany = [];
     public function beforeSave()
     {
         $this->kg_value = $this->kg_unit * $this->material->kg_per_measurement;
     }
}
