<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;
use Bt\Sales\Models\Catalogue as CatalogueModel;

class CmCatalogue extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CmCatalogue Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function loadList(){
        return CatalogueModel::all();
    }
}
