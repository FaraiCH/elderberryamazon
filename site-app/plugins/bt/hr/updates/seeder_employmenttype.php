<?php namespace Bt\HR\Updates;

use Lang;
use Seeder;
use  Bt\HR\Models\EmploymentType;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederEmploymentType extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Full Time'
        ], [
        'name' => 'Part Time'
        ], [
        'name' => 'Contact'
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        EmploymentType::create($arStatusData);
        }
    }
}