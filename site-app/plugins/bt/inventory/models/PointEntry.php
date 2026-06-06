<?php namespace Bt\Inventory\Models;

use Model;

/**
 * PointEntry Model
 */
class PointEntry extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_point_entries';

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
    public $hasOne = [];
    public $hasMany = ['listitems' =>['Bt\Inventory\Models\PointEntryItem','key'=>'point_entry_id'],];
  
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    public $belongsTo = [
        'user' => 'RainLab\User\Models\User',
        'inventorytypes' =>['Bt\Inventory\Models\InventoryType','key'=>'inventory_type'],
        'entrytypes' =>['Bt\Inventory\Models\EntryType','key'=>'point_of_entry'],
        
        
        
    ];
}
