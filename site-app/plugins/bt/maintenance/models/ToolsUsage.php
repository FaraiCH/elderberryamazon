<?php namespace Bt\Maintenance\Models;

use Model;
use BackendAuth;

/**
 * ToolsUsage Model
 */
class ToolsUsage extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_tools_usages';
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'condition' => 'required',
        'usedby' => 'required',
        'inout' => 'required',
        'opendate' => 'required',
        'quantity' => 'required',
        'reason' => 'required',
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
     'usedby' => ['Bt\Maintenance\Models\Staff','key'=>'usedby_id'],
     'inout' => ['Bt\Maintenance\Models\InOut','key'=>'inout_id'],
     'condition' => ['Bt\Maintenance\Models\ToolCondition','key'=>'condition_id'],
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
