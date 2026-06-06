<?php
 namespace RW\PLCommon\Classes;
 use BackendAuth;
use RainLab\User\Models\UserGroup;
use RW\PLCommon\Models\TrackUserVisits;
class Substuff {

    static function protocolUrl($url){
        $protocol = 'http://';
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        }
        return $protocol.$_SERVER['SERVER_NAME'].$url;
    }
     static function protocolSimple(){
        $protocol = 'http://';
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        }
        return $protocol.$_SERVER['SERVER_NAME'];
    }
 
    
    static function getListUsers($id){
        
        $groupusers = UserGroup::where('id', $id)->first();
        $obj = [];
        if(!empty($groupusers) && isset($groupusers->users))
        foreach ($groupusers->users as $key => $value) {
            $obj[$value->id] =  $value->name." ". $value->surname;
        }
       
        return $obj;
    }
    static function TrackUserVisits($page){
        $user = BackendAuth::getUser();
        if (!$user) return;
        $find = TrackUserVisits::where('user_id',$user->id)->orderby('id','desc')->first();
        if(empty($find)){
              
            $new = new TrackUserVisits();
            $new->user_id = $user->id;
            $new->url = $_SERVER['REQUEST_URI'];
            $new->pagetitle = $page->pageTitle;
            $new->save();
        
        }else{
             if($find->url != $_SERVER['REQUEST_URI'] ){
                $new = new TrackUserVisits();
                $new->user_id = $user->id;
                $new->url = $_SERVER['REQUEST_URI'];
                $new->pagetitle = $page->pageTitle;
                $new->save();
            }
        }
       
    }

    static function PrintMoreBacks(){
         $user = BackendAuth::getUser();
        if (!$user) return;
        $find = TrackUserVisits::where('user_id',$user->id)->where("url",'<>', $_SERVER['REQUEST_URI'])->orderby('id','desc')->take(5)->get();
        $print = "";
        if(!empty($find)){
            $print = '<div class="dropup  "><a href="#" data-toggle="dropdown" class="btn btn-primary oc-icon-plus">Add small</a>';
            $print .= '<ul class="dropdown-menu" role="menu" data-dropdown-title="Add something small">';
            foreach ($find as $key => $value) {
                $print .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$value->url.'" class="oc-icon-folder">'.$value->pagetitle.'</a></li>';
            }
            $print .= '</ul></div>';
        }
        return $print;
    
    }
    static function PrintOneBack(){
         $user = BackendAuth::getUser();
        if (!$user) return;
        $find = TrackUserVisits::where('user_id',$user->id)->where("url",'<>', $_SERVER['REQUEST_URI'])->orderby('id','desc')->first();
        $print = "";
        if(!empty($find))
        $print = '<a  href="'.$find->url.'" >Back To '.$find->pagetitle.'</a>';
        return $print;

    
    }

    static function rand($number){

        return "R ".number_format(is_numeric($number)?$number:0,2, '.', ',');
    }

    static function randmin($number){

        return "R ".number_format(is_numeric($number)?$number:0,0, '.', ',');
    }
    
    static function pnumber($number){

        return number_format(is_numeric($number)?$number:0,0, '.', ',');
    }

}