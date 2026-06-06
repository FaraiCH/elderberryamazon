<?php

namespace RW\PLCommon\Classes;
use Input;
use SoapClient;
use SimpleXmlReader\SimpleXmlReader;
use DB;
use Carbon\Carbon;

use RW\PLProperties\Models\Owners;
use RW\PLProperties\Models\CompSales;
use RW\PLProperties\Models\Amenities;
use RW\PLProperties\Models\Bonds;
use RW\PLProperties\Models\SuburbTrends;
use RW\PLProperties\Models\Transfers;
use RW\PLProperties\Models\Images;

use RW\PLProperties\Models\MunicipalValuation;
use RW\PLProperties\Models\ReportPDF;
use \RW\PLProperties\Models\Property as PropertyModel;

class Lightstone {

    public $userid;
    public $track;
    public $maxrow;
    public $propid;
    public $tracking;
    public $searform = array();
    public $error = null;
    public $warning = null;
    public $isRelod = false;
    public function __construct($userid = '517518d3-78d8-4fc9-966e-152cad2c9a99',$track = 4, $maxrow = 10) {
        $this->userid = $userid;
        $this->track = $track;
        $this->maxrow = $maxrow;
    }

    public function setReload($is){
        $this->isRelod = $is;
    }

    public function set_searchform(){

        $this->searform['userid'] = $this->userid;
        $this->searform['track'] = $this->track;
        $this->searform['maxrow'] = $this->maxrow;

        ###BUILD SEARCH RESULTS
        $pieces = explode(" ", 'idck province municipality deedtown erf portion sectionaltitle unit suburb street streetnumber fname estatename farmname ownername maxrow SecondName txtPersonSurname txtTitleDeed title_deed_no');
        $pArray = array();
        if( Input::has("Property") &&  !empty(Input::get("Property")) ){
            $pArray[] = Input::get("Property");
        }

        foreach ($pieces as $key => $value) {
            if( Input::has($value) && Input::get($value) ){
                if(is_array(Input::get($value) )  ){
                   $newval = array_filter(Input::get($value));
                   if(!empty(input::get($value)) && count($newval) > 0 ){
                        $this->searform[$value] =  array_filter(Input::get($value));
                   }

                }else{
                    if(!empty(input::get($value)) ){
                        $this->searform[$value] = Input::get($value);
                    }
                }
            }

            if( isset($pArray[0][$value]) && $pArray[0][$value]){
                $this->searform[$value] = $pArray[0][$value];
            }
        }



    }

    public function set_fakesearchform($id){
        $this->searform['userid'] = $this->userid;
        $this->searform['track'] = $this->track;
        $this->searform['maxrow'] = $this->maxrow;
        $className = "RW\PLProperties\Models\Property";
        $s = $className::find($id);

        if(!empty($s) ){


            $pieces = array("deedtown"=>"deedtown","erf"=>"erf","portion"=>"portion","sectional_title"=>"sectionaltitle","unit"=>"unit","suburb"=>"suburb","farmname"=>"farmname");
             foreach ($pieces as $key => $value) {
                if($s->$key){
                    $this->searform[$value] = $s->$key;
                }
            }
        }

    }


    public function deleteSearch($id){
        $className = "RW\PLProperties\Models\SearchedProperties";
        $s = $className::find($id);

        if(!empty($s)){
            $s->delete();
        }


    }

    public function searchresults($form){
        return  $this->getProperty($form);
    }
    private function getProperty($form){
        $response = $this->callMethod('ReturnProperties', $form );

        $chow =  $response->ReturnPropertiesResult->any;

        $reader = SimpleXmlReader::openFromString($chow);
        $p = array();
        foreach($reader->path('diffgr:diffgram/NewDataSet/Properties') as $property) {
                $p["properties"][] = (array)$property;

                $this->dbAddMultiple((array)$property,'SearchedProperties');
        }



        return $p;

    }

    public function callMethod($method,$ref) {
        $data = $this->$method($ref);
        return $this->runService($method,$data);
    }

    private function runService($method,$data) {
        try{
            $soapclient = new SoapClient('http://www.lightstone.co.za/avm/webservices/properties.asmx?WSDL');
           return $soapclient->$method($data);

        }catch(Exception $e){

            return null;
        }
    }

