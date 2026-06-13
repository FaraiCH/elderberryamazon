<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;
use Bt\Sales\Models\Newquote as QuoteModel;
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
 * ConcessionForm Component
 */
class ConcessionForm extends ComponentBase
{

    public $concession = "";
    public $invalidmessage = "";
    public function componentDetails()
    {
        return [
            'name' => 'ConcessionForm Component',
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

        $this->concession =  QuoteModel::where('id', $myID)->where('key_pass', $mypasskey)->first();
        if(empty($this->concession)){
            $this->invalidmessage = "INVALID PAGE";
        }
    }

    public function onSave(){
        $concession = QuoteModel::where('id',$this->property('id'))->where('key_pass',$this->property('key_pass'))->first();
        if(isset($concession->id)){
            $concession->accept_date = now();
            $concession->save();
             $this->myResponse($concession->id);
            return Redirect("/concessions/form/" . $this->property('id')."/" . $this->property('key_pass'). "/thankyou");
        }else{
            \Flash::error('This invitation page is invalid');
        }

    }
    public function myResponse($id)
    {
        $obj = QuoteModel::find($this->property('id'));
        $user = BackendAuth::getUser();
        if (!$user) return;
        if ($user) {
            $name = $user->first_name . ' ' . $user->last_name;
        }

        ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/sales/newquote/preview/'.$id;

        $link = "
        * View List: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 35)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $obj->user;
            $data['response_details'] = $obj;
            $data['response_link'] = $link;
               Mail::send('bt.notify.concession.return', $data, function($message) use ($data) {
                $message->subject("Non-SABS Concession Form: ");
                $message->to($data['to_email'], $data['name']);
            });
        }
        \Flash::success( "Thank you, email has been sent");
    }
}
