<?php namespace Bt\HR\Models;

use Model;
use BackendAuth;
use DateTime;
use phpDocumentor\Reflection\Type;

/**
 * AbsenceLeave Model
 */
class AbsenceLeave extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_hr_absence_leaves';
    protected $jsonable = ['days'];
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
        'employee' =>['Bt\HR\Models\Employee','key'=>'employee_id'],
        'status' =>['Bt\HR\Models\LeaveStatus','key'=>'status_id'],
        'type' =>['Bt\HR\Models\Leavetype','key'=>'type_id'],

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

    public function getDaysAttribute()
    {
        $daysLeft = array();
        $date1 = new DateTime($this->start_date);
        $date2 = new DateTime($this->end_date);
        $difference =  $date1->diff($date2);

        return $difference->days;
    }
}
