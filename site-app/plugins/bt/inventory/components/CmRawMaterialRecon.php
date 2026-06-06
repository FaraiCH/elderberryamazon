<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\RawMaterialRecon as RawMaterialReconModel;

class CmRawMaterialRecon extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CmRawMaterialRecon Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
     public function loadList(){
        return RawMaterialReconModel::orderby('datereceived','Desc')->get();
    }
}
