<?php namespace Bt\HR\Updates;

use Lang;
use Seeder;
use  Bt\HR\Models\IncidentStatus;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederIncidentStatus extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'New Request'
        ], [
        'name' => 'Work In Progress'
        ], [
        'name' => 'Void'
        ], [
        'name' => 'On Hold'
        ], [
        'name' => 'Waiting More Information'
        ], [
        'name' => 'Escalated'
        ], [
        'name' => 'Resolved'
        ], [
        'name' => 'Closed'
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        IncidentStatus::create($arStatusData);
        }
    }
}