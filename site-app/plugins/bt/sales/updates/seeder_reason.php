<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\ReasonForQuote;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederReasonForQuote extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Day To Day'
        ], [
        'name' => 'Sales Campaign'            
        ], [
        'name' => 'Existing Client'
        ], [
        'name' => 'Tender'
        ], [
        'name' => 'Redo'
        ], [
        'name' => 'Other'
        ]
        ];

        foreach ($arStatusList as $arStatusData) {
        ReasonForQuote::create($arStatusData);
        }
    }
}