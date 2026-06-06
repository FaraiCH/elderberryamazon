<?php

namespace Bt\Maintenance\Classes;
use Backend\Facades\BackendAuth;
use DateTime;
use Bt\Maintenance\Models\ToolsChecklist;
use Bt\Sales\Models\DeliveryPlan;

class Upcomingevent {

    public static function getTotal() {
    	$date = new DateTime('NOW');
    	$startdate = $date->format('Y-m-d');
    	date_add($date, date_interval_create_from_date_string('10 days'));
    	$enddate = $date->format('Y-m-d');
        $unread = ToolsChecklist::whereBetween('scheduledate', array($startdate, $enddate))->count();
        return ($unread > 0) ? $unread : null;
    }

    public static function getDeliveryTotal() {
    	$date = new DateTime('NOW');
    	$startdate = $date->format('Y-m-d');
    	date_add($date, date_interval_create_from_date_string('10 days'));
    	$enddate = $date->format('Y-m-d');
        $unread = DeliveryPlan::whereBetween('schedule_date', array($startdate, $enddate))->count();
        return ($unread > 0) ? $unread : null;
    }

    public static function getJobcardTotal(){
        $obj = BackendAuth::getUser();
        $email = $obj->email;
        if($obj->hasPermission('bt.jobcard.management')){
            $not_completed = \Bt\Maintenance\Models\JobCard::where('status_id', '<>', 5)->count();
            return  $not_completed;
        }else{
            $supervisor = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 1)->first();
            $tech = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 0)->first();
            if(!empty($tech)){
               return \Bt\Maintenance\Models\JobCard::where('assignedto_id', $tech->id)->count();
            }
            if(!empty($supervisor)){
                return \Bt\Maintenance\Models\JobCard::where('supervisor_id', $supervisor->id)->count();
            }
        }

    }

    public static function getNewJobcardTotal(){
        return 3;
        $obj = BackendAuth::getUser();
        $email = $obj->email;
        if($obj->hasPermission('bt.jobcard.management')){
            $not_completed = \Bt\Maintenance\Models\JobCard::where('status_id', '<>', 5)->count();
            return  $not_completed;
        }else{
            $supervisor = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 1)->first();
            $tech = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 0)->first();
            if(!empty($tech)){
               return \Bt\Maintenance\Models\JobCard::where('assignedto_id', $tech->id)->count();
            }
            if(!empty($supervisor)){
                return \Bt\Maintenance\Models\JobCard::where('supervisor_id', $supervisor->id)->count();
            }
        }

    }





}

?>
