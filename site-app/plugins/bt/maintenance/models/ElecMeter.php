<?php namespace Bt\Maintenance\Models;

use Model;
use BackendAuth;
/**
 * ElecMeter Model
 */
class ElecMeter extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_elec_meters';

    use \October\Rain\Database\Traits\Validation;
    public $rules = [

        'name'                  => 'required'
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
    public $hasOne = [
        'btline' => ['Bt\Production\Models\Line', 'key' => 'bt_meter_id']
    ];
    public $hasMany = [
        'readings' =>['Bt\Maintenance\Models\ElecMeterReading','key'=>'meter_id'],
    ];
    public $belongsTo = [
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];

    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'files' => 'System\Models\File',
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

    public function LastUpdated(){
        return Electricity::where('meter_no', $this->id)->orderBY('created_at', 'desc')->first();
    }
}
