<?php namespace Bt\Maintenance\Models;

use Model;
use BackendAuth;
/**
 * Vendor Model
 */
class Vendor extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_vendors';

     use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'vendor_type' => 'required',
        
        'name' => 'required',
        
    ];

    /**
     * @var array Guarded fields
     */
   
    protected $jsonable = ['extra_contacts','audits']; 

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
     'vendor_type' => ['Bt\Maintenance\Models\VendorType','key'=>'vendor_type_id'],
     'country' =>['RainLab\Location\Models\Country','key'=>'country_id'],
    'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
    'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
    'beefile' => 'System\Models\File',
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
