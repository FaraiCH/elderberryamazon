<?php namespace Bt\Logistics\Models;

use Model;
use BackendAuth;

/**
 * Driver Model
 */
class Driver extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_logistics_drivers';

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
     public $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
       
     ];
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
     public $hasOne = [];
     public $hasMany = [];
     public $belongsTo = [];
     public $belongsToMany = [];
     public $morphTo = [];
     public $morphOne = [];
     public $morphMany = [];
     public $attachOne = [
     'driver_image' => 'System\Models\File',
     'drivers_licence' => 'System\Models\File',
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
