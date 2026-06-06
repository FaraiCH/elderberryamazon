<?php

namespace RW\PLCommon\Classes;
use RW\PLCommon\Classes\Lightstone;
use Input;

class LightstoneSearch extends Lightstone  {

    public function simplate_searchform(){

        ##build form
        $this->searform['userid'] = $this->userid;
        $this->searform['track'] = $this->track;
        $this->searform['maxrow'] = $this->maxrow;

        $method = "Towns";
        $who = array('method' => "Towns", 'name'=> "town", 'municipality' => 'municipality');

        if(Input::get("lscall") == 'Property[township]'){
            $this->searform['townname'] = Input::get("q");
           
        }

        if(Input::get("lscall") == 'Property[suburb]'){
            $this->searform['Suburb'] = Input::get("q");
            $who = array('method' => "Suburbs", 'name'=> "Suburb", 'municipality' => 'MunicName');
        }

        if(Input::get("lscall") == 'Property[estate_name]'){
            $this->searform['Estate_Name'] = Input::get("q");
            $who = array('method' => "Estates", 'name'=> "estate_name", 'municipality' => 'municipality');
        }

        if(Input::get("lscall") == 'Property[street]'){
            $this->searform['street_name'] = Input::get("q");
            $who = array('method' => "Streets", 'name'=> "street_name", 'municipality' => 'municipality',"suburb"=>"suburb");
        }

     
        $r = $this->getQuery($this->searform,$who['method']);  
        
        $results = array(Input::get("q")=>Input::get("q")." ***New");
        if(isset($r["item"])){
            foreach ($r["item"] as $key => $value) {
                if($who['method'] == "Streets" ){
                    $results[$value[$who["name"]] ] = $value[$who["name"]]." | ".$value[$who["suburb"]]." | ".$value[$who["municipality"] ];
                }else{
                    $results[$value[$who["name"]] ] = $value[$who["name"]]." | ".$value[$who["municipality"] ];    
                }
                
            }
        }
        return $results;

    }

    private function getQuery($form,$method){
        $response = $this->callMethod('return'.$method, $form );
       
        $t = "return".$method."Result";
        if($method == "Suburbs" || $method == "Estates")
            $t = "Return".$method."Result";
        $chow =  $response->$t->any;
        

        $r = $this->chowXML($chow,$method);
        
        return $r;
    }

    public function returnTowns($data) {
        $arr =  array();
        $arr["User_ID"] = $data['userid'];
        $arr["TrackingNumber"] = $data['track'];
        $arr["MaxRowsToReturn"] = $data['maxrow'];
        $arr["townname"] = (isset($data['townname'])?$data['townname']:"");
        return $arr;
    }

    public function returnSuburbs($data) {
        $arr =  array();
        $arr["User_ID"] = $data['userid'];
        $arr["TrackingNumber"] = $data['track'];
        $arr["MaxRowsToReturn"] = $data['maxrow'];
        $arr["Suburb"] = (isset($data['Suburb'])?$data['Suburb']:"");
       
        return $arr;
    }

    public function returnEstates($data) {
        $arr =  array();
        $arr["User_ID"] = $data['userid'];
        $arr["TrackingNumber"] = $data['track'];
        $arr["MaxRowsToReturn"] = $data['maxrow'];
        $arr["Estate_Name"] = (isset($data['Estate_Name'])?$data['Estate_Name']:"");
       
        return $arr;
    }

    public function returnStreets($data) {
        $arr =  array();
        $arr["User_ID"] = $data['userid'];
        $arr["TrackingNumber"] = $data['track'];
        $arr["MaxRowsToReturn"] = $data['maxrow'];
        $arr["street_name"] = (isset($data['street_name'])?$data['street_name']:"");
        $arr["sub_id"] = 0;

        return $arr;
    }



    
}

?>