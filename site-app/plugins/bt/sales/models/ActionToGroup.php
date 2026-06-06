<?php namespace Bt\Sales\Models;

use Model;

/**
 * ActionToGroup Model
 */
class ActionToGroup extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_action_to_groups';

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
            'group' => ['RainLab\User\Models\UserGroup', 'key' => 'user_groups_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
