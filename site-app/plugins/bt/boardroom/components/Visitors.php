<?php namespace Bt\Boardroom\Components;

use Bt\Boardroom\Models\Visitor;
use Bt\HR\Models\Employee;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;

/**
 * Visitors Component
 */
class Visitors extends ComponentBase
{
    public $visits;
    public $birthdays;
    public function componentDetails()
    {
        return [
            'name' => 'visitors Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->visits = Visitor::whereDate('date', Carbon::today())->get();
        // $this->birthdays = Employee::whereRaw('DAYOFYEAR(dob) = DAYOFYEAR(NOW())')->where('is_user_active', 1)
        //     ->get();
    }
    public function loadAssets(){
        $this->addCss('/plugins/bt/boardroom/assets/css/card.css');
    }
}
