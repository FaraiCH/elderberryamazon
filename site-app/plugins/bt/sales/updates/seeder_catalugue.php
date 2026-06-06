<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\Catalogue;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederCatalogue extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Compression Fittings',
        'description' => '16 - 110mm ',
        'price' => 2500

        ], [
        'name' => 'Tak Stubs',
        'description' => '90 - 315mm',
        'price' => 500
        ], [
        'name' => 'Victaulic Stubs',
        'description' => '50 - 280mm',
        'price' => 1400
        ], [
        'name' => 'Electrofusion Fittings',
        'description' => '20 - 100mm',
        'price' => 960
        ], [
        'name' => 'Buttweld Fittings',
        'description' => '40 - 1000mm',
        'price' => 780
        ], [
        'name' => 'Stub Flange And Backing Ring',
        'description' => '25 - 1000mm',
        'price' => 1250
        ]
        ];

        foreach ($arStatusList as $arStatusData) {
        Catalogue::create($arStatusData);
        }
    }
}

