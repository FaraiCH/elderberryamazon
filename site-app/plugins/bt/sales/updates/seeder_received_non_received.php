<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\ReceivedNonReceived;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederReceivedNonReceived extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Received Order'
        ], [
        'name' => 'Non Received Order'            
        ]
        ];

        foreach ($arStatusList as $arStatusData) {
        ReceivedNonReceived::create($arStatusData);
        }
    }
}