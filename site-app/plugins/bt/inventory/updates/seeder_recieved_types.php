<?php namespace Bt\Inventory\Updates;

use Lang;
use Seeder;
use Bt\Inventory\Models\RecievedType;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederRecievedType extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Pallet - 1 Ton',
        'bags' => 40
        ], [
        'name' => 'Pallet - 1.5 Ton',
        'bags' => 60
        ], [
        'name' => 'Other',
        'bags' => 0
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        RecievedType::create($arStatusData);
        }
    }
}