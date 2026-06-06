<?php
namespace RW\PLCommon\Classes;
use DateTime;
use RW\PLAdmin\Models\ClientRequest;
use RW\PLTask\Models\Task as TaskModel;
use RW\PLProperties\Models\Property as pmodule;
class Upcomingevent {

    // public static function getTotal() {
    //     $date = new DateTime('NOW');
    //     $startdate = $date->format('Y-m-d');
    //     date_add($date, date_interval_create_from_date_string('10 days'));
    //     $enddate = $date->format('Y-m-d');
    //     $unread = ToolsChecklist::whereBetween('scheduledate', array($startdate, $enddate))->count();
    //     return ($unread > 0) ? $unread : null;
    // }

    public static function getRequestServiceTotal() {
        
        // $unread = ClientRequest::where('read', false)->count();
        $unread = ClientRequest::where("admin_user__id",0)->orwherenull("admin_user__id")->active()->count();
        return ($unread > 0) ? $unread : 0;
    }


    

    public static function getPropetyVerification() {
        
        $unread = pmodule::whereDoesntHave('municipality')->count();
        return ($unread > 0) ? $unread : null;
    }
   public static function getRequestServicePool() {
        
        $unread = ClientRequest::where(function ($query) {
            $query->whereNUll('admin_user__id')
                ->orWhere('admin_user__id',0);
                })->active()->count();
        return ($unread > 0) ? $unread : null;
    }

      public static function getQuotationPool() {
        
        $unread = TaskModel::where('task__name_lookup__id',53)->where(function ($query) {
            $query->whereNUll('task__padmin_user__id')
                // ->orWhereNull('task__valuer_user__id')
                // ->orWhere('task__valuer_user__id',0)
                ->orWhere('task__padmin_user__id',0);
                })->count();

        $count =  ($unread > 0) ? $unread : 0;

        $unread = TaskModel::whereIn('task__name_lookup__id',[138,189])->where(function ($query) {
            $query->whereNUll('task__padmin_user__id')
                ->orWhereNull('task__valuer_user__id')
                ->orWhere('task__valuer_user__id',0)
                ->orWhere('task__padmin_user__id',0);
                })->count();

        $count_2 =  ($unread > 0) ? $unread : 0;

          $unread = TaskModel::whereIn('task__name_lookup__id',[206])->where(function ($query) {
            $query->whereNUll('task__padmin_user__id')
              
                ->orWhere('task__padmin_user__id',0);
                })->count();
        $count_3 =  ($unread > 0) ? $unread : 0;

        return (($count_2 + $count + $count_3 ) > 0) ? ($count_2 + $count + $count_3 ) : null;
    }




    

}

?>
