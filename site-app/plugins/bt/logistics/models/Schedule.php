<?php namespace Bt\Logistics\Models;

use Model;
use BackendAuth;

/**
 * Schedule Model
 */
class Schedule extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_logistics_schedules';
    
    public $rules = [
        'schedule_date' => 'required',
        'return_date' => 'required',
       
        'department' => 'required',
        'vehicle' => 'required',
    ];


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'logisticapprove' =>['Bt\Logistics\Models\Logisticapprove','key' => 'schedule_id','other'=>'id'],
    ];
    public $hasMany = [];
    
    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'vehicle' => ['Bt\Logistics\Models\Vehicle','key'=>'vehice_id'],
        'department' =>['Bt\HR\Models\Department','key'=>'department_id'],
        'usagetype' =>['Bt\Logistics\Models\UsageType','key'=>'usagetype_id'],

        'driver' =>['Bt\Logistics\Models\Driver','key'=>'driver_id'],
        
         'requestby' =>['Backend\Models\User','key'=>'requestedby_id','other'=>'id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'damage_images' => 'System\Models\File',
        'damage_files' => 'System\Models\File',
        'trafficoffense_images' => 'System\Models\File',
        'trafficoffense_files' => 'System\Models\File',
        'delivery_files' => 'System\Models\File',
    ];
    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }
}
