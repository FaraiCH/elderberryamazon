<?php namespace Bt\Maintenance\Models;

use Model;
use BackendAuth;

/**
 * ToolsChecklist Model
 */
class ToolsChecklist extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_tools_checklists';
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'checklist' => 'required',
        'status' => 'required',
        'scheduledate' => 'required',
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
        'tool' => ['Bt\Maintenance\Models\Tools','key'=>'tool_id'],
        'checklist' => ['Bt\Maintenance\Models\Checklist','key'=>'checklist_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
        'condition' => ['Bt\Maintenance\Models\ToolCondition','key'=>'condition_id'],
        'assignedto' => ['Bt\Maintenance\Models\Staff','key'=>'assignedto_id'],

    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'files' => 'System\Models\File'
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
