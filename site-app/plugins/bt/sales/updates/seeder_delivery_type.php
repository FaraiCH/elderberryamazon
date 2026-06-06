<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\DeliveryType;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederDeliveryType extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [               
        'name' => 'Delivery From BT'
        ], [
        'name' => 'Collection'            
        ], [
        'name' => 'Other'            
        ]
        ];

        foreach ($arStatusList as $arStatusData) {
        DeliveryType::create($arStatusData);
        }
    }
}