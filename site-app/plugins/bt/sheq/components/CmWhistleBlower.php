<?php namespace Bt\Sheq\Components;

use Cms\Classes\ComponentBase;
use Flash;      
use Auth;
use Input;
use Redirect;
use Bt\Sheq\Models\WhistleBlower as WhistleModel;

/**
 * CmWhistleBlower Component
 */
class CmWhistleBlower extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'CmWhistleBlower Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onRun(){
      // $this->page['whistleblowerSubmitted'] = false;
    }

    public $whistleblowerSubmitted;

    public function onSubmit()
    {
        if (post('formSubmit')) {
            $date = Input::get('date');
            $who = Input::get('who');
            $where = Input::get('where');
            $what = Input::get('what');
            $how = Input::get('how');
            $reported = Input::get('reported');
            
            $whistleBlower = new WhistleModel(); 

            // Set the fields based on form input
            $whistleBlower->date = $date;
            $whistleBlower->who = $who;
            $whistleBlower->where = $where;
            $whistleBlower->what = $what;
            $whistleBlower->how = $how;
            $whistleBlower->witness_doc = \Request::file('witness_doc');
            $whistleBlower->reported = $reported == 'yes' ? true : false;
         
            $whistleBlower->save();

            $this->page['whistleblowerSubmitted'] = true;
           
        }
    }
}
