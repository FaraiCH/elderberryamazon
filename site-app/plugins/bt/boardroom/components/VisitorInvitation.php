<?php namespace Bt\Boardroom\Components;

use Cms\Classes\ComponentBase;
use Bt\Boardroom\Models\Visitor as VisitorModel;
use Carbon;
use Backend\Models\User;
use RainLab\User\Models\UserGroup;
use BackendAuth;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;
/**
 * VisitorInvitation Component
 */
class VisitorInvitation extends ComponentBase
{

    public $myvisitor = "";
    public $invalidmessage = "";
    public function componentDetails()
    {
        return [
            'name' => 'VisitorInvitation Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $myID = $this->property('id');
        $mypasskey = $this->property('key_pass');

        $this->myvisitor =  VisitorModel::where('id', $myID)->where('key_pass', $mypasskey)->first();
        if(empty($this->myvisitor)){
            $this->invalidmessage = "INVALID PAGE";
        }
    }

    public function onSave(){
        $myvisitors = VisitorModel::where('id',$this->property('id'))->where('key_pass',$this->property('key_pass'))->first();
        if(isset($myvisitors->id)){
            $myvisitors->accept_date = now();
            $myvisitors->save();
             $this->myResponse($myvisitors->id);
            return Redirect("/visitors/induction/" . $this->property('id')."/" . $this->property('key_pass'). "/thankyou");
        }else{
            \Flash::error('This invitation page is invalid');
        }

    }

    public function myResponse($id)
    {
        $obj = VisitorModel::find($this->property('id'));
        $user = BackendAuth::getUser();
        if (!$user) return;
        if ($user) {
            $name = $user->first_name . ' ' . $user->last_name;
        }

        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/boardroom/visitor/preview/'.$id;

        $link = "
        * View Visitor: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 35)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $obj->visitorname;
            $data['response_details'] = $obj;
            $data['response_link'] = $link;
               Mail::send('bt.notify.visit.return', $data, function($message) use ($data) {
                $message->subject("Visit Acceptance: ");
                $message->to($data['to_email'], $data['name']);
            });
        }
        \Flash::success( "Thank you, email has been sent");
    }


}
