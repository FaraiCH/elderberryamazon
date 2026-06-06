<?php namespace Bt\HR\Updates;

use Lang;
use Seeder;
use  Bt\HR\Models\LeaveStatus;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederLeaveStatus extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Requested'
        ], [
        'name' => 'Approved'
        ], [
        'name' => 'Denied'
        ], [
        'name' => 'Canceled'
        ], [
        'name' => 'Completed'
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        LeaveStatus::create($arStatusData);
        }
    }
}