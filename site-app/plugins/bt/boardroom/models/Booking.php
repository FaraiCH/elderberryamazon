<?php namespace Bt\Boardroom\Models;

use Aws\EMRContainers\Exception\EMRContainersException;
use Bt\HR\Models\Department;
use Model;
use BackendAuth;
use System\Helpers\DateTime;

/**
 * Booking Model
 */
class Booking extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_boardroom_bookings';

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
        'date'    => 'required',
        'start_time'    => 'required',
        'subject'    => 'required',
        'duration'    => 'required',
        'bookedby'    => 'required',
        'no_of_attendees'    => 'required',
        'booking_type'    => 'required',
        'boardroom_name'    => 'required',
        'departments'    => 'required',


    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = ['departments'];

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
    public $hasOne = [

      'bookingapproval' => ['Bt\Boardroom\Models\BookingApproval','key'=>'booking_id'],
    ];
    public $hasMany = [];
    public $belongsTo = [
      'department' =>['Bt\HR\Models\Department','key'=>'department_id'],
      'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
      'bookedby' => ['RainLab\User\Models\User','key'=>'bookedby_id','other'=>'id'],
       'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
       'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
       'approvedby' => ['RainLab\User\Models\User','key'=>'approvedby_id','other'=>'id'],
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

        //filter duration when start_time is selected
        if (isset($this->start_time)) {
            //first, we need to get the start_time attribute
            $start_time = $this->start_time;
            $datetime = new \DateTime($start_time);
            //convert the start_time format to time only
            $time_only = $datetime->format('H:i:s');
            $schedule_date = new \DateTime($this->date);
            //Convert Schedule Date to date only
            $date_only = $schedule_date->format('Y-m-d');
            //Ge full date
            $full_date = new \DateTime($date_only . " " . $time_only);
            if (!empty($this->getDurations())) {
                $additions = '+' .$this->getDurations(). ',-1 minute';

                $fullthirty = $full_date->modify($additions)->format('H:i:s');

                $bookingObj = self::notAvailableBetween($time_only, $fullthirty)->where('date', $date_only)->orderBy('end_time', 'DESC')->get();
                $allbooking = Booking::where('date', $date_only)->orderBy('end_time', 'DESC')->get();
                if ($bookingObj->count('id') == 0) {
                    $this->status_id = 1;
                    $this->end_time = $fullthirty;
                } else {
                    \Flash::error("Cannot Use This Time Slot");
                    throw new \ValidationException(['message' => "Cannot Use This Time Slot"]);

                }
            }
        }
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;

        //filter duration when start_time is selected
        if (isset($this->start_time)) {
            //first, we need to get the start_time attribute
            $start_time = $this->start_time;
            $datetime = new \DateTime($start_time);
            //convert the start_time format to time only
            $time_only = $datetime->format('H:i:s');
            $schedule_date = new \DateTime($this->date);
            //Convert Schedule Date to date only
            $date_only = $schedule_date->format('Y-m-d');
            //Ge full date
            $full_date = new \DateTime($date_only . " " . $time_only);
            if (!empty($this->getDurations())) {
                $additions = '+' .$this->getDurations(). ',-1 minute';

                $fullthirty = $full_date->modify($additions)->format('H:i:s');

                $bookingObj = self::notAvailableBetween($time_only, $fullthirty)->where('date', $date_only)->orderBy('end_time', 'DESC')->get();
                $allbooking = Booking::where('date', $date_only)->orderBy('end_time', 'DESC')->get();
                if ($bookingObj->count('id') == 0) {
                    $this->status_id = 1;
                    $this->end_time = $fullthirty;
                }
            }
        }
    }

    public function scopeActive($query)
    {
        return $query->where('booking_type', 1);
    }

    public static $booking_type = array(1=>'Internal',0 =>"External");

    public function getBookingTypeOptions()
    {
         return self::$booking_type;
    }

    public static $boardroom_name = array(1=>'Boardroom');

    public function getBoardroomNameOptions()
    {
         return self::$boardroom_name;
    }
    public static $status = array(1=>'Schedule', 2=>'Cancelled', 3=>'Re-Schedule');

    public function getStatusOptions()
    {
         return self::$status;
    }

    public function check()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        return $user->id;
    }

    public function getDurationOptions()
    {

        return [
            0 => '30 minutes', 1 => '1 hour', 2 => '1 hour, 30 minutes', 3 => '2 hours',
            4 => '2 hours, 30 minutes', 5 => '3 hours', 6 => '3 hours, 30 minutes',
            7 => '4 hours', 8 => '4 hours, 30 minutes', 9 => '5 hours', 10 => '5 hours, 30 minutes',
            11 => '6 hours', 12 => '6 hours, 30 minutes', 13 => '7 hours', 14 => '7 hours, 30 minutes',
            15 => '8 hours'
        ];
    }
    public function getDurations()
    {
        $value = array_get($this->attributes, 'duration');
        if (!isset($value)) {
            return null;
        }
        return array_get($this->getDurationOptions(), $value);
    }
    public function filterFields($fields, $context = null)
    {
        //filter duration when start_time is selected
        if (isset($this->start_time)) {
            //first, we need to get the start_time attribute
            $start_time = $this->start_time;
            $datetime = new \DateTime($start_time);
            //convert the start_time format to time only
            $time_only = $datetime->format('H:i:s');
            $schedule_date = new \DateTime($this->date);
            //Convert Schedule Date to date only
            $date_only = $schedule_date->format('Y-m-d');
            //Ge full date
            $full_date = new \DateTime($date_only . " " . $time_only);
            if (!empty($this->getDurations())) {
                $additions = '+' .$this->getDurations(). ',-1 minute';

                $fullthirty = $full_date->modify($additions)->format('H:i:s');
                //Check if thirty minutes exists in this period

                $bookingObj = self::notAvailableBetween($time_only, $fullthirty)->where('date', $date_only)->orderBy('end_time', 'DESC')->get();
                $allbooking = Booking::where('date', $date_only)->orderBy('end_time', 'DESC')->get();
                if ($bookingObj->count('id') == 0) {
                    if (isset($fields->departments)) {
                        $fields->section1->comment = "<h3 style='background: green; color: white'>Time Slot Is Available</h3>";
                    }
                } else {
                    foreach ($allbooking as $booking) {
                        $chosen_time = new \DateTime($date_only . " " . $booking->end_time);
                        $fullchosen = "\nDate: ". $booking->date . " | Time: " . $chosen_time->modify("+1 minute")->format('H:i:s');
                        break;
                    }
                    if (isset($fields->departments)) {
                        if (empty($this->id)) {
                            // Show section1 if id is empty
                            $fields->section1->hidden = false;
                            $fields->section1->comment = "<div style='background: maroon; color: white'><h3>This Time is Booked. Please Choose Another Slot.</h3><h4 > Suggested Slot: {$fullchosen}</h4></div>";
                        } else {
                            // Hide section1 if id is not empty
                            $fields->section1->hidden = false;
                            $fields->section1->comment = "<div style='background: maroon; color: white'><h3>This Time is Booked. Please Choose Another Slot.</h3><h4 > Suggested Slot: {$fullchosen}</h4></div>";
                        }
                    }
                }
            }
        }
    }

    public function scopeNotAvailableBetween($query, $start_time, $end_time)
    {
        return $query->where(function ($query) use ($start_time, $end_time) {
            $query->whereBetween('start_time', [$start_time, $end_time])
                ->orWhereBetween('end_time', [$start_time, $end_time])
                ->orWhere(function ($query) use ($start_time, $end_time) {
                    $query->where('start_time', '<', $start_time)
                        ->where('end_time', '>', $end_time);
                });
        });
    }

    public function showDepartments($id)
    {
        $match_booking = self::find($id);
        if (!empty($match_booking->departments)) {
            foreach ($match_booking->departments as $dep) {
                $mydepartment = Department::find($dep['department']);
                if(isset($mydepartment->name))
                    echo '<p>'. $mydepartment->name .'</p>';
            }
        } else {
            if (isset($match_booking->department)) {
                echo '<p>'. $match_booking->department->name . '</p>';
            }
        }
    }
}
