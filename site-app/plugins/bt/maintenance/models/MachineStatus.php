<?php namespace Bt\Maintenance\Models;

use Model;

/**
 * MachineStatus Model
 */
class MachineStatus extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_machine_statuses';

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
