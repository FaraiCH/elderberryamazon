<?php namespace Bt\PLProperties\Components;

use Cms\Classes\ComponentBase;
use RW\PLProperties\Models\Property as PropertyModule;
use RainLab\User\Models\User as UserModel;
use RW\PLAdmin\Models\ClientRequest;
use RW\PLAdmin\Models\RWService;
use RW\PLCommon\Models\Comment;
use Auth;
use Flash;
use Input;
Use Validator;
use Redirect;
use ValidationException;
use Http;
use Mail;
use Config;

class PropItem extends ComponentBase
{
    public $pitem;
    public $critem;
    public $user;
    public $item;
    public $client;


    public function componentDetails()
    {
        return [
            'name'        => 'PropItem Component',
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
        ];
    }

    public function onRun(){
        $user = Auth::getUser();
        $this->user = UserModel::find($user->id);
        $f = 0;

        if($this->property('item') > 0 ){
            $listprop = $this->user->client->properties;
            foreach ($listprop as $key => $value) {
                if($value->prop_id == $this->property('item') && $this->property('client') == $this->user->client->id ){
                    $f = $this->property('item');
                }
            }

            if(!empty($this->user->companies)){
                foreach ($this->user->companies as $c => $cval) {
                    if($this->property('client') == $cval->client->id ){
                        if(!empty($cval->client->properties) && count($cval->client->properties) > 0){
                            foreach ($cval->client->properties as $key => $value) {
                                if($value->prop_id == $this->property('item')  ){
                                    $f = $this->property('item');
                                }
                            }
                        }
                    }
                }
            }
        }


        if($f > 0){
            $this->pitem = PropertyModule::find($f);
            $this->critem = ClientRequest::where("client_id",$this->property('client'))->where("prop_id",$f)->get();

            $this->page->title =$this->pitem->searchtext." | REF# ".$this->property('client')."-".$this->property('item');

            $this->item = $this->property('item');
            $this->client = $this->property('client');
        }

         $this->loadAssets();

    }

      public function loadAssets()
    {


        $this->addJs('assets/js/formfilter.js', 'rw.prop');

    }

    public function loadServices(){
        return [1=>'Value or category of the property',2=>'Property rates account',3=>'Other' ];
    }

    public function onSaveRequests(){
        $validator = Validator::make(
            [
                'query_id' =>  Input::get('query_id')
            ],
            [
                'query_id' => 'required'
            ]
        );


        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        #$s = RWService::find(Input::get('service__id'));

        // if(empty($s)){
        //     Flash::error("Invalid service ...");
        //     return Redirect::refresh();
        // }


        $user = Auth::getUser();
        $this->user = UserModel::find($user->id);
        $f = 0;

        if($this->property('item') > 0 ){
            $listprop = $this->user->client->properties;
            foreach ($listprop as $key => $value) {
                if($value->prop_id = $this->property('item')){
                    $f = $this->property('item');
                }
            }

            if($f > 0){
                $cr = new ClientRequest();
                $cr->client_id = $this->property('client');
                $cr->prop_id = $this->property('item');
                $cr->query_id = Input::get('query_id');

                if(Input::has('is_queried'))
                    $cr->is_queried = Input::get('is_queried');

                if(Input::has('problem_description'))
                    $cr->problem_description = Input::get('problem_description');

                if(Input::has('query_type'))
                    $cr->query_type = Input::get('query_type');

                if(Input::has('doc_submitted_municipality'))
                    $cr->doc_submitted_municipality = Input::file('doc_submitted_municipality');

                if(Input::has('latest_municipal_rates_account'))
                    $cr->latest_municipal_rates_account = Input::file('latest_municipal_rates_account');

                if(Input::has('email_correspondence'))
                    $cr->email_correspondence = Input::file('email_correspondence');



                $cr->save();

                Flash::success("Request was sent successfully...");
                return Redirect::refresh();
            }
        }

    }

    public function onSaveComment(){

        $user = Auth::getUser();
        $this->user = UserModel::find($user->id);

        $cr = ClientRequest::
            where("id",Input::get('cr_id'))->
            where("user__id",$user->id)
            ->first();

        $c = new Comment();
        $c->body = Input::get('usercomment');
        $c->user_created_by = $user->id;
        $c->commentable  = $cr;
        $c->save();


        Flash::success("Request was sent successfully...");
    }

    public function onCheckUserTaken()
        {

            return ['isTaken' => (post('query_id')) ? 1 : 0];
        }

}
