<?php namespace Bt\JSEData\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\JSEData\Models\Company;
use Bt\JSEData\Models\QueryType;
use Bt\JSEData\Models\Property as PropertyModel;
use Bt\JSEData\Models\DataMine as DataMineModel;
use Bt\JSEData\Models\Inflation as InflationModel;

use DB;
use Input;

use Carbon\Carbon;

/**
 * Query Builder Back-end Controller
 */
class QueryBuilder extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.JSEData', 'jsedata', 'querybuilder');


    }
    public function index(){
        $this->pageTitle ="Search";
        $this->initForm($this);

         $this->addCss("/plugins/bt/sales/assets/css/bootstrap.min.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/backlaout.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/dataTables.bootstrap5.min.css", "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/responsive.bootstrap5.min.css", "1.0.0");


        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        // $this->addJs("/plugins/bt/production/assets/js/backend_formfilter.js", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");

        $this->addJs('https://code.highcharts.com/highcharts.js', "1.0.1");
        $this->addJs('https://code.highcharts.com/modules/series-label.js', "1.0.1");
        $this->addJs('https://code.highcharts.com/modules/exporting.js', "1.0.1");
        $this->addJs('https://code.highcharts.com/modules/export-data.js', "1.0.1");


        $this->addJs("https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", "1.0.0");
        $this->addJs("https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap5.min.js", "1.0.0");

        $this->addJs("https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js", "1.0.0");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js", "1.0.0");
        $this->addJs("//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js", "1.0.0");
        $this->addJs("//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/backlaout.js", "1.0.0");


    }

    public function getQuirytypeOptions(){
        #return QueryType::all()->pluck('name','id')->toarray();

        $i = QueryType::all();
        $arrayName = array();

        foreach ($i as $key_ => $value_) {
            $arrayName[$value_->id] = $value_->id.": ".$value_->name;
        }

        return $arrayName;
    }
     public function buildlistInflation(){
            #return QueryType::all()->pluck('name','id')->toarray();

            $i = InflationModel::all();
            $arrayName = array();

            foreach ($i as $key_ => $value_) {
                $arrayName[$value_->i_year] = $value_->i_year." > Feb ".$value_->i_feb;
            }

            return $arrayName;
        }

    public function getPropertyOptions()
    {
        $i = PropertyModel::where('parent_id','>',0)->orderby('parent_id','asc')->get();
        $arrayName = array();

        foreach ($i as $key_ => $value_) {
            $arrayName[$value_->id] = $value_->parent->name.": ".$value_->name." (".$value_->id.")";
        }

        return $arrayName;
    }

    public function buildlistCompany()
    {

        $arrayName = array();
         $i = Company::orderby('industry_id','asc')->orderby('name','asc')->get();
        foreach ($i as $key_ => $value_) {
            if(isset( $value_->industry->name)){
                // $arrayName[$value_->id] = $value_->industry->name." :: ".$value_->name. " (".$value_->ticker." ".$value_->altticker.")";

                 $arrayName[$value_->id] = $value_->name. " (".$value_->ticker." ".$value_->altticker.")";
            }else{
                $arrayName[$value_->id] = $value_->name;
            }

        }

        return $arrayName;
    }

     public function onSearchSchedule(){
        if(!Input::get("QueryBuilder")["allcomp"] && !Input::get("QueryBuilder")["spacialcomp"]){

            if(empty(Input::get("QueryBuilder")["company"])){
                    \Flash::error('Company Name field required');
                    return null;
            }
        }

        if(empty(Input::get("QueryBuilder")["datea"])){
                \Flash::error('Start Date field required');
                return null;
        }

        if(empty(Input::get("QueryBuilder")["dateb"])){
                \Flash::error('End Date field required');
                return null;
        }
        if(empty(Input::get("QueryBuilder")["quirytype"])){
                \Flash::error('Query Type field is required');
                return null;
        }
        if(!$this->checkReport(Input::get("QueryBuilder")["quirytype"]) && empty(Input::get("QueryBuilder")["property"])){
                \Flash::error('Property field required');
                return null;
        }



        if(!empty(Input::get("QueryBuilder")["includeinflation"]) && Input::get("QueryBuilder")["includeinflation"] == 1 && empty(Input::get("QueryBuilder")["inflationyear"]) ){
                \Flash::error('Base Inflation Year field is required');
                return null;
        }

        if(!empty(Input::get("QueryBuilder")["inflationyear"])){
            $this->vars['inflationyear'] = Input::get("QueryBuilder")["inflationyear"];
        }else{
            $this->vars['inflationyear'] = 2015;
        }

        $this->vars['includeinflation'] = Input::get("QueryBuilder")["includeinflation"];
        $obj_inflationyear_value = InflationModel::where("i_year",$this->vars['inflationyear'])->first();

        $this->vars['inflationyear_value'] = $obj_inflationyear_value->i_feb;

         $this->vars['inflation'] = InflationModel::all()->pluck('i_feb','i_year')->toarray();


        $arrayName = array();
        if(Input::get("QueryBuilder")["allcomp"] > 0){
            $c = Company::all();
            foreach ($c as $key => $value) {
                $arrayName[] =  $value->id;
            }


        }else if(Input::get("QueryBuilder")["spacialcomp"] > 0){
            $c = Company::where("isspecial",1)->get();
            foreach ($c as $key => $value) {
                $arrayName[] =  $value->id;
            }


        }
        else{
            foreach (Input::get("QueryBuilder")["company"] as $key => $value) {
            $arrayName[] =  $value;
            }
        }

        if($this->checkReport(Input::get("QueryBuilder")["quirytype"])){

            $data = array('startdate' => Input::get("QueryBuilder")["datea"], 'enddate' =>Input::get("QueryBuilder")["dateb"],'property_id' => Input::get("QueryBuilder")["property"]);

            $monster = array();
            $q = array(67,68,69,70,72 );

            if(Input::get("QueryBuilder")["quirytype"] == 4){
                $q = array(79);
            }

            if(Input::get("QueryBuilder")["quirytype"] == 5 || Input::get("QueryBuilder")["quirytype"] == 6){
                $q = array(67,68,69,70,72,79 );
            }

            if(Input::get("QueryBuilder")["quirytype"] == 7){
                $q = array(66);
            }

            if(Input::get("QueryBuilder")["quirytype"] == 8){
                $q = array(67,68,69,70,72,79,172,237);
            }

            if(Input::get("QueryBuilder")["quirytype"] == 9){
                 $q = array(67,68,69,70,72,79,173,237);
            }

            if(Input::get("QueryBuilder")["quirytype"] == 10){
                 $q = array(42,43);
            }

            if(Input::get("QueryBuilder")["quirytype"] == 11){
                 $q = array(27,13,89,67,68,69,70,72,79, 66,42,43);
            }



            $obj = Company::whereIn('id',  $arrayName)
                ->with(["mines" => function ($query) use ($data,$q) {
                    $query->select(DB::raw("DATE_FORMAT(datea,'%Y') as yearb"),"value" ,"company_id",'property_id','cur');
                    $query->whereBetween('datea', array($data['startdate'], $data['enddate']." 23:59:00"));
                    $query->whereIn('property_id',$q);
                    $query->groupBy("yearb","company_id",'property_id');
                    $query->orderby('datea','asc');
                }])
                ->orderby('name','asc')->get();
                if($this->vars['includeinflation'] && Input::get("QueryBuilder")["inflationyear"]){
                    foreach ($obj as $key => $value) {
                        if($this->vars['includeinflation'] && Input::get("QueryBuilder")["inflationyear"]){
                            foreach ($value->mines as $mkey => $item) {

                                $y =  $item->yearb;
                                $item->value = $this->applyInflation($item->value,$y);
                            }
                        }
                    }
                }

            foreach ($obj as $key => $value) {
                    $k = $value->id;
                    $mine  = array();
                    $countm = array();
                    foreach ($value->mines as $mkey => $item) {
                        $m = "monthall";
                        $y =  $item->yearb;
                        $mine[$m][$y]["cur"] = $item->cur;
                        if(Input::get("QueryBuilder")["quirytype"] == 11 ){

                            $totaldebt = array(27,13,89,66 ); ##66 is change in equity
                            if (in_array($item->property_id, $totaldebt )) {
                                $mine[$m][$y][$item->property_id] = (isset($mine[$m][$y][$item->property_id])?$mine[$m][$y][$item->property_id]:0)+$item->value;
                            }


                            ###3.   Total Debt
                            $totaldebt = array(67,68,69,70,72,79 );
                            if (in_array($item->property_id, $totaldebt )) {
                                $mine[$m][$y]["totaldebt"] = (isset($mine[$m][$y]["totaldebt"])?$mine[$m][$y]["totaldebt"]:0)+$item->value;
                            }


                            #6. Intangible capital
                            $totaldebt = array(42,43);
                            if (in_array($item->property_id, $totaldebt )) {
                                $mine[$m][$y]["totalintngible"] = (isset($mine[$m][$y]["totalintngible"])?$mine[$m][$y]["totalintngible"]:0)+$item->value;
                            }


                            $mine[$m][$y]["allin"] =  $this->isAllIn(array('totalintngible','totaldebt', 27,13,66),$mine[$m][$y]);
                            #$mine[$m][$y]["allin"] =  $this->isAllIn(array(27,13),$mine[$m][$y]);
                            if($mine[$m][$y]["allin"]){

                                ##i= Profit for the period + Depreciation- Dividends paid
                                $cal = ($mine[$m][$y][27]+$mine[$m][$y][13])-(isset($mine[$m][$y][89])?$mine[$m][$y][89]:0);

                                #+ Change in debt

                                $current_change = (isset($mine[$m][$y]["totaldebt"])?$mine[$m][$y]["totaldebt"]:0);
                                if(isset($mine[$m][$y-1]) && isset($mine[$m][$y-1]["totaldebt"])){
                                        $current_change = $current_change - $mine[$m][$y-1]["totaldebt"];
                                }

                                $cal += $current_change;
                                #Change in Equity
                                $current_eq = (isset($mine[$m][$y][66])?$mine[$m][$y][66]:0);
                                if(isset($mine[$m][$y-1]) && isset($mine[$m][$y-1][66])){
                                        $current_eq = $current_eq - $mine[$m][$y-1][66];
                                }
                                 $cal += $current_eq;

                                $totalintngible = (isset($mine[$m][$y]["totalintngible"])?$mine[$m][$y]["totalintngible"]:0);
                                if(isset($mine[$m][$y-1]) && isset($mine[$m][$y-1]["totalintngible"])){
                                        $totalintngible = $totalintngible - $mine[$m][$y-1]["totalintngible"];
                                }

                                if($totalintngible > 0)
                                    $cal += $totalintngible;


                                $mine[$m][$y]["value"] = $cal;
                            }else{
                                $mine[$m][$y]["value"] = 0;
                            }


                        }elseif(Input::get("QueryBuilder")["quirytype"] == 8 || Input::get("QueryBuilder")["quirytype"] == 9 ){
                            ### Number of Linked Units Issued (Actual)
                            if($item->property_id == 237){
                                $mine[$m][$y]["actual"] = (isset($mine[$m][$y]["actual"])?$mine[$m][$y]["actual"]:0)+$item->value;
                            }
                            $totaldebt = array(67,68,69,70,72,79 );
                             if (in_array($item->property_id, $totaldebt )) {
                                $mine[$m][$y]["totaldebt"] = (isset($mine[$m][$y]["totaldebt"])?$mine[$m][$y]["totaldebt"]:0)+$item->value;
                            }

                            if($item->property_id == 172 || $item->property_id == 173 ){
                                $mine[$m][$y]["fiscal"] = (isset($mine[$m][$y]["fiscal"])?$mine[$m][$y]["fiscal"]:0)+$item->value;
                            }

                            if(isset($mine[$m][$y]["totaldebt"]) && isset($mine[$m][$y]["actual"]) && isset($mine[$m][$y]["fiscal"])){

                                 $new_value = ($mine[$m][$y]["actual"]*$mine[$m][$y]["fiscal"]) + $mine[$m][$y]["totaldebt"];



                                if($this->vars['includeinflation'] && Input::get("QueryBuilder")["inflationyear"]){
                                    if(isset($mine[$m][$y]["unin_value"])){
                                            #$new_value_2 = $mine[$m][$y]["unin_value"] +  $new_value;
                                            $new_value_2 =  $new_value;
                                            $mine[$m][$y]["value"] = $this->applyInflation($new_value_2,$y);

                                            $mine[$m][$y]["unin_value"] += $new_value_2;
                                    }else{
                                            $mine[$m][$y]["value"] = $this->applyInflation($new_value,$y);

                                            $mine[$m][$y]["unin_value"] = $new_value;
                                    }
                                }else{
                                    if(isset($mine[$m][$y]["value"])){
                                            $mine[$m][$y]["value"] += $new_value;
                                    }else{
                                            $mine[$m][$y]["value"] = $new_value;
                                    }
                                }

                            }else{
                                    $mine[$m][$y]["value"] = 0;
                            }


                        }else{
                            if($this->vars['includeinflation'] && Input::get("QueryBuilder")["inflationyear"]){
                                if(isset($mine[$m][$y]["value"])){
                                        $new_value = $mine[$m][$y]["unin_value"] +  $item->value;
                                        $mine[$m][$y]["value"] = $this->applyInflation($new_value,$y);

                                        $mine[$m][$y]["unin_value"] += $item->value;
                                }else{
                                        $mine[$m][$y]["value"] = $this->applyInflation($item->value,$y);

                                        $mine[$m][$y]["unin_value"] = $item->value;
                                }
                            }else{
                                if(isset($mine[$m][$y]["value"])){
                                        $mine[$m][$y]["value"] += $item->value;
                                }else{
                                        $mine[$m][$y]["value"] = $item->value;
                                }
                            }
                        }
                    }

                    if(!empty($mine) || Input::get("QueryBuilder")["includeemptycompany"]){
                        $monster[$k]["name"] =  $value->name;
                        $monster[$k]["ticker"] =  $value->ticker;
                        $monster[$k]["industry"] =  $value->industry->name;
                        $monster[$k]["months"] = $mine;
                        $monster[$k]["monthscount"] = count($countm);
                    }

                }
                //trace_log($monster);
                $this->vars['monster'] = $monster;
                $dateheader = DataMineModel::
                select(DB::raw("DATE_FORMAT(datea,'%Y') as datea_h"))
                ->whereIn('company_id',  $arrayName)
                ->whereIn('property_id',$q)
                ->whereBetween('datea', array($data['startdate'], $data['enddate']." 23:59:00"))
                ->groupBy("datea_h")
                ->orderby('datea_h','asc')->get();




        }elseif(Input::get("QueryBuilder")["quirytype"] == 1){
                #trace_log( $arrayName);
                #trace_log(array(Input::get("QueryBuilder")["company"]));
                $data = array('startdate' => Input::get("QueryBuilder")["datea"], 'enddate' =>Input::get("QueryBuilder")["dateb"],'property_id' => Input::get("QueryBuilder")["property"]);

                $monster = array();

                $obj = Company::whereIn('id',  $arrayName)
                ->with(["mines" => function ($query) use ($data) {
                    $query->whereBetween('datea', array($data['startdate'], $data['enddate']." 23:59:00"));
                    $query->where('property_id',"=", $data["property_id"]);
                    $query->orderby('datea','asc');
                }])
                ->orderby('name','asc')->get();

                foreach ($obj as $key => $value) {
                    $k = $value->id;


                    $mine  = array();
                    $countm = array();
                    foreach ($value->mines as $mkey => $item) {
                        $date = new Carbon($item->datea);
                        $m =  $date->format('F');
                        $countm[$m] = $m;
                        if(Input::get("QueryBuilder")["fixmonth"]){
                            $m = "monthall";
                        }
                        $y =  $date->format('Y');

                        if($this->vars['includeinflation'] && Input::get("QueryBuilder")["inflationyear"]){
                             $mine[$m][$y]["value"] = $this->applyInflation($item->value,$date->format('Y'));
                        }else{
                            $mine[$m][$y]["value"] = $item->value;
                        }

                        $mine[$m][$y]["cur"] = $item->cur;


                    }
                    if(!empty($mine) || Input::get("QueryBuilder")["includeemptycompany"]){
                        $monster[$k]["name"] =  $value->name;
                        $monster[$k]["ticker"] =  $value->ticker;
                        $monster[$k]["industry"] =  $value->industry->name;
                        $monster[$k]["months"] = $mine;
                        $monster[$k]["monthscount"] = count($countm);
                    }

                }
                //trace_log($monster);
                $this->vars['monster'] = $monster;
                $dateheader = DataMineModel::
                select(DB::raw("DATE_FORMAT(datea,'%Y') as datea_h"))
                ->whereIn('company_id',  $arrayName)
                ->where('property_id', Input::get("QueryBuilder")["property"])
                ->whereBetween('datea', array($data['startdate'], $data['enddate']." 23:59:00"))
                ->groupBy("datea_h")
                ->orderby('datea_h','asc')->get();

        }else{
            $data = array('startdate' => Input::get("QueryBuilder")["datea"], 'enddate' =>Input::get("QueryBuilder")["dateb"],'property_id' => Input::get("QueryBuilder")["property"]);


            $obj = Company::whereIn('id',  $arrayName)
            ->with(["mines" => function ($query) use ($data) {
            $query->whereBetween('datea', array($data['startdate'], $data['enddate']." 23:59:00"));
            $query->where('property_id',"=", $data["property_id"]);
            }])
            ->orderby('name','asc')->get();

            if($this->vars['includeinflation'] && Input::get("QueryBuilder")["inflationyear"]){
                foreach ($obj as $mkey => $value ) {
                    foreach ($value->mines as $key => $item) {
                        $date = new Carbon($item->datea);
                        $item->value =   $this->applyInflation($item->value,$date->format('Y'));
                    }

                }
            }

            $dateheader = DataMineModel::select("datea")
            ->whereIn('company_id',  $arrayName)
            ->where('property_id', Input::get("QueryBuilder")["property"])
            ->whereBetween('datea', array($data['startdate'], $data['enddate']." 23:59:00"))
            ->groupBy("datea")
            ->orderby('datea','asc')->get();

            $this->vars['monster'] = $obj;
        }


        $this->vars['dateheader'] = $dateheader;
        if($this->checkReport(Input::get("QueryBuilder")["quirytype"])){
            $this->vars['propertyheader'] = PropertyModel::where("id",$this->getReport(Input::get("QueryBuilder")["quirytype"]))->first();
        }else{
            $this->vars['propertyheader'] = PropertyModel::where("id",Input::get("QueryBuilder")["property"])->first();
        }

        $this->vars['displaycur'] = Input::get("QueryBuilder")["displaycur"];
        $this->vars['removedecimals'] = Input::get("QueryBuilder")["removedecimals"];

        $this->vars['includeemptycompany'] = Input::get("QueryBuilder")["includeemptycompany"];
        $this->vars['fixmonth'] = Input::get("QueryBuilder")["fixmonth"];
        $this->vars['quirytype'] = Input::get("QueryBuilder")["quirytype"];
        $this->vars['checkreport'] = $this->checkReport(Input::get("QueryBuilder")["quirytype"]);



        if($this->checkReport(Input::get("QueryBuilder")["quirytype"])){
           $this->vars['fixmonth'] = 1;
        }

        ###Inadd inflation
        // if($this->vars['includeinflation'] && Input::get("QueryBuilder")["inflationyear"]){
        //     $this->applyInflation( &$this->vars['monster'], $this->vars['inflationyear'] );
        // }

        if(Input::get("QueryBuilder")["quirytype"] == 6 ||Input::get("QueryBuilder")["quirytype"] == 7 ){
            return [
                    '#previewquote' => $this->makePartial('bycurrentyear')
            ];
        }elseif(Input::get("QueryBuilder")["quirytype"] == 1 || $this->checkReport(Input::get("QueryBuilder")["quirytype"])){
            return [
                    '#previewquote' => $this->makePartial('bymonth')
            ];
        }else{
             return [
                    '#previewquote' => $this->makePartial('test')
            ];
        }

    }

    function checkReport($id){
        if($id == 3 || $id == 4 || $id == 5 || $id == 6 || $id == 7 || $id == 8 || $id == 9 || $id == 10|| $id == 11){
                return true;
        }else{
            return false;

        }
    }

    function getReport($id){

        if($id == 3){
            return 164;
        }
        if($id == 4){
            return 165;
        }
        if($id == 5){
            return 166;
        }
        if($id == 6){
            return 167;
        }
        if($id == 7){
            return 168;
        }
        if($id == 8){
            return 172;
        }
        if($id == 9){
            return 173;
        }
        if($id == 10){
            return 240;
        }
         if($id == 11){
            return 241;
        }
        return $id;
    }
    function applyInflation($value, $year){

        if(isset($this->vars['inflation'][$year])){
            $cpi = $this->vars['inflation'][$year];
            return $value*($this->vars['inflationyear_value']/$cpi);
        }else{
            return $value;
        }


    }

    function isAllIn($arr,$obj){
        $x = 0;
        if(count($obj)>0){
                foreach ($arr as $key => $value) {
                    if(isset($obj[$value])){
                       $x++;
                    }else{
                        // trace_log ("No Match $value");
                        //  trace_log ($obj);
                    }
                }
        }
        // trace_log (count($arr)." = $x ");
        return (count($arr) == $x & $x > 0)?true:false;



    }
}
