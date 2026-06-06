<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\Unitlength;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederUnitlength extends Seeder
{
    public function run()
    {
        $arStatusList = array();
        $str = "6,12";
        $pieces = explode(",", $str);
        foreach ($pieces as $key => $value) {
        $arStatusList[] = array('value'=> $value);
        }


        foreach ($arStatusList as $arStatusData) {
        Unitlength::create($arStatusData);
        }
    }
}