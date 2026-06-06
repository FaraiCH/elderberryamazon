<?php namespace Bt\Sales\Models;

use Model;

/**
 * QuoteStatus Model
 */
class QuoteStatus extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_quote_statuses';

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
        'actionrel' => ['Bt\Sales\Models\ActionToGroup','key'=>'quote_statuses_id'],

    ];
    public $belongsTo = [
            'emailgroup' => ['RainLab\User\Models\UserGroup', 'key' => 'email_groups_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
