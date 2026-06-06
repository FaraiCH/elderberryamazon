<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;
use Bt\Sales\Models\Srn as SRNModel;
class CmSrn extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CmSrn Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getList(){
        return SRNModel::all();
    }
}
