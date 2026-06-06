<?php namespace Bt\Inventory\Updates;

use Lang;
use Seeder;
use  Bt\Inventory\Models\InventoryType;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederInventoryType extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Virgin'
        ], [
        'name' => 'Regrind'
        ], [
        'name' => 'Wide spec'
        ], [
        'name' => 'Other'
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        InventoryType::create($arStatusData);
        }
    }
}