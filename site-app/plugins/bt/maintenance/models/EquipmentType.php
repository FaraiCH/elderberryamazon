<?php namespace Bt\Maintenance\Models;

use Model;

/**
 * EquipmentType Model
 */
class EquipmentType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_equipment_types';

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
