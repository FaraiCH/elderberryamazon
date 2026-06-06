<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\Stock as ModelStock;
use Bt\Inventory\Models\StockOut as ModelStockOut;

class OutStockList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'OutStockList Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function loadStockList(){
        return ModelStock::where("instock",0)->get();
    }
}
