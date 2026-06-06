<?php

namespace Bt\Sales\Updates;

use Bt\Sales\Models\Catalogue;
use Bt\Sales\Models\QuoteItemCatalogue;
use Seeder;

class UpdateQuoteItemCatalogue extends Seeder
{
    public function run()
    {
        $quoteItemCatalogues = QuoteItemCatalogue::all();

        foreach ($quoteItemCatalogues as $quoteItemCatalogue)
        {
            $catalogue = Catalogue::where('id', $quoteItemCatalogue->product_id)->where('bt_product_id', '!=', null)->first();
            if(isset($catalogue->bt_product_id))
            {
                $quoteItemCatalogue->btproduct_id = $catalogue->bt_product_id;
            }
            if(isset($catalogue->priceperkg))
            {
                $quoteItemCatalogue->priceperkg = $catalogue->priceperkg;
            }
            if(isset($catalogue->bt_unitlength))
            {
                $quoteItemCatalogue->unitlength = $catalogue->bt_unitlength;
            }
            $quoteItemCatalogue->save();
        }
    }
}
