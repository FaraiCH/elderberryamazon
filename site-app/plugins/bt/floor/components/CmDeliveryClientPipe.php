<?php namespace Bt\Floor\Components;

use Cms\Classes\ComponentBase;
use Bt\Floor\Models\DeliveryClientPipe as DeliveryClientPipeModel;

class CmDeliveryClientPipe extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CmDeliveryClientPipe Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function loadList(){
        return DeliveryClientPipeModel::orderby('schedule_date','Desc')->get();
    }
}
