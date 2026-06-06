<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\StockRelease;

class CmDayToDay extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CmDayToDay Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

     public function loadList(){
        return StockRelease::orderby('datecaptured','asc')->get();
    }
}
