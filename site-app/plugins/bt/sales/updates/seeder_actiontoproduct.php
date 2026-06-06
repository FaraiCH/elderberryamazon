<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\ActionToGroup;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederActionProduct extends Seeder
{
    public function run()
    {
        $arStatusList = array();
        $monster = array();
        $monster[3] = array(2,3,5,6,8,9,15);
        $monster[5] = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15);
        $monster[6] = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15);

        foreach ($monster as $group => $action) {
        foreach ($action as $key => $value) {
        $arStatusList[] = array('user_groups_id'=>$group,'quote_statuses_id'=> $value);
        }
           
        }


        foreach ($arStatusList as $arStatusData) {
        ActionToGroup::create($arStatusData);
        }
    }
}