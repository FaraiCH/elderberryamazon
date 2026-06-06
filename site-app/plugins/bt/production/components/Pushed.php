<?php namespace Bt\Production\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Push as PushModel;

class Pushed extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Pushed Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
         //dd(PushModel::all());
    }

      public function loadPushItems(){       
        return PushModel::all();
      }
}
