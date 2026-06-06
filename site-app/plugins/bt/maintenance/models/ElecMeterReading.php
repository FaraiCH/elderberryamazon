<?php namespace Bt\Maintenance\Models;

use Model;
use BackendAuth;

/**
 * ElecMeterReading Model
 */
class ElecMeterReading extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_elec_meter_readings';

     use \October\Rain\Database\Traits\Validation;
    public $rules = [
        
        'reading'                  => 'required',
        'readingdate'                  => 'required',
        
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
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
       
    ];
    public $belongsTo = [
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'image' => 'System\Models\File'
    ];
    public $attachMany = [];
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
