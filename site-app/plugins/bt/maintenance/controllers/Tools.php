<?php namespace Bt\Maintenance\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Maintenance\Models\ToolsChecklist;

use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;
use Config;
use Flash;
use App;
use Carbon\Carbon;
use Redirect;
use Backend;
use Str;
use Mail;
use Cms\Classes\Page as CmsPage;
/**
 * Tools Back-end Controller
 */
class Tools extends Controller
{
   public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Maintenance', 'maintenance', 'tools');
    }

     public function onSendDailyNotification($id = null)
    {

            $current = Carbon::now();
            $enddate = $current->addDays(2);
            
            $current = Carbon::now();
            $startdate = $current->addDays(-1);
            $data["checklist"] = ToolsChecklist::whereBetween('scheduledate', array($startdate, $enddate." 23:59:00"))
            ->where('status_id',1)
             ->get();
        
        $groupusers = UserGroup::where('id', 21)->first();
        $x = 0;
        if(!empty($data["checklist"]))
        foreach ($groupusers->users as $key => $value) {
            $x++;
            #REQUEST DISCOUNT
             $data['name'] = $value->name;
             $data['to_email'] = $value->email;

            Mail::send('bt.checklist.notify', $data, function($message) use ($data) {
                #$message->to('noezansithole@gmail.com', "Noezan");                        
                $message->to($data['to_email'], $data['name']);
            });
        }

        \Flash::success('Email Sent! Number of users = '.$x);
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }

}
