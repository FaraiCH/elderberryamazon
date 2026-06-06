<?php namespace Bt\Sheq\Components;

use Bt\Sheq\Models\EmployeeQuestionnaire;
use Bt\Sheq\Models\EmployeeQuetionnaireAnswer;
use Bt\Sheq\Models\Question;
use Bt\Sheq\Models\Questionnaire;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;

/**
 * Cmanswers Component
 */
class Cmanswers extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'cmanswers Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){

        $mytest = \Request::segment(3);
        $myquestionnaire = \Request::segment(2);
        $currenEmp = EmployeeQuestionnaire::find($mytest);
         $this->page['obj'] = $currenEmp;
        $this->page->meta_title = "Results:".$currenEmp->questionnaire->name;
        $this->page->meta_description = "Completed By: ".$currenEmp->name." ".$currenEmp->surname;;

        $percentage = 0;
        $q_obj = array();
        $number_of_questions = 0;
        $right = 0;
        $wrong = 0;
        if(isset($_SESSION['mydep']))
        {
            if($_SESSION['mydep'] != $mytest){
                return \Redirect::to('/training');
            }
        }else{
            return \Redirect::to('/training');
        }
        if(!empty($currenEmp)){

            if(isset($currenEmp->questionnaire->questions)){
                foreach ($currenEmp->questionnaire->questions as $questions){
                    foreach($questions->questions as $q)
                    {
                        $qid = "qid_".$q['question'];
                        $myquestion = EmployeeQuetionnaireAnswer::where('question_id', $q['question'])->where('employee_id', $mytest)->first();
                        if(!empty($myquestion)){
                            $oldQuestion = Question::find($q['question']);
                            $mypick = (int) filter_var($myquestion->answer, FILTER_SANITIZE_NUMBER_INT);
                            $q_obj[$questions->name]['fields'][] = $oldQuestion->field_values;
                            $q_obj[$questions->name]['label'][] = $oldQuestion->label;
                            $q_obj[$questions->name]['name'] = $questions->name;
                            if(isset($oldQuestion->field_values)){
                                foreach ($oldQuestion->field_values as $val){
                                    if($val['field_value_id'] == $myquestion->answer){
                                        $q_obj[$questions->name]['youranswer'][] = $val['field_value_content'];
                                    }
                                    $q_questions = (int) filter_var($val['field_value_id'], FILTER_SANITIZE_NUMBER_INT);

                                    if($q_questions == $oldQuestion->answer){
                                        $q_obj[$questions->name]['realanswer'][] = $val['field_value_content'];
                                    }
                                }
                            }
                            if($mypick == $oldQuestion->answer){
                                $right++;
                            }else{
                                $wrong++;
                            }
                            $number_of_questions++;
                        }


                    }

                }

            }

            $percentage = ($right/$number_of_questions) * 100;

            $this->page['percentage'] = number_format($percentage, 2);
        }
        $this->page['questionobj'] = $q_obj;
    }

    public function onSaveQuestions(){

    }
}
