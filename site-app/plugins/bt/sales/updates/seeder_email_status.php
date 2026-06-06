<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\EmailStatus;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederEmailStatus extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Sent'
        ], [
        'name' => 'Fail'
        ], [
        'name' => 'Bounced'
        ], [
        'name' => 'Sent Manual'
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
        EmailStatus::create($arStatusData);
        }
    }
}