<?php namespace Bt\Inventory\Updates;

use Lang;
use Seeder;
use Bt\Inventory\Models\EntryType;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederEntryType extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Truck'
        ], [
        'name' => 'Container'
        ], [
        'name' => 'Other'
        ]
        ];

        foreach ($arStatusList as $arStatusData) {
        EntryType::create($arStatusData);
        }
    }
}