<?php namespace Bt\Sheq\Components;

use Bt\Sheq\Models\QuestionElement;
use Bt\Sheq\Models\Questionnaire;
use Cms\Classes\ComponentBase;

/**
 * Cmquestions Component
 */
class Cmquestions extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'cmquestions Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {

        return [];
    }

    public function onRun()
    {
        $questionnaire = Questionnaire::where('active', 1)->orderBy('sort_order', 'ASC')->get();
        $this->page['questionnaire'] = $questionnaire;
    }


}
