<?php namespace Bt\Floor\Components;

use Cms\Classes\ComponentBase;
use Bt\Floor\Models\DeliveryScrapPipe as DeliveryScrapPipeModel;

class CmDeliveryScrapPipe extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CmDeliveryScrapPipe Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function loadList(){
        return DeliveryScrapPipeModel::orderby('schedule_date','Desc')->get();
    }
}
