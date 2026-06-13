<?php namespace Bt\Maintenance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BackendAuth;
use Bt\HR\Models\Employee;
use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;
use Carbon\Carbon;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;
use Bt\Maintenance\Models\JobCard as ModelJobCard;
use RainLab\User\Models\UserGroup as UserGroupModel;
use Backend\Models\User as UserModel;
use Bt\Maintenance\Models\JobCardApprove as Approval;

/**
 * Job Card Back-end Controller
 */
class JobCard extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        $urlArra = explode("/",$_SERVER['REQUEST_URI']);
        $user = BackendAuth::getUser();
        if (!$user) return;
        $email = null;
        if ($user !== null) {
            $email = $user->email;
        }
        $manager = null;
        if($user !== null && $user->hasPermission('bt.jobcard.management')){
            $manager = 'exists';
        }else{
            $supervisor = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 1)->first();
            $tech = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 0)->first();
        }
        if ($urlArra[count($urlArra)-2] == "update" ){
            if(!empty($tech)){
                $this->formConfig = 'config_tech.yaml';
            }
            if(!empty($supervisor)){
                $this->formConfig = 'config_supervisor.yaml';
            }
            if(!empty($manager)){
                $this->formConfig = 'config_manager.yaml';
            }
        }else{
            $this->formConfig = 'config_form.yaml';
        }

        parent::__construct();

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'jobcard');
    }

    public function onSendJobCardRequest($id)
    {
        $obj = ModelJobCard::find($id);

        $user = BackendAuth::getUser();
        if (!$user) return;
        $name = $user->first_name;
        $name .= ' '.$user->last_name;
        $email = $user->email;
        $supervisor = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 1)->first();
        $supervisormain = null;



            ##SEND EMAIL
        $url = Config::get('app.url').'/admin/bt/maintenance/jobcard/update/'.$id;

        $link = "
        * View Job Card: $url";

        $x = 0;

        $groupusers = UserGroup::where('id', 28)->first();

        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data = [];
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;
            $data['username'] = $name;
            $data['jobcard'] = $obj;
            $data['response_details'] =  $link;
            Mail::send('bt.notify.jobcard', $data, function($message) use ($data) {
                $message->subject("Job Card Approval: ");
                $message->to($data['to_email'], $data['name']);

            });
        }

        if(!empty($supervisor)){
            $obj2 = ModelJobCard::where('id', $id)->where('supervisor_id', $supervisor->id)->first();
            $x++;
            $data = [];
            $data['name'] = $supervisor->name;
            $data['to_email'] = $supervisor->email;
            $data['username'] = $name;
            $data['jobcard'] = $obj2;
            $data['response_details'] =  $link;
            Mail::send('bt.notify.jobcard', $data, function($message) use ($data) {
                $message->subject("Job Card Approval: ");
                $message->to($data['to_email'], $data['name']);

            });

        }
        \Flash::success( "Thank you, you request have been sent to $x users");
    }

    public function formAfterSave($model){
        $approval = Approval::where('jobcard_id', $model->id)->first();

        if(empty($approval)){
             $this->onSendJobCardRequest($model->id);
        }
    }


    public function onSendJobCardNotification($id = null )
    {
        $current = Carbon::now();
        $startdate = $current->addDays(-7);
        $jobcard_OBJ = ModelJobCard::where("created_at",">",$startdate)->orderBy('id', 'desc')->get();

        $data["items"] = $jobcard_OBJ;

        $groupusers = UserGroupModel::where('id', 30)->first();
        $x = 0;
        foreach ($groupusers->users as $key => $value) {
            $x++;
            $data['name'] = $value->name;
            $data['to_email'] = $value->email;

            Mail::send('bt.jobcardnoti.notify', $data, function($message) use ($data) {
                $message->to($data['to_email'], $data['name']);
            });
        }

        \Flash::success('Email Sent! Number of users = '.$x);
    }

    public function dashboard(){
        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'dashboard');
        $this->addCss("/plugins/bt/reporting/assets/css/bootstrap.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/dataTables.bootstrap5.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/responsive.bootstrap5.min.css", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap5.min.js", "1.0.0");
        $this->addJs("/plugins/bt/reporting/assets/js/backlaout.js", "1.0.0");

        $this->addJs("https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js", "1.0.0");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js", "1.0.0");
        $this->addJs("//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js", "1.0.0");
        $this->pageTitle = "Maintenance Dashboard";
        $obj = BackendAuth::getUser();
        $email = $obj->email;
        $manager = null;

        if($obj->hasPermission('bt.jobcard.management')){
            $manager = 'exists';
        }
        $supervisor = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 1)->first();
        $tech = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 0)->first();

        $jobcardObj = \Bt\Maintenance\Models\JobCard::where('created_at', '>', Carbon::now()->subDays(60))->get();
        if(!empty($tech)){

            $this->vars['user'] = 'tech';
        }
        if(!empty($supervisor)){

            $this->vars['user'] = 'supervisor';
        }
        if(!empty($manager) || $this->user->is_superuser){

            $this->vars['user'] = 'manager';
        }
        $this->vars['jobcardObj'] = $jobcardObj;

    }

    public function guestdashboard(){
        $this->pageTitle = "Maintenance Dashboard";
        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'guestdashboard');
        $this->addCss("/plugins/bt/reporting/assets/css/bootstrap.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/dataTables.bootstrap5.min.css", "1.0.0");
        $this->addCss("/plugins/bt/reporting/assets/css/responsive.bootstrap5.min.css", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap5.min.js", "1.0.0");
        $this->addJs("/plugins/bt/reporting/assets/js/backlaout.js", "1.0.0");

        $this->addJs("https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js", "1.0.0");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js", "1.0.0");
        $this->addJs("//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js", "1.0.0");

        $obj = BackendAuth::getUser();
        $manager = null;

        $jobcardObj = \Bt\Maintenance\Models\JobCard::where('created_by', $obj->id)->get();

        $this->vars['jobcardObj'] = $jobcardObj;

    }

    public function listExtendQuery($query)
    {
        $obj = \Backend\Facades\BackendAuth::getUser();
        $email = $obj->email;
        if($obj->hasPermission('bt.jobcard.management')){
            $query->where('id', '>', 0);
        }else{
            $supervisor = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 1)->first();
            $tech = \Bt\Maintenance\Models\Staff::where('email', $email)->where('is_supervisor', 0)->first();
            if(!empty($tech)){
                $query->where('assignedto_id', $tech->id);
            }
            if(!empty($supervisor)){
                $query->where('supervisor_id', $supervisor->id);
            }

            if(empty($supervisor) && empty($tech)){
                $query->where('created_by', $obj->id);
            }
        }
    }


}
