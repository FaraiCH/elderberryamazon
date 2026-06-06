<?php namespace Bt\Floor\Models;

use Model;

/**
 * Stocksize Model
 */
class Stocksize extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_floor_stocksizes';

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
