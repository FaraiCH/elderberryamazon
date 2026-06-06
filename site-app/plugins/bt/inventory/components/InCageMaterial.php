<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\CageMaterial as CageMaterialModel;

class InCageMaterial extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'InCageMaterial Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function loadList(){
        return CageMaterialModel::orderby('datecaptured','Desc')->get();
    }
}
