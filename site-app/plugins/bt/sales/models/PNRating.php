<?php namespace Bt\Sales\Models;

use Model;

/**
 * PNRating Model
 */
class PNRating extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_p_n_ratings';

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
