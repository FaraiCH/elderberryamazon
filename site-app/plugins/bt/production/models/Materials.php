<?php namespace Bt\Production\Models;

use Model;

/**
 * Materials Model
 */
class Materials extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_materials';

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
    public $hasOne = [
    
];
    public $hasMany = [];
    public $belongsTo = [
        'productname' =>['Bt\Inventory\Models\PartNames','key'=>'part_name_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
