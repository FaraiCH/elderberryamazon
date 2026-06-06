<?php namespace Bt\Production\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Push as PushModel;
use Bt\Production\Models\Schedule as ScheduleModel;

class Menu extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Menu Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    

    // public function onRun(){
    //     dd($this->getItems());
    // }

    public function getItems(){
        return null;#PushModel::Where('status_id',2)->get();
    }

}
