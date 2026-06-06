<?php namespace RW\PLProperties\Components;

use Cms\Classes\ComponentBase;
use RW\PLProperties\Models\Property as PropertyModule;
use RainLab\User\Models\User as UserModel;
use RW\PLAdmin\Models\ClientRequest;
use RW\PLAdmin\Models\RWService;
use RW\PLCommon\Models\Comment;
use RW\PLAdmin\Models\ClientQuestionnaire;
use RW\PLProperties\Models\PropertyCategory;
use RW\PLAdmin\Models\ClientQuestionnaireAnswer;
use RW\PLValuation\Models\Municipality;
use RW\PLProperties\Models\Question;
use October\Rain\Support\Collection;
use Auth;
use Flash;
use Input;
Use Validator;
use Redirect;
use ValidationException;
use Http;
use Mail;
use Config;
use Illuminate\Support\Facades\Session;

/**
 * QuestionnaireUpdate Component
 */
class QuestionnaireUpdate extends ComponentBase
{
    public $pitem;
    public $critem;
    public $user;
    public $qobj;
    public $answers;

    public function componentDetails()
    {
        return [
            'name' => 'QuestionnaireUpdate Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'item' => [
                'title'       => 'Property Item',
                'description' => 'Slug for business item',
                'default'     => '{{ :item }}',
                'type'        => 'string'
            ],
            'client' => [
                'title'       => 'Property client',
                'description' => 'Slug for business item',
                'default'     => '{{ :client }}',
                'type'        => 'string'
            ],
            'id' => [
                'title'       => 'Questionnaire id',
                'description' => 'Slug for business item',
                'default'     => '{{ :id }}',
                'type'        => 'string'
            ]

        ];
    }


    public function onRun(){
        $user = Auth::getUser();
        $this->user = UserModel::find($user->id);
        $f = 0;

        if($this->property('item') > 0 && $this->property('client') > 0 && $this->property('id') > 0){
            $obj = ClientQuestionnaire::where("prop_id",$this->property('item'))->where("client_id",$this->property('client'))->where("id",$this->property('id'))->first();
            if(!empty($obj) ){
                //dd($obj);
                $this->page->title = $obj->property->searchtext ." | REF# ".$this->property('client')."-".$this->property('item');

                $this->pitem = $obj->property;
                $this->qobj = $obj;

            }else{

            }

            // $listprop = $this->user->client->properties;
            // foreach ($listprop as $key => $value) {
            //     if($value->prop_id = $this->property('item')){
            //         $f = $this->property('item');
            //     }
            // }

            // if($f > 0){
            //     $this->pitem = PropertyModule::find($f);
            //     $this->critem = ClientRequest::where("user__id",$user->id)->where("prop_id",$f)->get();

            //     $this->page->title =$this->pitem->searchtext;


            // }
        }
    }

    public function getPropertyCategory(){
        return PropertyCategory::where("parent_id",0)->orwhereNull("parent_id")->get();
    }

    public function getMunicipality(){
        return Municipality::all();
    }

    public function getAnser($catid){
         return ClientQuestionnaireAnswer::
            where("prop_id",$this->property('item'))->
            where("client_id",$this->property('client'))->



            get();


    }

    public function onSaveQuestions(){
        $user = Auth::getUser();
        $this->user = UserModel::find($user->id);
        $f = 0;

        if($this->property('item') > 0 && $this->property('client') > 0 && $this->property('id') > 0){
            $obj = ClientQuestionnaire::where("prop_id",$this->property('item'))->where("client_id",$this->property('client'))->where("id",$this->property('id'))->first();

            $is_printeted = [];

            if(!empty($obj) ){
                $c = $obj->categories;




                foreach ($c as $key => $value) {
                   if(!empty($value->questions) ){

                        foreach ($value->questions as $key => $value) {


                            foreach ($value->questions as $k => $q) {
                                $qid = "qid_".$q["question"];

                                if( empty($is_printeted[$q["question"]]) ){

                                    // if( ( Input::has($qid) &&  !empty(Input::get($qid)) ) ||  Input::file($qid) ){
                                    if( empty($is_printeted[$q["question"]]) ){

                                        $a_q = ClientQuestionnaireAnswer::
                                            where("prop_id",$this->property('item'))->
                                            where("client_id",$this->property('client'))->

                                            // where("category_id",$obj->category->id)->
                                            where("question_id",$q["question"])->
                                            first();

                                         $q_obj = Question::find($q["question"]);

                                        $ans = null;

                                        if($q_obj->type == "file"){

                                            if(!empty(Input::file($qid))){


                                                if(empty($a_q)){
                                                    $s =  new ClientQuestionnaireAnswer();
                                                    $s->client_id = $this->property('client');
                                                    $s->prop_id = $this->property('item');

                                                    $s->question_id = $q["question"];

                                                    $s->qfile= Input::file($qid);
                                                    //$s->answer = $s->qfile->filename;
                                                    $s->save();

                                                }else{

                                                    $a_q->qfile= Input::file($qid);
                                                     //$a_q->answer =$a_q->qfile->filename;
                                                     $a_q->save();
                                                }

                                            }

                                        }else{
                                            if($q_obj->type == "table"){
                                                if(is_array(Input::get($qid) )){
                                                    $collection = new Collection(Input::get($qid));
                                                    $ans = $collection->toJson() ;
                                                }else{
                                                    $ans = Input::get($qid);
                                                }
                                            }else{
                                                if(is_array(Input::get($qid) )){
                                                    $ans = implode(",", Input::get($qid));
                                                }else{
                                                    $ans = Input::get($qid);
                                                }
                                            }

                                            if(empty($a_q)){
                                                $s =  new ClientQuestionnaireAnswer();
                                                $s->client_id = $this->property('client');
                                                $s->prop_id = $this->property('item');

                                                $s->question_id = $q["question"];
                                                $s->answer =$ans;
                                                $s->save();

                                            }else{
                                                $a_q->answer =$ans;
                                                 $a_q->save();
                                            }
                                        }

                                    }

                                }

                                $is_printeted[$q["question"]] = $q["question"];
                            }


                        }
                    }
                }

                  \Flash::success('Form was submitted successfully...');

                  if(Input::has('isredirect') && Input::get('isredirect') == 1 && Session::has("backhere")) {
                        $url = Session::get("backhere");
                        Session::forget('backhere');
                        return Redirect::to($url);
                  }else{

                  }

            }
        }

    }

    public function onUpateClientQuestion(){
        $user = Auth::getUser();
        $this->user = UserModel::find($user->id);
        $f = 0;

        if($this->property('item') > 0 && $this->property('client') > 0 ){
            $obj = ClientQuestionnaire::where("prop_id",$this->property('item'))->where("client_id",$this->property('client'))->where("id",$this->property('id'))->first();
            if(!empty($obj) ){


                $obj->municipality_account_pin = Input::get("municipality_account_pin");
                $obj->municipality_account_number = Input::get("municipality_account_number");
                $obj->municipality_rates_number = Input::get("municipality_rates_number");
                $obj->municipality_reference_number = Input::get("municipality_reference_number");
                $obj->save();


                if(is_array(Input::get("usage") )){

                    $lol = [];
                    foreach (Input::get("usage") as $key => $value) {
                        $c = PropertyCategory::find($value);
                        $lol[] = $c;

                    }
                    $obj->categories = $lol;
                    $obj->save();
                }


                \Flash::success('Form was submitted successfully...');
                $url = $this->controller->pageUrl('account/property/updateq',[':item'=>$obj->prop_id,':client'=>$obj->client_id,':id'=>$obj->id]);
                return Redirect::to($url);
            }else{
                 \Flash::error('Form could not be submited ...');
            }
        }
    }

    public function cheifprinted( $obj, $id){
        $obj[$id] = $id;
        return $obj;
    }
}
