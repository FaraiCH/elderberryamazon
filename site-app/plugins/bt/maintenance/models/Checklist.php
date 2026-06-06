<?php namespace Bt\Maintenance\Models;

use Model;
use BackendAuth;

/**
 * Checklist Model
 */
class Checklist extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_checklists';

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
        'checkpoints' =>['Bt\Maintenance\Models\Checkpoint','key'=>'checklist_id', 'order'=>'orderby'],
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
