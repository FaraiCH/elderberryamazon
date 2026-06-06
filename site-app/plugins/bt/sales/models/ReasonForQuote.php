<?php namespace Bt\Sales\Models;

use Model;

/**
 * ReasonForQuote Model
 */
class ReasonForQuote extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_reason_for_quotes';

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
