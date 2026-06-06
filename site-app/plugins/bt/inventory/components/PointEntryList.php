<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\PointEntry as ModelPointEntry;

class PointEntryList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'PointEntryList Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function loadPointEntry(){
        return ModelPointEntry::all();
    }
}
