<?php namespace Bt\Sheq\Components;

use Bt\Maintenance\Controllers\Tools;
use Bt\Sheq\Models\EmployeeQuestionnaire;
use Bt\Sheq\Models\EmployeeQuetionnaireAnswer;
use Bt\Sheq\Models\QuestionElement;
use Bt\Sheq\Models\Questionnaire;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Input;
/**
 * Test Component
 */
class Test extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'test Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){

        $mydepartment = \Request::segment(3);
        $mytest = \Request::segment(2);
        if(isset($_SESSION['mydep']))
        {
            if($_SESSION['mydep'] != $mydepartment){
                return \Redirect::to('/training');
            }
        }else{
            return \Redirect::to('/training');
        }
        $obj = EmployeeQuestionnaire::find($mydepartment);

        if(!empty($obj)){
            if(isset($obj->end_date)){
                return \Redirect::to('/training/'. $mytest .'/'. $mydepartment . '/finish' );
            }
            $this->page['name'] = $obj->name;
            $this->page['surname'] = $obj->surname;
            $this->page['test'] = $this->getMyQuestions();

            $this->page['obj'] = $obj;
            $this->page->meta_title = $obj->questionnaire->name;
            $this->page->meta_description = "Being completed by: ".$obj->name." ".$obj->surname;;
        }else{
            $this->page->meta_title = "Unauthorized";
            $this->page->meta_description = "Please contact BT for help";
        }

    }

    public function getMyQuestions(){
        $myquestions_id = \Request::segment(2);
        $mydepartment = \Request::segment(3);
        $currenEmp = EmployeeQuestionnaire::find($mydepartment);
        $questionelement = Questionnaire::find($myquestions_id);
        $holdform = array();
        if(isset($questionelement->id)){
            foreach ($questionelement->questions as $qform){
                if(empty($currenEmp))
                    $holdform[$qform->name] = $qform->getFieldHtmlCode();
                else
                    $holdform[$qform->name] = $qform->getFieldHtmlCodeAnswer($this->getAnser($mydepartment));

            }
            return $holdform;
        }
        else{
            return 'This training session does not exist';
        }
    }

    public function onSaveQuestions(){
        $mydepartment = \Request::segment(3);
            $currenEmp = EmployeeQuestionnaire::find($mydepartment);
            if(!empty($currenEmp)){
                if(isset($currenEmp->questionnaire->questions)){

                    foreach ($currenEmp->questionnaire->questions as $questions){
                        foreach($questions->questions as $q)
                        {
                            $qid = "qid_".$q['question'];
                            $myquestion = EmployeeQuetionnaireAnswer::where('question_id', $q['question'])->where('employee_id', $mydepartment)->first();
                            if(empty($myquestion)){
                                if(!empty(\Input::get($qid))){
                                    $mypick = \Input::get($qid);
                                    $s =  new EmployeeQuetionnaireAnswer();
                                    $s->employee_id = $mydepartment;
                                    $s->answer = $mypick[0];
                                    $s->question_id = $q['question'];
                                    $s->save();
                                }
                            }else{
                                if(!isset($currenEmp->end_date)){
                                    if(!empty(\Input::get($qid))){
                                        $mypick = \Input::get($qid);
                                        $s = EmployeeQuetionnaireAnswer::where('question_id', $q['question'])->where('employee_id', $mydepartment)->first();
                                        $s->employee_id = $mydepartment;
                                        $s->answer = $mypick[0];
                                        $s->question_id = $q['question'];
                                        $s->save();
                                    }
                                }

                            }

                        }

                    }
                    if(Input::get('isredirect') == 1){
                        $currenEmp->end_date = Carbon::now();
                        $currenEmp->save();
                        $url = \Request::url() . '/' . 'finish';
                        return \Redirect::to($url);
                    }

                }
            }
    }
    function getAnser($id){
        return \Bt\Sheq\Models\EmployeeQuetionnaireAnswer::
        where("employee_id",$id)->
        get();
    }
}
