<?php namespace Bt\Hr\Components;

use Cms\Classes\ComponentBase;
use Bt\HR\Models\Employee;
use Carbon\Carbon;

/**
 * Birthday Component
 */
class Birthday extends ComponentBase
{
    public $birthdays;
    public function componentDetails()
    {
        return [
            'name' => 'birthday Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->birthdays = Employee::whereRaw('DAYOFYEAR(dob) = DAYOFYEAR(NOW())')->where('is_user_active', 1)
            ->get();
    }
    public function loadAssets(){
        $this->addCss('/plugins/bt/boardroom/assets/css/card.css');
    }
}