    private function confirmValidationProcess() {
        $form = array('userid' => $this->userid, 'track' => $this->tracking, 'propid'=> $this->propid);
        $response = $this->callMethod('ConfirmValidation', $form );
        $chow =  $response->ConfirmValidationResult->any;
        $reader = SimpleXmlReader::openFromString($chow);
        $p = array();
        foreach($reader->path('diffgr:diffgram/NewDataSet/Confirmation_Details') as $property) {
            $p[] = (array)$property;
        }

        if ($p[0]['TrackingNumber'] == $this->tracking){
            return true;
        }else{
            return false;
        }
    }


    private function ReturnProperties($data) {
      $arr =  array();
        $arr["User_ID"] = $data['userid'];
        $arr["TrackingNumber"] = $data['track'];
        $arr["MaxRowsToReturn"] = $data['maxrow'];
        $arr["ID_CK"] = $this->ifData($data,'idck');
        $arr["Province"] = (isset($data['province'])?$data['province']:"");
        $arr["Municipality"] = (isset($data['municipality'])?$data['municipality']:"");
        $arr["DeedTown"] = (isset($data['deedtown'])?$data['deedtown']:"");
        $arr["Erf"] = $this->ifData($data,'erf');
        $arr["Portion"] = $this->ifData($data,'portion');
        $arr["Sectional_Title"] = (isset($data['sectionaltitle'])?$data['sectionaltitle']:"");
        $arr["TitleDeed"] = $this->ifData($data,'txtTitleDeed');
        $arr["Unit"] = (isset($data['unit'])?$data['unit']:"");
        $arr["Suburb"] = (isset($data['suburb'])?$data['suburb']:"");
        $arr["Street"] = (isset($data['street'])?$data['street']:"");
        $arr["StreetNumber"] = (isset($data['streetnumber'])?$data['streetnumber']:"");
        $arr["Owner_Name"] = $this->ifData($data,'ownername');
        $arr["Estate_Name"] = (isset($data['estatename'])?$data['estatename']:"");
        $arr["FARM_NAME"] = (isset($data['farmname'])?$data['farmname']:"");


        return $arr;
    }

    private function ifData($data,$key){
        if(isset($data[$key]) && is_array($data[$key])){
            return implode(' ',array_filter($data[$key]) );
        }else{
            return (isset($data[$key])?$data[$key]:"");
        }
    }

    private function ConfirmValidation($data) {
        return array("User_ID"=>$data['userid'],'TrackingNumber'=>$data['track'],'Prop_ID'=>$data['propid']);
    }

     private function ReturnPropertyReport($data) {
        return array("User_ID"=>$data['userid'],'TrackingNumber'=>$data['track']);
    }

    private function returnPropertyReportProccess() {
        $response = $this->callMethod('ReturnPropertyReport', array('userid' => $this->userid,'track' => $this->tracking) );
        $chow =  $response->ReturnPropertyReportResult->any;
        $reader = SimpleXmlReader::openFromString($chow);

        $p = array();
        foreach($reader->path('diffgr:diffgram/NewDataSet') as $property) {
            $p[] = (array)$property;
            $this->dbAddMultiple((array)$p[0]["Property"],'Property');
            if(isset($p[0]["Owners"]))
                $this->dbAddMultiple((array)$p[0]["Owners"],'Owners');
            if(isset($p[0]["CompSales"]))
                $this->dbAddMultiple((array)$p[0]["CompSales"],'CompSales');
            if(isset($p[0]["Bonds"]))
                $this->dbAddMultiple((array)$p[0]["Bonds"],'Bonds');

            if(isset($p[0]["Amenities"]))
                $this->dbAddMultiple((array)$p[0]["Amenities"],'Amenities');

            if(isset($p[0]["Images"]))
                $this->dbAddMultiple((array)$p[0]["Images"],'Images');
            if(isset($p[0]["ReportPDF"]))
                $this->dbAddMultiple((array)$p[0]["ReportPDF"],'ReportPDF');
            if(isset($p[0]["MunicipalValuation"]))
                $this->dbAddMultiple((array)$p[0]["MunicipalValuation"],'MunicipalValuation');
            if(isset($p[0]["SuburbTrends"]))
                $this->dbAddMultiple((array)$p[0]["SuburbTrends"],'SuburbTrends');
            if(isset($p[0]["Transfers"]))
                $this->dbAddMultiple((array)$p[0]["Transfers"],'Transfers');
        }


        return null;
    }

