<?php namespace Bt\Inventory\Models;

use Model;

/**
 * StockOut Model
 */
class StockOut extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_stock_outs';

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
    public $hasMany = [];
    public $belongsTo = ['user' => 'RainLab\User\Models\User'];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = ['file' => 'System\Models\File'];
    public $attachMany = [];
    
}
