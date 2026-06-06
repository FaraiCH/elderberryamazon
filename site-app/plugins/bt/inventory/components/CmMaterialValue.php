<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\Purchase as PurchaseModel;
class CmMaterialValue extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CmMaterialValue Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
     public function loadList(){
        return PurchaseModel::orderby('date_of_puchase','Desc')->get();
    }
}
