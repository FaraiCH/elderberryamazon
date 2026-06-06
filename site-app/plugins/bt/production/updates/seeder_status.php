<?php namespace Bt\Production\Updates;

use Lang;
use Seeder;
use Bt\Production\Models\Status;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederStatus extends Seeder
{
    public function run()
    {
        $arStatusList = [
        [
               
        'name' => 'Requested'
            
        ],[
               
        'name' => 'Started'
            
        ],[
               
        'name' => 'Completed'
            
        ],[
               
        'name' => 'On Hold'
            
        ],
        ];

        foreach ($arStatusList as $arStatusData) {
            
        Status::create($arStatusData);
        }
    }
}