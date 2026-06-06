<?php namespace Bt\Maintenance\Models;

use Model;

/**
 * Tools Model
 */
class Tools extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_tools';

    use \October\Rain\Database\Traits\Validation;
    public $rules = [

        'name' => 'required',
        'equipment_type' => 'required',
        'quantity' => 'required',

    ];

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
    public $hasOne = [

    ];
    public $hasMany = [
        'usage' => ['Bt\Maintenance\Models\ToolsUsage','key'=>'tool_id'],
        'checklist' => ['Bt\Maintenance\Models\ToolsChecklist','key'=>'tool_id'],
    ];
    public $belongsTo = [
     'vendor' => ['Bt\Maintenance\Models\Vendor','key'=>'vendor_id'],
     'equipment_type' => ['Bt\Maintenance\Models\EquipmentType','key'=>'equipment_type_id'],
     'quantitytype' => ['Bt\Maintenance\Models\UnitType','key'=>'unittype_id'],
     'fileawayyes' => ['Bt\Maintenance\Models\YesNo','key'=>'fileaway'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'files' => 'System\Models\File',
        'images' => 'System\Models\File'
    ];

    public function scopeMachine($query)
    {
        $query->where('is_diesel', 1);
    }

}
