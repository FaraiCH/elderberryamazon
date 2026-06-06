<?php namespace Bt\Production\Updates;

use Lang;
use Seeder;
use Bt\Production\Models\Line;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederLine extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'BT 315-630 1',
        'name' => 'BT 250-630 2'
            
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
            
        Line::create($arStatusData);
        }
    }
}