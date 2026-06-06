<?php namespace Bt\Maintenance\Components;

use Cms\Classes\ComponentBase;
use Bt\Maintenance\Models\StoreProductItem as ModelStoreProduct;

/**
 * CmpStoreStickerHome Component
 */
class CmpStoreStickerHome extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'CmpStoreStickerHome Component',
            'description' => 'No description provided yet...'
        ];
    }

    public $item = "";
    public $appurl = "";
    public $sticker;
    public function defineProperties()
    {
        return [
            'item' => [
                'title'       => 'Property item',
                'description' => 'Slug for business item',
                'default'     => '{{ :item }}',
                'type'        => 'string'
            ],
        ];
    }

    public function onRun()
    {
        $item = $this->property('item');
        
        $this->sticker = ModelStoreProduct::where('id', $item)->get();
        $this->appurl =  \Config::get('app.url');
    }
}
