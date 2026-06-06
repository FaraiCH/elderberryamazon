<?php

namespace Bt\PLCommon\Classes;
use Bt\Sheq\Models\Question;

class DynamicForm {

    public $answers;
    public $questions;
    public $header;
   
    public function __construct($questions,$answers = null,$header = null) {
        $this->answers = $answers;
        $this->questions = $questions;
        $this->header = $header;
       
    }

    public function getRaw(){
    	$output = [];
    	$output[] = '
            <div class="qheader">
                <h3>'.$this->header.'</h3>
            </div>
        ';
        
        $output[] = '<div class="row">';
        
        foreach ($this->questions as $key => $value) {

            $fieldSettings =  Question::find($value["question"])->toArray();

            $qid = "qid_".$fieldSettings["id"];   
            $name = ' name="'.$qid.'" ';

            $css =  ($value["cssgrid"])? $value["cssgrid"] : "col-sm-12";

            $output[] = '<div class="printpdfrow '. $css.'">
                <div class="form-group row">';
                
                if(!$fieldSettings['swaplabel']){
                    $this->createLabel($value,$fieldSettings,$qid,$output);
                }

                $wrapper_css = $fieldSettings["wrapper_css"]?$fieldSettings["wrapper_css"]:'col-sm-8';

                if( !empty($fieldSettings['type']) && $fieldSettings['type'] == 'text'){
                    $output[] = '<div class="'.$wrapper_css.'"><input '.$name.' placeholder="'.$fieldSettings['placeholder'].'" value="'.$this->getvalue($fieldSettings).'" type="text" class="form-control  form-input-text"  /></div>';
                }


                if( !empty($fieldSettings['type']) && $fieldSettings['type'] == 'file'){
                    $d = $this->getfilename($fieldSettings);
                    $a = "";
                    if(!empty($d)){
                            $a = '<a class="btn btn-primary form-input-file-a" target="_blank" href="'.$this->getfile($fieldSettings).'"><i class="fa fa-file"></i> '.$d.'</a>';
                    }
                    $output[] = '<div class="'.$wrapper_css.'">'.$a.'<input '.$name.' placeholder="'.$fieldSettings['placeholder'].'" type="file" class="form-control form-input-file "  /></div>';
                }


                if( !empty($fieldSettings['type']) && $fieldSettings['type'] == 'textarea'){
                    $output[] = '<div class="'.$wrapper_css.'"><textarea '.$name.'  placeholder="'.$fieldSettings['placeholder'].'"   class="form-control form-input-textarea">'.$this->getvalue($fieldSettings).'</textarea></div>';
                }

                // For dropdown add options
                if( $fieldSettings['type'] == 'dropdown' && count($fieldSettings['field_values']) ) {
                    #$list = explode(',', $this->getvalue($fieldSettings));

                    $output[] = '<div class="'.$wrapper_css.'"><div><select '.$name.'  class="form-control form-input-select "  >';
                    $valuesCounter = 1;
                    $output[] = "<option value=''>--- Select ---</option>";
                     $hid = "";
                    foreach($fieldSettings['field_values'] as $fieldValue) {

                        if( !empty($this->postData[$fieldSettings['name']]['value']) && $this->postData[$fieldSettings['name']]['value'] == $fieldValue['field_value_id'] ){
                        $optionAttribute = 'selected';
                        } else {
                        $optionAttribute = null;
                        }

                        if ($fieldValue['field_value_id'] == $this->getvalue($fieldSettings) ) {
                            $optionAttribute = 'selected';
                              $hid = $fieldValue['field_value_id'];
                        }

                        $output[] = "<option $optionAttribute value='" . $fieldValue['field_value_id'] . "'>" . $fieldValue['field_value_content'] . "</option>";

                        $valuesCounter++;

                    }
                    $output[] = '</select></div>';
                     $output[] = '<div class="hidinput form-control  form-input-text">'.$hid.'</div>';
                    $output[] = "</div>";
                }

                // For dropdown add options
                if( $fieldSettings['type'] == 'checkbox' && count($fieldSettings['field_values']) ) {
                    $listanswer = explode(',', $this->getvalue($fieldSettings));
                    $name = ' name="'.$qid.'[]" ';
                    $output[] = '<div class="'.$wrapper_css.'"><div class="checkpdf">';
                    $valuesCounter = 1;
                   

                    foreach($fieldSettings['field_values'] as $fieldValue) {

                        if( !empty($this->postData[$fieldSettings['name']]['value']) && $this->postData[$fieldSettings['name']]['value'] == $fieldValue['field_value_id'] ){
                        $optionAttribute = 'selected';
                        } else {
                        $optionAttribute = null;
                        }


                        if ( in_array($fieldValue['field_value_id'], $listanswer)  ) {
                            $optionAttribute = 'checked';
                          
                        }

                        $output[] = "<div class='form-check form-input-checkpdf checkpdf-v-".$valuesCounter."'><input class='form-check-input' $name type='checkbox' $optionAttribute value='" . $fieldValue['field_value_id'] . "'><label class='form-check-label'>" . $fieldValue['field_value_content'].'</label></div>';

                        $valuesCounter++;


                    }




                    $output[] = "</div></div>";
                }

                // For dropdown add options
                if( $fieldSettings['type'] == 'radio' && count($fieldSettings['field_values']) ) {
                     $name = ' name="'.$qid.'[]" ';
                    $output[] = '<div class="'.$wrapper_css.'"><div class="checkpdf">';
                    $valuesCounter = 1;

                    foreach($fieldSettings['field_values'] as $fieldValue) {

                        if( !empty($this->postData[$fieldSettings['name']]['value']) && $this->postData[$fieldSettings['name']]['value'] == $fieldValue['field_value_id'] ){
                        $optionAttribute = 'selected';
                        } else {
                        $optionAttribute = null;
                        }

                        if ($fieldValue['field_value_id'] == $this->getvalue($fieldSettings) ) {
                            $optionAttribute = 'checked';
                        }

                        

                        $output[] = "<div class='form-check form-input-checkpdf'><input class='form-check-input' $name type='radio' $optionAttribute value='" . $fieldValue['field_value_id'] . "'><label class='form-check-label'>" . $fieldValue['field_value_content'].'</label></div>';

                        $valuesCounter++;

                    }

                    $output[] = "</div></div>";
                }

                if( $fieldSettings['type'] == 'table' && count($fieldSettings['field_values']) ) {

                    $listanswer = $this->getvalue($fieldSettings);
                    $jlist = json_decode($listanswer, true);
                    $output[] = '<div class="col-sm-12"><table class="table smtable">';
                    $valuesCounter = 1;
                    $output[] = '<thead><tr><th>#</th>';
                    foreach($fieldSettings['field_values'] as $fieldValue) {
                        $output[] = "<th>" . $fieldValue['field_value_content'] . "</th>";
                    }

                    $output[] = '</tr></thead><tbody>';
                    for ($i=0; $i <10 ; $i++) { 
                        $output[] = '<tr><td>'.($i+1).'</td>';
                        foreach($fieldSettings['field_values'] as $fieldValue) {
                            $vl = "";
                            if(isset($jlist[$i]) && isset($jlist[$i][$fieldValue['field_value_id'] ]) )
                                $vl =  $jlist[$i][$fieldValue['field_value_id'] ];    
                            $name = ' name="'.$qid.'['.$i.']['. $fieldValue['field_value_id'] .']"';
                            $output[] = "<td><input  class='form-control form-input-small' $name type='text' value='$vl' /></td>";
                        }
                        $output[] = '</tr>';
                    }
                    $output[] = '</tbody>';
                    $output[] = "</table></div>";
                }

                if($fieldSettings['swaplabel']){
                    $this->createLabel($value,$fieldSettings,$qid,$output);
                }
            $output[] = "</div>";
            $output[] = "</div>";            
        }

    	$output[] = "</div>";
    	return(implode('', $output));
    }

