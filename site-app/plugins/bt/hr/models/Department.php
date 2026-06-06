<?php namespace Bt\HR\Models;

use Model;
/**
 * Department Model
 */
class Department extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_hr_departments';

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
        'employees' => ['Bt\HR\Models\Employee', 'key' => 'department_id']
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function noEmployees(){
        return $this->employees->where('is_user_active', 1)->count();
    }
}
