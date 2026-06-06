<?php namespace Bt\HR\Updates;

use Lang;
use Seeder;
use  Bt\HR\Models\Designation;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederDesignation extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Top Management'
        ], [
        'name' => 'Senior Management'
        ], [
        'name' => 'Professionaly Qualified'
        ], [
        'name' => 'Skilled Technical'
        ], [
        'name' => 'Semi-skilled'
        ], [
        'name' => 'Unskilled'
        ], [
        'name' => 'Unknown'
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        Designation::create($arStatusData);
        }
    }
}