<?php namespace Bt\Maintenance\Models;

use Model;

/**
 * Schedule Model
 */
class Schedule extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_maintenance_schedules';

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
        'btline' => ['Bt\Maintenance\Models\Department','key'=>'line_id'],
        //'department' => ['Bt\Maintenance\Models\Department','key'=>'line_id'],
        'actiontype' => ['Bt\Maintenance\Models\ActionType','key'=>'actiontype_id'],
        'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
        'assignedto' => ['Bt\Maintenance\Models\Staff','key'=>'assignedto_id'],
        'completedby' => ['Bt\Maintenance\Models\Staff','key'=>'completedby_id'],
        'machinestatus' => ['Bt\Maintenance\Models\MachineStatus','key'=>'machine_off'],

    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'files' => 'System\Models\File'
    ];

     public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
