<?php namespace RW\PLProperties\Components;

use Cms\Classes\ComponentBase;
use RW\PLProperties\Models\Property as PropertyModule;
use RainLab\User\Models\User as UserModel;
use RW\PLProperties\Models\SearchedProperties;
use Flash;      
use Auth;
use Input;
use Redirect;
use RW\PLProperties\Models\PropertyCategory;
use RW\PLAdmin\Models\ClientQuestionnaire;

use RW\PLAdmin\Models\ClientRequest;
use Illuminate\Support\Facades\Session;


use RW\PLCommon\Classes\Lightstone;

class ClientAdd extends ComponentBase
{
    public $saddess = array();
    public $searcsplit = array();
    public function componentDetails()
    {
        return [
            'name'        => 'ClientAdd Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){

        $this->page->title = "Property Search";
        $this->saddess = array('erf'=> 'Erf No',
        'portion'=> 'Portion',
        'sectionaltitle'=> 'Sectional Title Complex',
        'estatename'=> 'Estate Name',
        'unit'=> 'Unit No',
        'farmname'=> 'Farmname',
        'portion'=> 'Portion',
        'street'=> 'Street Name',
        'streetnumber'=> 'Street No',
        'deedtown'=> 'Town');

        $this->searcsplit["natural_person_1"] = array(
            'ownername[]'=> 'First Name',
            
        );
        
        $this->searcsplit["natural_person_2"] = array(
            'ownername[]'=> 'Second Name',
        );
        
        $this->searcsplit["natural_person_3"] = array(
            'ownername[]'=> 'Surname',
            'idck[]'=> 'ID Number'
        );


        $this->searcsplit["legal_person"] = array(
            'ownername[]'=> 'Company Name',
            'idck[]'=> 'Registration Number',
        );

        $this->searcsplit["property_details"]  = array(
            'deedtown'=> 'Township ',           
            'erf[]'=> 'Erf No',
            'portion[]'=> 'Portion',
            'sectionaltitle'=> 'Sectional Title',
            'unit'=> 'Unit No',  
            'province'=> 'province',         
            'municipality'=> 'Municipality',
            'estatename'=> 'Estate Name',
           );

        $this->searcsplit["sec_3"] = array(
          'farmname'=> 'Farm name',
          'erf[]'=> 'Farm No',
          'portion[]'=> 'Portion',
        );

        $this->searcsplit["sec_4"] = array(
            'suburb'=> 'Suburb',
            'street'=> 'Street Name',
            'streetnumber'=> 'Street No',
        );

      
    }

    public function getPropertyCategory(){
        return PropertyCategory::where("parent_id",0)->orwhereNull("parent_id")->orderby("sort_order")->get();
    }

    public function onSearch(){
        $searchlightstone = new Lightstone();
        $searchlightstone->set_searchform();
        $r = $searchlightstone->searchresults($searchlightstone->searform);

        if(is_array($r) && isset($r["properties"])){
            $this->page["results_count"] = count($r["properties"]);
            $this->page["SS"] = 0;
            $this->page["FH"] = 0;
            $this->page["FRM"] = 0;
            $pids = [];

            foreach ($r["properties"] as $key => $data) {
                $pids[intval($data["prop_id"])] = intval($data["prop_id"]);

                if ( strtolower($data["property_type"]) == 'ss' ){
                    $this->page["SS"] = $this->page["SS"]+ 1;
                }else if ( strtolower($data["property_type"]) == 'fh'){
                    $this->page["FH"] = $this->page["FH"] + 1;
                }else if ( strtolower($data["property_type"]) == 'frm'){
                    $this->page["FRM"] = $this->page["FRM"] + 1;
                }
            }
            
            $this->page["pids"] = $pids;

            $list = SearchedProperties::whereIn("prop_id",$pids)->get();

            foreach ($list as $key_ => $value_) {
                foreach ($r["properties"] as $key => &$data) {
                    if($value_->prop_id == $data["prop_id"]){
                        $data["searchtext"] = $value_->searchtext;
                    }
                }
            }

            $this->page["propeties"] = $r["properties"];

            if( Input::has("clientid") &&  !empty(Input::get("clientid")) ){
                $user = Auth::getUser();
                $thisuser = UserModel::find($user->id);
               
                if(!empty($thisuser->companies)){
                    foreach ($thisuser->companies as $key => $value) {
                        if(Input::get("clientid") == $value->client->id){
                             $this->page["client"] = $value;
                        }
                    }   
                }
            }          

        }else{
            
            $this->page["results_count"] = 0;
            $this->page["propeties"] = null;
        }

        // return [
        //         '#resultsholder' => $this->makePartial('p_resultsholder')
        // ];

    }

      public function onAddProperty(){

         $howsave = Input::has("howsave")?Input::get("howsave"):1;

        $searchlightstone = new Lightstone();
        $v = "propid";
        if( Input::has($v) &&  !empty(Input::get($v)) ){
          
            $searchlightstone->SaveResults(Input::get($v));
            

            if($searchlightstone->error){
                \Flash::error($searchlightstone->error);
            }else{
                if($searchlightstone->tracking > 0){
                    $property = PropertyModule::find($searchlightstone->tracking);
                    $user = Auth::getUser();
                    $property->client = $user->client;
                    $client_id = $user->client->id;
                    if( Input::has("clientid") &&  !empty(Input::get("clientid")) && Input::get("clientid") > 0){
                        $user = Auth::getUser();
                        $thisuser = UserModel::find($user->id);
                       
                        if(!empty($thisuser->companies)){
                            foreach ($thisuser->companies as $key => $value) {
                                if(Input::get("clientid") == $value->client->id){
                                    $property->client = $value->client;
                                    $client_id = $value->client->id;
                                }
                            }   
                        }
                    }

                    $property->save();
                    if(isset($property->prop_id) && $property->prop_id > 0){
                           
                        $s =  new ClientQuestionnaire();
                        $s->client_id = $client_id;
                        $s->prop_id = $property->prop_id;
                        
                        $s->municipality_account_pin = Input::get("municipality_account_pin");
                        $s->municipality_account_number = Input::get("municipality_account_number");
                        $s->municipality_rates_number = Input::get("municipality_rates_number");
                        $s->municipality_reference_number = Input::get("municipality_reference_number");
                        
                        $s->save();

                        if(is_array(Input::get("usage") )){
                            $lol = [];
                            foreach (Input::get("usage") as $key => $value) {
                                $c = PropertyCategory::find($value);
                                $lol[] = $c;
                            }
                            $s->categories = $lol;
                            $s->save();
                        }

                        if (Session::has('newquery') ) {
                            $id = Session::get('newquery');
                            $cr = ClientRequest::find($id);
                            $list =  explode(',', $cr->propertylist);
                            array_push($list,$property->prop_id);
                            array_unique($list);
                           
                            $cr->propertylist = implode(",", $list);
                            $cr->save();
                        } 

                        \Flash::success('Property was added successfully to your profile...');
                        
                        $url = $this->controller->pageUrl('account/property/new');
                      
                        if($howsave == 2){
                              $url = $this->controller->pageUrl('account/property/new');
                        }else{
                            if (Session::has('newquery') && Session::has("backhere")) {
                                $url = Session::get("backhere");
                            }else{
                                $url = $this->controller->pageUrl('account/property/item',[':item'=>$searchlightstone->tracking,':client'=>$client_id]); 
                            }
                        }                        
                        return Redirect::to($url);
                    }else{

                    }

                }else{
                    \Flash::error($searchlightstone->error);
                }
            }
            
        }else{
            \Flash::success('Sorry, could not add');
           
        }
    }

    public function getcompanylist(){
        $user = Auth::getUser();
        $thisuser = UserModel::find($user->id);
       
        if(!empty($thisuser->companies))
        return $thisuser->companies;
    }

    
}
