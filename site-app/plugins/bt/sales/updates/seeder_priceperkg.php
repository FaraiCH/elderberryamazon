<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\PricePerKg;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederPricePerKG extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'amount' => 27.90,
        'active' => 1
            
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        PricePerKg::create($arStatusData);
        }
    }
}