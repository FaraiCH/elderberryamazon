<?php namespace Bt\HR\Components;

use Cms\Classes\ComponentBase;
use Bt\HR\Models\Employee as EmployeeModel;

class CmEmployee extends ComponentBase
{
    public $data;
    public function componentDetails()
    {
        return [
            'name'        => 'CmEmployee Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

     public function onRun(){
        $this->data = EmployeeModel::Tv()->orderBy('id')->get();
     }

}
