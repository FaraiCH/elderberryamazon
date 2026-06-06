<?php namespace Bt\Production\Models;

use Model;

/**
 * ScrapCodes Model
 */
class ScrapCodes extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_scrap_codes';

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
