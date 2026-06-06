<?php namespace Bt\Production\Models;

use Model;
use Bt\Sales\Models\PNRating;

/**
 * Line Model
 */
class Line extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_lines';

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
      'btmeter' => ['Bt\Maintenance\Models\ElecMeter','key'=>'bt_meter_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    protected $jsonable = [
        'pipes',
        ];

    public function getPipeOptions(){
        return PNRating::pluck("name","id");
    }


}
