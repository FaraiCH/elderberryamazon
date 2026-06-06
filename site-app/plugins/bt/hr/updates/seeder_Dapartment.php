<?php namespace Bt\HR\Updates;

use Lang;
use Seeder;
use  Bt\HR\Models\Department;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederDepartment extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Sales'
        ], [
        'name' => 'Production'
        ], [
        'name' => 'Finance'
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        Department::create($arStatusData);
        }
    }
}