<?php namespace Bt\Floor\Components;

use Cms\Classes\ComponentBase;
use Bt\Floor\Models\Stockpipe as StockpipeModel;
class FloorPipes extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'FloorPipes Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getList(){
        return StockpipeModel::all();
    }
}
