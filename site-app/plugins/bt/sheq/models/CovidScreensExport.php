<?php namespace Bt\SHEQ\Models;

use Model;
use BackendAuth;
/**
 * CovidScreens Model
 */
class CovidScreens extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sheq_covid_screens';

    use \October\Rain\Database\Traits\Validation;


    public $rules = [
        
        'capturedate'  => 'required',
        'no_screen'  => 'required',
        'no_infected'  => 'required',
        'highest_temperature'  => 'required',
        'potential_infection' =>  'required',
       
        
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
    public $hasMany = [];
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
        'images' => 'System\Models\File'
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
