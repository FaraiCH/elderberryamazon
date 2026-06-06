<?php namespace Bt\Sheq\Components;

use Bt\Sheq\Models\EmployeeQuestionnaire;
use Bt\Sheq\Models\Questionnaire;
use Bt\Sheq\Models\EmployeeQuetionnaireAnswer;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use RainLab\User\Models\User as UserModel;

use Auth;
use Flash;
use Input;
Use Validator;
use Redirect;
use ValidationException;
use Http;
use Mail;
use Config;

/**
 * QuestionnaireCreate Component
 */
class QuestionnaireCreate extends ComponentBase
{
    public $pitem;
    public $critem;
    public $user;
    public $qobj;
    public $answers;

    public function componentDetails()
    {
        return [
            'name' => 'QuestionnaireCreate Component',
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
        $mydepartment = \Request::segment(2);
        $obj = EmployeeQuestionnaire::where('questionnaire_id', $mydepartment)->first();

        if(isset($obj->questionnaire->name)){
            $this->page['name'] = $obj->questionnaire->name;
        }else{
            $this->page['name'] = null;
        }

        $obj = Questionnaire::find($mydepartment);
        $this->page['obj'] = $obj;
        $this->page->meta_title = $obj->name;
        $this->page->meta_description = "Start training program";

    }

    public function getAnser($catid){
         return ClientQuestionnaireAnswer::
            where("prop_id",$this->property('item'))->
            where("client_id",$this->property('client'))->

            where("category_id",$catid)->

            get();


    }

    public function onSaveClientQuestion(){
        if((!empty(Input::get('name'))) && !empty(Input::get('surname'))){
            $mydepartment = \Request::segment(2);
            $obj = EmployeeQuestionnaire::where('name', Input::get('name'))->where('surname', Input::get('surname'))->where('questionnaire_id', $mydepartment)->orderBy("id", "DESC")->first();

            if(empty($obj) || isset($obj->end_date)){
                $s =  new EmployeeQuestionnaire();
                $s->name = Input::get('name');
                $s->surname = Input::get('surname');
                $s->questionnaire_id = $mydepartment;
                $s->start_date = Carbon::now();
                $s->save();
                $maxcounter =  $s->id;
                $_SESSION['mydep'] = $s->id;
                \Flash::success('Personal Info Successfully Saved...');
                $url = \Request::url() . '/' . $maxcounter;
                return Redirect::to($url);
            }else{
                $url = \Request::url() . '/' . $obj->id;
                $_SESSION['mydep'] = $obj->id;
                return Redirect::to($url);
            }
        }else{
            return \Flash::error("Please input name and surname");
        }

    }
}
