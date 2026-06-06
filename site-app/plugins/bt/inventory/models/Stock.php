<?php namespace Bt\Inventory\Models;

use Model;

/**
 * Stock Model
 */
class Stock extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_stocks';

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
    public $belongsTo = [
    'user' => 'RainLab\User\Models\User',
    'productname' =>['Bt\Inventory\Models\PartNames','key'=>'part_name_id'],
  
    'stockout' =>['Bt\Inventory\Models\StockOut','key'=>'stock_out_id'],
    'receivedtypes' =>['Bt\Inventory\Models\RecievedType','key'=>'received_in']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
