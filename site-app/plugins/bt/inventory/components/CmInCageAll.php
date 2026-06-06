<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\CageMaterial as CageMaterialModel;

class CmInCageAll extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CmInCageAll Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function loadList(){
        return CageMaterialModel::orderby('datecaptured','asc')->get();
    }

}
