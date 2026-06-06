<?php namespace Bt\Inventory\Models;

use Model;

/**
 * InventoryType Model
 */
class InventoryType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_inventory_types';

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
    public $hasMany = [
       'batchPrefixes' => ['Bt\Inventory\Models\BatchPrefix','key'=>'inventory_type_id'],
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
