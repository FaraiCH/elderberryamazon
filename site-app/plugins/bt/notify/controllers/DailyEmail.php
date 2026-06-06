<?php namespace Bt\Notify\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Inventory\Models\CageMaterial as CageMaterialModel;
use RainLab\User\Models\User as UsersModel;
use Bt\Production\Models\Schedule as ScheduleModel;
use Bt\Maintenance\Models\Schedule as ModelScheduleMaintenance;
use Bt\Floor\Models\Stockpipe as StockpipeModel;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceiving;
use Bt\Sales\Models\DeliveryPlan as DeliverPlanModel;
use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;
use Bt\Production\Models\Pipe as PipeModel;
use Config;
use Flash;
use App;
use Carbon\Carbon;
use Redirect;
use Backend;
use Str;
use Mail;
use Cms\Classes\Page as CmsPage;
use Bt\Sales\Models\Srn;
use Bt\Sales\Models\Quoteitems;

use Bt\Production\Models\Push as PushModel;
use Bt\Sales\Models\Srn as SrnModel;

/**
 * Daily Email Back-end Controller
 */
class DailyEmail extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Notify', 'notify', 'dailyemail');
       // $this->onSendApprovalNotification();
         // dd($this->getPNratingitems());
        //dd($this->getFloorPipes()->toarray());
    }

    
    public function onSendSRNDailyNotification($id = null)
    {
        $data = [
            'tblsrn' => $this->getsrn()
        ];

        $x = 0;
        
        $groupusers = UserGroup::where('id', 23)->first();
        foreach ($groupusers->users as $key => $value) {
                $x++;
                #REQUEST DISCOUNT
                 $data['name'] = $value->name;
                 $data['to_email'] = $value->email;

                Mail::send('bt.notify.srn', $data, function($message) use ($data) {
                    #$message->to('noezansithole@gmail.com', "Noezan");                        
                    $message->to($data['to_email'], $data['name']);
                });
            }
        
        \Flash::success('Email Sent! Number of users = '.$x);
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }





    private function getsrn(){
        #$obj = CageMaterialModel::where('datecaptured', '>=', Carbon::now()->subDay())->orderBy("datecaptured","DESC")->take(20)->get();
        $enddate = Carbon::now();
        $current = Carbon::now();
        $startdate = $current->addDays(-30);
        

        // $data = array('startdate' => $startdate, 'enddate' => $enddate);

        

        #$obj = Srn::whereBetween('schedule_date', array($startdate, $enddate." 23:59:00"))->where('active',1)->orderBy("schedule_date","DESC")->get();
        $obj = Srn::whereBetween('schedule_date', array($startdate, $enddate." 23:59:00"))->orderBy("schedule_date","DESC")->get();

        if(!empty($obj)){
            return $obj; 
        }else{
            return null;
        }
        
    }




     public function onSendDailyNotification($id = null)
    {

        $data = [
                  

        'tblfloorpipes' => $this->getFloorPipes(),
        'tblincage' => $this->getMaterials(),
        'tblproduction' => $this->getProduction(),
        'tblmaintainace' => $this->getMaintainace(),
        


        ];

        $x = 0;

          

          $groupusers = UserGroup::where('id', 8)->first();

        foreach ($groupusers->users as $key => $value) {
                $x++;
                #REQUEST DISCOUNT
                 $data['name'] = $value->name;
                 $data['to_email'] = $value->email;

                Mail::send('bt.notify.daily', $data, function($message) use ($data) {
                    #$message->to('noezansithole@gmail.com', "Noezan");                        
                    $message->to($data['to_email'], $data['name']);
                });
            }

            
        
        
        \Flash::success('Email Sent! Number of users = '.$x);
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }


    private function getMaterials(){
        $obj =  RawMaterialReceiving::active()->orderBy("supplier_batch")->get();
        if(!empty($obj)){
            return $obj; 
        }else{
            return null;
        }
        
    }

    private function getProduction(){
        #$obj = CageMaterialModel::where('datecaptured', '>=', Carbon::now()->subDay())->orderBy("datecaptured","DESC")->take(20)->get();
        $obj = ScheduleModel::where('total_kg_processed','>',0)->orderBy("production_date","DESC")->take(7)->get();
        if(!empty($obj)){
            return $obj; 
        }else{
            return null;
        }
        
    }
     private function getMaintainace(){
        #$obj = CageMaterialModel::where('datecaptured', '>=', Carbon::now()->subDay())->orderBy("datecaptured","DESC")->take(20)->get();
        $obj =  ModelScheduleMaintenance::active()->orderBy('scheduledate')->get();
        if(!empty($obj)){
            return $obj; 
        }else{
            return null;
        }
        
    }
     private function getFloorPipes(){
        $obj = PipeModel::active()->orderBy('start_date','desc')->get();
        if(!empty($obj)){
            return $obj; 
        }else{
            return null;
        }
    }

     public function onSendQuoteItemDailyNotification($id = null)
    {
        $data = [
            'tblitem' => $this->getPNratingitems()
        ];

        $x = 0;
        
        $groupusers = UserGroup::where('id', 26)->first();
        foreach ($groupusers->users as $key => $value) {
                $x++;
                #REQUEST DISCOUNT
                 $data['name'] = $value->name;
                 $data['to_email'] = $value->email;

                Mail::send('bt.notify.pnratingquotes', $data, function($message) use ($data) {
                    #$message->to('noezansithole@gmail.com', "Noezan");                        
                    $message->to($data['to_email'], $data['name']);
                });
            }
        
        \Flash::success('Email Sent! Number of users = '.$x);
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }


    private function getPNratingitems(){
        #$obj = CageMaterialModel::where('datecaptured', '>=', Carbon::now()->subDay())->orderBy("datecaptured","DESC")->take(20)->get();
        $enddate = Carbon::now();
        $current = Carbon::now();
        $startdate = $current->addDays(-7);
        

        // $data = array('startdate' => $startdate, 'enddate' => $enddate);

        

        $obj = Quoteitems::
        whereHas('product', function($q)  {
            $q->whereHas('PNRating', function($q2)  {
                    $q2->where('alert', 1);
                });
        })->
        whereBetween('created_at', array($startdate, $enddate." 23:59:00"))
        ->orderBy("created_at","DESC")->get();
        if(!empty($obj)){
            return $obj; 
        }else{
            return null;
        }
        
    }

    public function onSendApprovalNotification($id = null)
    {

        $batches = PushModel::whereHas('approved', function ($query) {
                $query->where('status_id', '>=',0);
            })->orderBy('id', 'DESC')->get()->take(20);

        $srnapprov = SrnModel::whereHas('srnapprove', function ($query) {
                $query->where('status_id', '>=',0);
            })->orderBy('id', 'DESC')->get()->take(20);



        $data = [
            'batches' => $batches,
            'srnapprov' => $srnapprov
        ];

        

        $x = 0;
        
        $groupusers = UserGroup::where('id', 8)->first();
        foreach ($groupusers->users as $key => $value) {
                $x++;
                #REQUEST DISCOUNT
                 $data['name'] = $value->name;
                 $data['to_email'] = $value->email;

                Mail::send('bt.notify.approvals', $data, function($message) use ($data) {
                    #$message->to('noezansithole@gmail.com', "Noezan");                        
                    $message->to($data['to_email'], $data['name']);
                });
            }
        
        \Flash::success('Email Sent! Number of users = '.$x);
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }


    public function onSendLogisticNotification($id = null)
    {
        $data = [
            'tbllogistics' => $this->getlogistics()
        ];

        $x = 0;
        
        $groupusers = UserGroup::where('id', 25)->first();
        foreach ($groupusers->users as $key => $value) {
                $x++;
                 $data['name'] = $value->name;
                 $data['to_email'] = $value->email;

                Mail::send('bt.notify.logistics', $data, function($message) use ($data) {                   
                    $message->to($data['to_email'], $data['name']);
                });
            }
        
        \Flash::success('Email Sent! Number of users = '.$x);
        //return \Backend::redirect('jadmin/email/bulk/sendforpopularity/'.$id);
    }

    private function getlogistics(){
        $now = Carbon::now();
        $delivery = DeliverPlanModel::where('schedule_date', '>=', $now)->get();

        if(!empty($delivery)){
            return $delivery; 
        }else{
            return null;
        }
        
    }
}
