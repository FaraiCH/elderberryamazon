<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Schedule as ScheduleModel;
use Carbon\Carbon;
use DB;
use BackendAuth;
use RainLab\User\Models\User as UserModel;
use Bt\Sales\Models\ClientCategoryTarget;
use Bt\Sales\Models\ClientCategory;
use RainLab\User\Models\UserGroup;
use Bt\Sales\Models\Invoice as InvoiceModel;
use Bt\Sales\Models\Srn as SrnModel;
use Bt\Sales\Models\Newquote as QuoteModel;
use Input;
use Session;
use function GuzzleHttp\Psr7\try_fopen;

/**
 * Mydashboard Backend Controller
 */
class Mydashboard extends Controller
{

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Sales', 'sales', 'mydashboard');

    }

    public function index(){
        #Name: Farai Chakarisa
        #Description: Function to show sales targets and summary (eg invoice) with table and graph
        #link: http://i.btindustrial.co.za/admin/bt/sales/mydashboard
        #Updated by Farai Chakarisa: Finalise graph

        #Add CSS

        $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/productionbal.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/pagination.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/dataTables.bootstrap5.min.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/responsive.bootstrap5.min.css", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");

        #Add JS
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/backlaout.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/datatables.min.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/dataTables.bootstrap5.min.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/dataTables.responsive.min.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/responsive.bootstrap5.min.js", "1.0.0");
        $this->pageTitle = "My Dashboard";
        $myMonths = array();
        if(Session::has('startdate') && Session::get('startdate') != null){
            if(Input::has('startdate') && Input::get('startdate') !=  Session::get('startdate')){
                Session::put('startdate', Input::get('startdate'));
                $this->vars['startdate'] = Input::get('startdate');
            }else{
                $this->vars['startdate'] = Session::get('startdate');
            }
            if(Input::has('enddate') && Input::get('enddate') !=  Session::get('enddate')){
                Session::put('enddate', Input::get('enddate'));
                $this->vars['enddate'] = Input::get('enddate');
            }else{
                $this->vars['enddate'] = Session::get('enddate');
            }
        }else{
            Session::put('startdate',Carbon::now()->subDays(30));
            Session::put('enddate', Carbon::now());
            $this->vars['startdate'] = Carbon::now()->subDays(30);
            $this->vars['enddate'] = Carbon::now();
        }
        $startdate = $this->vars['startdate'];
        $enddate = $this->vars['enddate'];
        $_SESSION['starter'] = $startdate;
        $_SESSION['ender'] = $enddate;
        $monster = array();
        $mypeople = array();
        $myresults = array();
        $user = BackendAuth::getUser();
        if (!$user) return;
        $u = UserModel::where("email",$user->email)->first();
        $im_id = $u->id;

        if ($this->user->hasAccess(['bt.finance.ho']) ) {
            $im_id = 9999;
            if(Input::has("sales") && Input::get("sales") > 0 ){
                $im_id = Input::get("sales") ;
            }
        }
        Session::put('user_sales', $im_id);
        Session::save();
        $this->vars['pb'] = $this->getProductionBalance($startdate, $enddate,$im_id, '');
        $this->vars['pb_item'] = $this->getProductionBalanceItem($startdate, $enddate,$im_id);


        ####DO INVOICE
        $this->vars['srns']  = SrnModel::whereBetween('schedule_date', array($startdate, $enddate))
        ->whereHas('quote', function ($query) use ($im_id)  {
            if($im_id != 9999){
                $query->where('user_id', $im_id);
            }
        })->orderby("created_at","desc")->get();

        ####DO INVOICE
        $this->vars['poquotes']  = QuoteModel::where('ponumber',"<>","")->whereNotnull('ponumber')->whereBetween('created_at', array($startdate, $enddate))
        ->whereHas('user', function ($query) use ($im_id)  {
            if($im_id != 9999){
                $query->where('id', $im_id);
            }
            $query->orderby("name","asc");
        })->orderby("user_id","asc")->orderby("created_at","desc")->get();


        ####DO INVOICE
        $this->vars['invoices']  = InvoiceModel::
        whereHas('srn', function ($query) use ($startdate, $enddate)  {
            $query->whereBetween('schedule_date', array($startdate, $enddate));
        })->whereHas('quote', function ($query) use ($im_id)  {
                if($im_id != 9999){
                    $query->where('user_id', $im_id);
                }
        })->orderby("created_at","desc")->get();

        foreach ($this->vars['invoices'] as $inv_key => $inv_value){
            $saleid = $inv_value->quote->user_id;
            $salename = $inv_value->quote->user->name." ".$inv_value->quote->user->surname;
            $mypeople[$saleid] = $salename;
            $date_ = Carbon::parse(!empty($inv_value->srn)?$inv_value->srn->schedule_date:$inv_value->invoice_date);
            $m = $date_->format('M');;
            $y = $date_->year;
            $k = $y."_".$m;
            $monster[$k]["month"] = $m;
            $monster[$k]["year"] = $y;
            $kweek = $date_->weekOfYear;

            $monster[$k]["arr_week"][$kweek]['dateofweek'] = $date_->startOfWeek()->format('Y-m-d');
            $monster[$k]["arr_week"][$kweek]['srn_id'] = $inv_value->srn_id;
            $monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["salesname"] = $salename;
            $monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["invoicedamount"] = (isset($monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["invoicedamount"])?$monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["invoicedamount"] :0 )  + $inv_value->amount;
            $monster[$k]["totals"][$saleid]["invoicedamount"] = (isset($monster[$k]["totals"][$saleid]["invoicedamount"])?$monster[$k]["totals"][$saleid]["invoicedamount"] :0 )  + $inv_value->amount;
            $srn_value = $inv_value->srn;

            $monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["deliveyweight"] = (isset($monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["deliveyweight"])?$monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["deliveyweight"] :0 )  + $srn_value->items()->sum("stockweight");

            $monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["deliveystockvalue"] = (isset($monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["deliveystockvalue"])?$monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["deliveystockvalue"] :0 )  + $srn_value->items()->sum("stockvalue");


            $monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["stockvalue"] = (isset($monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["stockvalue"])?$monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["stockvalue"] :0 )  + $srn_value->itemscat()->sum("stockvalue");

            ##TOTALS
            $monster[$k]["totals"][$saleid]["stockvalue"] = (isset($monster[$k]["totals"][$saleid]["stockvalue"])?$monster[$k]["totals"][$saleid]["stockvalue"] :0 )  + $srn_value->itemscat()->sum("stockvalue");
            $monster[$k]["totals"][$saleid]["deliveyweight"] = (isset($monster[$k]["totals"][$saleid]["deliveyweight"])?$monster[$k]["totals"][$saleid]["deliveyweight"] :0 )  + $srn_value->items()->sum("stockweight");
            $monster[$k]["totals"][$saleid]["deliveystockvalue"] = (isset($monster[$k]["totals"][$saleid]["deliveystockvalue"])?$monster[$k]["totals"][$saleid]["deliveystockvalue"] :0 )  + $srn_value->items()->sum("stockvalue");
        }
        $w = ScheduleModel::whereBetween('production_date', array($startdate, $enddate))
            ->whereHas('pipe', function ($q_pipe){
                $q_pipe->where('id', '>', 0)->whereHas('quoteitems', function ($q_quoteitems){
                    $q_quoteitems->where('id', '>', 0)->whereHas('quote', function ($q_quote){
                        $q_quote->where('user_id','<>', 9999);
                    });
                });
            })
            ->orderby("production_date","desc")
            ->get();
        foreach ($w as $sc_key => $sc_value) {
            $saleid = $sc_value->pipe->quoteitems->quote->user_id;
            $in = 0;
            if($im_id != 9999){
                if( $saleid == $im_id){
                    $in = 1;
                }
            }else{
                $in = 1;
            }
            if($in == 1){
                $salename = $sc_value->pipe->qpush->quote->user->name." ".$sc_value->pipe->qpush->quote->user->surname;
                $mypeople[$saleid] = $salename;
                $date_ = Carbon::parse($sc_value->production_date);
                $m = $date_->format('M');;
                $y = $date_->year;
                $k = $y."_".$m;
                $monster[$k]["month"] = $m;
                $monster[$k]["year"] = $y;
                $kweek = $date_->weekOfYear;
                $monster[$k]["arr_week"][$kweek]['dateofweek'] = $date_->startOfWeek()->format('Y-m-d');
                $monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["salesname"] = $salename;
                $monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["total_kg_processed"] = (isset($monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["total_kg_processed"])?$monster[$k]["arr_week"][$kweek]['salesdata'][$saleid]["total_kg_processed"] :0 )  + $sc_value->total_kg_processed;
                $monster[$k]["totals"][$saleid]["total_kg_processed"] = (isset($monster[$k]["totals"][$saleid]["total_kg_processed"])?$monster[$k]["totals"][$saleid]["total_kg_processed"] :0 )  + $sc_value->total_kg_processed;
            }

        }

        #Loop through monster which has all the values
        foreach($monster as $m => $mdata){
            $myMonths[] = $mdata["month"]. "/" .$mdata["year"];
            foreach($mypeople as $pkey => $pitem){
                if(isset($mdata["totals"][$pkey]) ){

                    #Use $myresult and hash it the desired name
                    #Increment $myresult hash by using hashed mdata (where the values are stored)
                    #Get Total
                    if(Input::get("sales") == $pkey)
                    {
                        $myresults[$mypeople[$pkey]][$mdata["month"]. '/'. $mdata["year"]] = ((isset($myresults[$mypeople[$pkey]][$mdata["month"]. '/'. $mdata["year"]]))?$myresults[$mypeople[$pkey]][$mdata["month"]. '/'. $mdata["year"]]:0) + ((isset($mdata["totals"][$pkey]["invoicedamount"]))?$mdata["totals"][$pkey]["invoicedamount"]:0);
                    }
                    else
                    {
                        $myresults[$mypeople[$pkey]][$mdata["month"]. '/'. $mdata["year"]] = ((isset($myresults[$mypeople[$pkey]][$mdata["month"]. '/'. $mdata["year"]]))?$myresults[$mypeople[$pkey]][$mdata["month"]. '/'. $mdata["year"]]:0) + ((isset($mdata["totals"][$pkey]["invoicedamount"]))?$mdata["totals"][$pkey]["invoicedamount"]:0);
                    }

                }
            }
        }
        $stats = array();

        #Loop through $myresults by getting $name(key) and $arrdata(value)
        foreach ($myresults as $name => $arrdata) {
            $content = array();

            #get the value stored in arrdata
            foreach ($arrdata as $key => $value){

                #Add value as an array object
                $content[] = array($key, $value);
            }
            $stats[] = array('name' =>  $name , 'data' => $content);
        }
        $this->vars['targetsmonster'] = $this->getTarget();
        $this->vars['targetscats'] = ClientCategory::whereIn('id',[1,6])->orderBy('id')->get();
        $this->vars['monster'] = $monster;
        $this->vars['mypeople'] = $mypeople;
        $this->vars['groupusers'] = UserGroup::where('id',3)->first();
        $this->vars['graph'] = $myresults;
        $this->vars['stats'] = $stats;
        $this->vars['months'] = $myMonths;

    }

    private function getTarget(){

        $enddate = Carbon::now()->addMonth(1)->setTime(00, 00, 00);
        $startdate = Carbon::now()->addMonth(-1)->setTime(00, 00, 00);
        $list = ClientCategoryTarget::whereBetween('run_date', array("2021/11/30 23:59:00", $enddate->startOfMonth()))->whereIn('category_id',[1, 6])->orderby('run_date')->orderby('category_id')->get();
        $monster = [];

        foreach ($list as $key => $value) {
            $date_ = Carbon::parse($value->run_date);
            $m = $date_->format('M');;
            $y = $date_->year;
            $k = $y."_".$m;
            $monster[$k]["month"] = $m;
            $monster[$k]["year"] = $y;
            $monster[$k]["catname"] = $value->category->name;
            $monster[$k]['arr_cat'][$value->category_id]['target'] = $value->target;
            $monster[$k]['arr_cat'][$value->category_id]['straight'] = $value->straight;
            $monster[$k]['arr_cat'][$value->category_id]['coil'] = $value->coil;

        }
        return $monster;
    }
    public function getProductionBalance($startdate, $enddate,$im_id, $financial_year){
        $monster = [];
        if(!empty($financial_year)){
            $w = ScheduleModel::where('production_date', '>', $financial_year)
                ->whereHas('pipe', function ($q_pipe){
                    $q_pipe->where('id', '>', 0)->whereHas('quoteitems', function ($q_quoteitems){
                        $q_quoteitems->where('id', '>', 0)->whereHas('quote', function ($q_quote){
                            $q_quote->where('user_id','<>', 9999);
                        });
                    });
                })
                ->orderby("production_date","desc")
                ->get();
            $i = SrnModel::where('schedule_date', '>', $financial_year)->whereHas('quote', function ($query) use ($im_id)  {
                if($im_id != 9999){
                    $query->where('user_id', $im_id);
                }
            })->orderby("created_at","desc")->get();
        }else{
            $w = ScheduleModel::whereBetween('production_date', array($startdate, $enddate))
                ->whereHas('pipe', function ($q_pipe){
                    $q_pipe->where('id', '>', 0)->whereHas('quoteitems', function ($q_quoteitems){
                        $q_quoteitems->where('id', '>', 0)->whereHas('quote', function ($q_quote){
                            $q_quote->where('user_id','<>', 9999);
                        });
                    });
                })
                ->orderby("production_date","desc")
                ->get();
            $i = SrnModel::whereBetween('schedule_date', array($startdate, $enddate))->whereHas('quote', function ($query) use ($im_id)  {
                if($im_id != 9999){
                    $query->where('user_id', $im_id);
                }
            })->orderby("created_at","desc")->get();
        }

        foreach ($w as $sc_key => $sc_value) {
                $saleid = $sc_value->pipe->quoteitems->quote->user_id;
                $in = 0;
                if($im_id != 9999){
                    if( $saleid == $im_id){
                        $in = 1;
                    }
                }else{
                    $in = 1;
                }
                if($in == 1){
                    $salename = $sc_value->pipe->qpush->quote->user->name." ".$sc_value->pipe->qpush->quote->user->surname;
                    $clientName = $sc_value->pipe->quoteitems->quote->company_name;
                    $k = $sc_value->pipe->quoteitems->quote->id;
                    $monster[$k]["salesid"] = $sc_value->pipe->qpush->quote->user->id;
                    $monster[$k]["salesname"] = $salename;
                    $monster[$k]["total_kg_processed"] = (isset($monster[$k]["total_kg_processed"])?$monster[$k]["total_kg_processed"] :0 )  + $sc_value->total_kg_processed;
                    $monster[$k]["total_units_passed_qc"] = (isset($monster[$k]["total_units_passed_qc"])?$monster[$k]["total_units_passed_qc"] :0 )  + $sc_value->total_units_passed_qc;
                    $monster[$k]["deliveyweight"] = 0;
                    $monster[$k]["total_units_unit_in_date"] = 0;
                    $monster[$k]["clientName"] = $clientName;
                    $monster[$k]["total_units_orderd_pipes"] = 0;
                    $monster[$k]["total_kg_orderd"] = 0;


                }
        }


        foreach ($i as $inv_key => $srn_value){
            $saleid = $srn_value->quote->user_id;
            $salename = $srn_value->quote->user->name." ".$srn_value->quote->user->surname;

            $clientName = $srn_value->quote->company_name;
            $k = $srn_value->quote->id;

            $monster[$k]["salesid"] = $srn_value->quote->user->id;
            $monster[$k]["clientName"] = $clientName;
            $monster[$k]["salesname"] = $salename;
            $monster[$k]["total_units_orderd_pipes"] = 0;
            $monster[$k]["total_kg_orderd"] = 0;
            $monster[$k]["deliveyweight"] = (isset($monster[$k]["deliveyweight"])?$monster[$k]["deliveyweight"] :0 )  + $srn_value->items()->sum("stockweight");
            $monster[$k]["total_units_unit_in_date"] = (isset($monster[$k]["total_units_unit_in_date"])?$monster[$k]["total_units_unit_in_date"] :0 )  + $srn_value->items()->sum("units") + $srn_value->itemscat()->sum("units");

            if(!isset($monster[$k]["total_kg_processed"]) )
                $monster[$k]["total_kg_processed"] = 0;
                $monster[$k]["total_units_passed_qc"] = 0;
        }


        $qm = QuoteModel::whereIn('id',array_keys($monster))->get();

        foreach($qm as $key =>$qoute){
            $monster[$qoute->id]["total_units_orderd_pipes"] = $qoute->items()->sum("units") + $qoute->itemscat()->sum("units");
            $monster[$qoute->id]["total_kg_orderd"] = $qoute->items()->sum("totalweight");
        }

        return $monster;

    }
    public function getProductionBalanceItem($startdate, $enddate,$im_id){
        $monster = [];
        $w = ScheduleModel::whereBetween('production_date', array($startdate, $enddate))
            ->whereHas('pipe', function ($q_pipe){
                $q_pipe->where('id', '>', 0)->whereHas('quoteitems', function ($q_quoteitems){
                    $q_quoteitems->where('id', '>', 0)->whereHas('quote', function ($q_quote){
                        $q_quote->where('user_id','<>', 9999);
                    })->orderBy('id', 'desc');
                });
            })
            ->orderby("production_date","desc")
            ->get();
        foreach ($w as $sc_key => $sc_value) {
            $saleid = $sc_value->pipe->quoteitems->quote->user_id;
            $in = 0;
            if($im_id != 9999){
                if( $saleid == $im_id){
                    $in = 1;
                }
            }else{
                $in = 1;
            }
            if($in == 1){
                $salename = $sc_value->pipe->qpush->quote->user->name." ".$sc_value->pipe->qpush->quote->user->surname;
                $clientName = $sc_value->pipe->quoteitems->quote->company_name;
                $k = $sc_value->pipe->quoteitems->quote->id;
                $item = $sc_value->pipe->quoteitems->id;
                $quoteitems = $sc_value->pipe->quoteitems;
                $monster[$k][$item]["salesid"] = $sc_value->pipe->qpush->quote->user->id;
                $monster[$k][$item]["salesname"] = $salename;
                $monster[$k][$item]["deliveyweight"] = $quoteitems->getSameItemDelivered($quoteitems->quote_id, $quoteitems->product_id, $quoteitems->unitlength, $startdate, $enddate)->sum('stockweight');
                $monster[$k][$item]["total_units_unit_in_date"] = $quoteitems->getSameItemDelivered($quoteitems->quote_id, $quoteitems->product_id, $quoteitems->unitlength, $startdate, $enddate)->sum('units');
                $monster[$k][$item]["clientName"] = $clientName;
            }

        }
        return $monster;
    }
}
