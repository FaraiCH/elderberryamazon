<?php namespace Bt\Sales\Models;

use Model;

/**
 * QuoteEmail Model
 */
class QuoteEmail extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_quote_emails';

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
        'status' => ['Bt\Sales\Models\EmailStatus','key'=>'email_status'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
