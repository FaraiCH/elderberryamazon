<?php namespace Bt\Floor\Models;

use Model;

/**
 * Scrappipe Model
 */
class Scrappipe extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_floor_scrappipes';

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
    'btline' => ['Bt\Production\Models\Line','key'=>'line_id'],
    'diameter' => ['Bt\Sales\Models\Diameter','key'=>'pipediameter'],
    
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
