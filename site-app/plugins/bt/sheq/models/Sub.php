<?php namespace Bt\SHEQ\Models;

use Model;
use BackendAuth;
/**
 * Sub Model
 */
class Sub extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sheq_subs';
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
    public $hasOne = [];
     public $hasMany = [
       
        'documents' =>['Bt\SHEQ\Models\Document','key'=>'sub_id'],
    ];
    public $belongsTo = [
        'category' =>['Bt\SHEQ\Models\Category','key'=>'category_id'],
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