    private function dbAddMultiple($data,$modname){

        if( isset($data[0]) ){

            foreach ($data as $key => $value) {
                $this->dbStoreResults((array)$value,$modname);
            }
        }else{

            $this->dbStoreResults((array)$data,$modname);
        }

    }

    public function dbStoreResults($data,$modname){
        if(empty($data)){

            return null;
        }

        $className = "RW\PLProperties\Models\\".$modname;

        if($modname == 'SearchedProperties'){

            $this->setProperty($data['prop_id'],$className);
        }



        if($this->error || $this->warning){

            return null;
        }


        $mod = new $className();

        if($modname == 'Property' && $this->isRelod){
            $mod = $className::find($data['prop_id']);

        }

        if($modname == 'SearchedProperties' && $this->isRelod){
            $mod = $className::find($data['prop_id']);
            if(empty($mod))
                $mod = new $className();


        }



        $table_name = $mod->table;
        $cols = DB::getSchemaBuilder()->getColumnListing($table_name);
        $countrows = 0;

        foreach ($data as $key => $value) {

            if(in_array(strtolower($key),$cols)){
                $t = strtolower($key);
                if($t == "prop_id"){
                    $newkey = "ext_prop_id"; ###comp sales links to other propertis
                    if(in_array(strtolower($newkey),$cols)){
                        $mod->$newkey = $value;
                        $countrows++;
                    }
                }else{
                    if($modname == 'ReportPDF' || $modname == 'Images'){
                        if($t == "pdfurl"){# || $t == "Req_ID" || $t == "Image_Cadaster" || $t == "Image_AerialPhoto" || $t == "Image_Google" ){

                            $file = new \System\Models\File;
                            $file->fromUrl($value, 'report '.Carbon::now()->format('Y-M-d').'.pdf');
                            //$file->save();
                            $mod->files = $file;

                        }

                    }


                    $mod->$t = $value;
                    $countrows++;
                }

            }
         }
         if($countrows > 0 ){
            $mod->prop_id = $this->propid;
            if($modname == 'SearchedProperties'){
                $this->buildSearchtext($mod);
            }

            if(isset($mod->farmname) && !empty($mod->farmname) && isset($mod->proptype_id)){
                $mod->proptype_id = 1;

                if(isset($mod->farmname) && !empty($mod->farmname) && isset($mod->township)){
                    $mod->township = $mod->farmname;
                }
            }
            if(!empty($mod->prop_id) && $mod->prop_id > 0 )
            $mod->save();
         }

    }
    public function buildSearchtext($mod)
    {
         $street = implode(", ",  array_filter(array($mod->street_number,$mod->street_name,$mod->street_type) ) );
         $street = "";

        if ( strtolower($mod->property_type) == 'ss' ){
            $mod->searchtext = "Unit ". implode(", ", array_filter(array($mod->unit,str_replace("SS ",'',$mod->sectional_title)." (".$mod->ss_number."/".$mod->ss_year.")" ) ) );
        }else if ( strtolower($mod->property_type) == 'fh'){
            if(empty($mod->farmname) ){
                $mod->searchtext = $this->buildfh($mod);
            }else{
                #BUILD FORM NAME
                $mod->searchtext = $this->buildfarmname($mod);
            }

        }else if ( strtolower($mod->property_type) == 'frm'){
           $mod->searchtext = $this->buildfarmname($mod);
        }else{
             $mod->searchtext = $this->buildfh($mod);
        }
    }



