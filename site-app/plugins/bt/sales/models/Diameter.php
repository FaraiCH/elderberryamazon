<?php namespace Bt\Sales\Models;

use Model;

/**
 * Diameter Model
 */
class Diameter extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_diameters';

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
        'minimumrun' => 'Bt\Production\Models\Minimumrun', 'key' => 'diameter_id'
    ];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
