<?php namespace Bt\QC\Models;

use Model;

/**
 * DataPackIndex Model
 */
class DataPackIndex extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_qc_data_pack_indices';

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