    public function buildfh($mod){

        if($mod->portion == 0 && $mod->re == "false"){
            return implode(", ", array_filter( array( 'ERF '.$mod->erf."", $mod->township)) );

        }elseif ($mod->portion <> 0 && $mod->re == "false"){

             return implode(", ", array_filter( array( 'Ptn '.$this->checkportion($mod->portion), " of ERF ".$mod->erf, $mod->township)) );
        }elseif ($mod->portion <> 0 && $mod->re == "true"){

            return implode(", ", array_filter( array( 'Re of Ptn '.$this->checkportion($mod->portion), " of ERF ".$mod->erf, $mod->township)) );
        }elseif ($mod->portion == 0  && $mod->re == "true"){

                return implode(", ", array_filter( array( "Re of ERF  ".$mod->erf, $mod->township)) );

        }else{
            return implode(", ", array_filter( array( 'ERF '.$mod->erf, $mod->township)) );
        }
    }

    public function buildfarmname($mod){
        $os = array("WC", "NC", "EC", "FS");

        if (strtolower($mod->property_type) == 'fh'){
            $mod->property_type = 'frm';
        }
        if($mod->farmname)
            $mod->township = $mod->farmname;



        if (in_array($mod->province, $os)) {
            $erf = "";
            if($mod->erf > 0);
                $erf = " No ".$mod->erf ;

            if ($mod->re == "true"){
                return implode(", ", array_filter( array( ($mod->portion <> 0?'Re of Ptn ':"").$this->checkportion($mod->portion),  $mod->farmname.$erf, $mod->deedtown)) );
            }else{
               if($mod->portion <> 0){
                    return implode(", ", array_filter( array( ($mod->portion <> 0?'Ptn ':"").$this->checkportion($mod->portion), $mod->farmname.$erf, $mod->deedtown)) );
                }else{
                    return implode(", ", array_filter( array( "FARM", $mod->farmname.$erf, $mod->deedtown)) );
                }

            }
        }else{

            $erf = "";
            if($mod->erf > 0);
                $erf = " ".$mod->erf ;


             if ($mod->re == "true"){
                if($mod->portion <> 0){
                    return implode(", ", array_filter( array( ($mod->portion <> 0?'Re of Ptn ':"").$this->checkportion($mod->portion), implode("-",array($mod->farmname.$erf , $mod->deedtown) ) ) ) );
                }else{
                    return implode(", ", array_filter( array( "Re of FARM", implode("-",array($mod->farmname.$erf, $mod->deedtown) ) ) ) );
                }

            }else{
                if($mod->portion <> 0){
                    return implode(", ", array_filter( array( ($mod->portion <> 0?'Ptn ':"").$this->checkportion($mod->portion), implode("-",array($mod->farmname.$erf, $mod->deedtown) ) ) ) );
                }else{
                    return implode(", ", array_filter( array( "FARM",  implode("-",array($mod->farmname.$erf, $mod->deedtown) ) ) ) );
                }
            }
        }
    }


    public function checkportion($data){
        return ((isset($data) && $data)?$data:"");
    }

    function check($data){
        return (isset($data)?$data:"");
    }

    public function setProperty($prop,$model){
        $obj = $model::find($prop);
        if(empty($obj) || $this->isRelod){
           $this->propid = $prop;
            $this->warning = null;
            $this->error = null;

        }else{
            $this->propid = $prop;
            $this->warning = 'Property already in database. '.$prop;
        }
    }

    public function SaveResults($prop){
        $this->setProperty($prop,'RW\PLProperties\Models\Property');

        if($this->error)
            return null;

        $this->tracking = $prop;

         if($this->warning)
            return null;

        if($this->confirmValidationProcess() ){
            ##GET PROPERTY REPORTS AND STORE IN IN THE DATABASE
            $rpt = $this->returnPropertyReportProccess();

        }
    }

    public function chowXML($chow,$method){
        $reader = SimpleXmlReader::openFromString($chow);
        $p = array();

        if($method == "Estates"){
            foreach($reader->path('diffgr:diffgram/dsEstates/Esatates') as $property) {
                $p["item"][] = (array)$property;
            }

        }else if($method == "Streets"){
                foreach($reader->path('diffgr:diffgram/NewDataSet/Street') as $property) {
                    $p["item"][] = (array)$property;
                }

            }else{
                foreach($reader->path('diffgr:diffgram/NewDataSet/Table') as $property) {
                    $p["item"][] = (array)$property;
                }
            }


        return $p;
    }

}

?>
