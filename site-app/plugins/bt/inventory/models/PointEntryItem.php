<?php namespace Bt\Inventory\Models;

use Model;

/**
 * PointEntryItem Model
 */
class PointEntryItem extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_point_entry_items';

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
    'pointofentry' =>['Bt\Inventory\Models\PointEntryItem','key'=>'point_entry_item_id'],
    'receivedtypes' =>['Bt\Inventory\Models\RecievedType','key'=>'received_in'],
    'floorblock' =>['Bt\Inventory\Models\StockRoomBlock','key'=>'stock_room_blocks_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
