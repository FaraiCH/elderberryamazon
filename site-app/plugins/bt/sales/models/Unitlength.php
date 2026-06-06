<?php namespace Bt\Sales\Models;

use Model;

/**
 * Unitlength Model
 */
class Unitlength extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_unitlengths';

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
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
