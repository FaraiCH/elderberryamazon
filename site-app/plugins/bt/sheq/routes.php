<?php

use Bt\Sheq\Models\EmployeeQuestionnaire;
use Bt\Sheq\Models\EmployeeQuetionnaireAnswer;
use Bt\Sheq\Models\Question;

Route::any('/preview/qa/{id}.pdf', function ($id) {

    if($id > 0){
        $mytest = $id;
        $currenEmp = EmployeeQuestionnaire::find($mytest);
        $percentage = 0;
        $q_obj = array();
        $number_of_questions = 0;
        $right = 0;
        $wrong = 0;
        if(!empty($currenEmp)){
            if(isset($currenEmp->questionnaire->questions)){
                foreach ($currenEmp->questionnaire->questions as $questions){
                    foreach($questions->questions as $q)
                    {
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
            return \Renatio\DynamicPDF\Classes\PDF::loadTemplate('questionnaire-answer',array('obj'=> $currenEmp,'questionobj'=> $q_obj,'perc'=> number_format($percentage, 2) ))
                ->setDefaultFont('sans-serif')
                ->stream();
        }else{
            echo "invlid file";
        }
    }

});

function getAnser($id){
    return \Bt\Sheq\Models\EmployeeQuetionnaireAnswer::
    where("employee_id",$id)->
    get();
}

function cheifprinted( $obj, $id){
    $obj[$id] = $id;
    return $obj;
}
