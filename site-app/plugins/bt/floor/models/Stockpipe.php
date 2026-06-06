<?php namespace Bt\Floor\Models;

use Model;

/**
 * Stockpipe Model
 */
class Stockpipe extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_floor_stockpipes';

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
    'product' => ['Bt\Sales\Models\Product','key'=>'product_id'],
    'diameter' => ['Bt\Sales\Models\Diameter','key'=>'pipediameter'],
    'type' => ['Bt\Floor\Models\Stocktype','key'=>'stocktype_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
