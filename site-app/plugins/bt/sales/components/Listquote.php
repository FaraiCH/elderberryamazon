<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\QuoteStatus;
use Carbon\Carbon;
use Input;
Use DB;
use Auth;
class Listquote extends ComponentBase
{
    public $formstatus;
    public $startdate;
    public $enddate;
    public $listquote;

    public function componentDetails()
    {
        return [
            'name'        => 'listquote Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
      public function onRun(){
        if(Input::has('enddate')){
            $this->enddate = Input::get('enddate');
        }else{
            $this->enddate = Carbon::now();
        }

        if(Input::has('startdate')){
            $this->startdate = Input::get('startdate');
        }else{
            $current = Carbon::now();
            $this->startdate = $current->addDays(-15);
        }
        
        if(Input::has('showstatus')){
            $this->formstatus = Input::get('showstatus');
        }else{
            $this->formstatus = 0;
        }
        $this->loadAssets();
        $user = Auth::getUser();

        if($this->formstatus > 0 ){

            // $this->listquote = ModelNewquote::select("bt_sales_newquote.*",  DB::raw("SUM(bt_sales_quote_reponses.amountpaid) as amountpaid"))
            //  ->join('bt_sales_quote_reponses', function ($join) {              
            //     $join->on('bt_sales_quote_reponses.quote_id', '=', 'bt_sales_newquote.id');
            // })
            // ->where('bt_sales_newquote.quote_status_id', $this->formstatus)->whereBetween('bt_sales_newquote.created_at', array($this->startdate, $this->enddate." 23:59:00"))
            //  ->GroupBy("bt_sales_newquote.id","bt_sales_newquote.user_id")->active()
            //  ->get();    

             $this->listquote = ModelNewquote::where('quote_status_id', $this->formstatus)->whereBetween('created_at', array($this->startdate, $this->enddate." 23:59:00"))->active()
             ->get();   
        }else{

           
            //  $this->listquote = ModelNewquote::select("bt_sales_newquote.*",  DB::raw("SUM(bt_sales_quote_reponses.amountpaid) as amountpaid"))
            //  ->leftjoin('bt_sales_quote_reponses', function ($join) {              
            //     $join->on('bt_sales_quote_reponses.quote_id', '=', 'bt_sales_newquote.id');
            // })
            // ->whereBetween('bt_sales_newquote.created_at', array($this->startdate, $this->enddate." 23:59:00"))
            //  ->GroupBy("bt_sales_newquote.id","bt_sales_newquote.user_id","bt_sales_newquote.quote_status_id")->active()
            //  ->get();

            $this->listquote = ModelNewquote::whereBetween('created_at', array($this->startdate, $this->enddate." 23:59:00"))->active()->get();
        }

        
    }

    public function loadAssets()
    {
        
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs('assets/js/formfilter.js', 'Bt.Sales');

    }
 

    public function loadStatus(){
        return QuoteStatus::all();
    }

   
}
