<?php namespace Bt\Inventory\Updates;

use Lang;
use Seeder;
use Bt\Inventory\Models\PartNames;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederPartNames extends Seeder
{
    public function run()
    {
    $arStatusList = [
    [               
    'name' => 'SCG'
    ], [
    'name' => 'PEBO'
    ], [
    'name' => 'PEBO 70'
    ], [
    'name' => 'PEBO 100'
    ], [
    'name' => 'BT - Regrind'
    ], [
    'name' => 'SAFRIPOL'
    ], [
    'name' => 'Drying Agent'
    ], [
    'name' => 'Other'
    ]
    ];

    foreach ($arStatusList as $arStatusData) {
    PartNames::create($arStatusData);
    }
    }
}