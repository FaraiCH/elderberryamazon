<?php namespace Bt\Sales\Models;

use Model;

/**
 * TransportFee Model
 */
class TransportFee extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_transport_fees';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = ['id','destination','active','date','ton','ton_trailer','ton_trailer_min_6m','ten_ton_12m_trailer','trailer_12m','trailer_18m', 'bt_ton','bt_ton_trailer','bt_ton_trailer_min_6m','bt_ten_ton_12m_trailer','bt_trailer_12m','bt_trailer_18m', 'eight_ton', 'bt_eight_ton', 'ton_min_6m_bed', 'bt_ton_min_6m_bed', 'bt_four_ton_trailer', 'four_ton_trailer'];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
      'transportratesdestination' => ['Bt\Sales\Models\TransportRatesDestination','key'=>'transportratesdestination_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function  getActiveOptions(){
        return ['No', 'Yes'];
    }
}
