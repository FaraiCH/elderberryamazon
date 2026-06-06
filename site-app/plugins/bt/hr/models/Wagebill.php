<?php namespace Bt\Hr\Models;

use Model;

/**
 * Wagebill Model
 */
class Wagebill extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_hr_wagebills';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'shift' => 'required',
        'employee' => 'required',
        'date' => 'required'
        ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'employee' => ['Bt\HR\Models\Employee',  'key'=>'employee_id'],
        'leavetype' => ['Bt\HR\Models\Leavetype', 'key' => 'comments'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getComment()
    {
        $leavetype = Leavetype::all();
        $leaveObj = array();
        foreach ($leavetype as $leave){
            $leaveObj[$leave->id] = $leave->name;
        }
        return $leaveObj;
    }
    public function scopeFilterByDepartment($query, $filter){
        return $query->whereHas('employee', function($group) use ($filter) {
            $group->whereIn('department_id', $filter);
        });
    }
}