    public function inputname($name){
        return "name='$name'";
    }

    public function createLabel($value,$fieldSettings,$qid,&$output){
        if( !empty($fieldSettings['label'])){

            $labelclass = $fieldSettings["label_css"]?$fieldSettings["label_css"]:'col-sm-4';
            
            $output[] = '<label class="'.$labelclass.' col-form-label label-type-'.$fieldSettings['type'] .'" ><span>'.($value["newlabel"]?$value["newlabel"]:$fieldSettings['label']). '</span></label>';
        }
    }

    public function getvalue($obj){
        // trace_log($obj);
        if(isset($this->answers) && !empty($this->answers))
        foreach ($this->answers as $key => $value) {
            if($value->question_id == $obj["id"]){
                return $value->answer;
            }
            // code...
        }

        return null;
    }
  public function getfile($obj){
        // trace_log($obj);
        if(isset($this->answers) && !empty($this->answers))
        foreach ($this->answers as $key => $value) {
            if($value->question_id == $obj["id"] && $value->qfile){
                return $value->qfile->path;
            }
            // code...
        }

        return null;
    }

public function getfilename($obj){
        // trace_log($obj);
        if(isset($this->answers) && !empty($this->answers))
        foreach ($this->answers as $key => $value) {
            if($value->question_id == $obj["id"] && $value->qfile){
                return $value->qfile->file_name;
            }
            // code...
        }

        return null;
    }

   
}

?>