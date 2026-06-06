<?php namespace Bt\HR\Updates;

use Lang;
use Seeder;
use  Bt\HR\Models\Leavetype;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederLeaveType extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [

        'name' => 'Leave'
        ], [
        'name' => 'Sick Leave'
        ], [
        'name' => 'Absence'
        ], [
        'name' => 'Suspended'
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        Leavetype::create($arStatusData);
        }
    }
}
