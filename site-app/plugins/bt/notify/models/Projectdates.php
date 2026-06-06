<?php namespace Bt\Notify\Models;

use Model;
use BackendAuth;

/**
 * Projectdates Model
 */
class Projectdates extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_notify_projectdates';
     use \October\Rain\Database\Traits\Validation;


    public $rules = [
        'project'  => 'required',
        'projectdate'  => 'required',        
        'title'  => 'required',  
        'body'  => 'required',        

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
        'project' => ['Bt\Finance\Models\Project','key'=>'project_id'],        
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
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
