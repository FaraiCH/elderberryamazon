<?php

namespace Bt\Sales\Classes;

class SalesPrice
{
    public static function upFrontDiscount($model, $discountRate) : float
    {
        $cashUpfrontDiscount = 0;
        if(!empty($model))
        {
            $totalWeightPipePrice = 0; $totalWeightCataloguePrice = 0; $deliveryCost = 0; $discount = 0;
            if($model->items)
            {
                $totalWeightPipePrice = $model->items->sum('totalweight') * $discountRate;
            }
            if($model->itemscat)
            {
                $totalWeightCataloguePrice += $model->itemscat->sum("price");
            }
            if($model->responses)
            {
                foreach ($model->responses as $item)
                {
                    $discount += $item->amountdiscount;
                }
            }
            if($model->dispatch)
            {
                $deliveryCost = $model->dispatch->sum('total');
            }
            $vat = ($totalWeightPipePrice + $totalWeightCataloguePrice + $deliveryCost) * $model->vat;
            $cashUpfrontDiscount = ($totalWeightPipePrice + $totalWeightCataloguePrice + $deliveryCost + $vat) - $discount;
        }
        self::saveCashUpfront($model, $discountRate, $cashUpfrontDiscount);
        return $cashUpfrontDiscount ;
    }

    private static function saveCashUpfront($model, $cashRate, $cashUpfront)
    {
        $model->cash_rate = $cashRate;

        $model->upfront_cash_payment = $cashUpfront;

        $model->save();
    }
}
