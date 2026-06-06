<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\PNRating;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederPNRatings extends Seeder
{
    public function run()
    {
        $arStatusList = array();
        $str = "PN4,PN5,PN6,PN8,PN10,PN12.5,PN16,PN20,PN25,PN34";
        $pieces = explode(",", $str);
        foreach ($pieces as $key => $value) {
        $arStatusList[] = array('name'=> $value);
        }


        foreach ($arStatusList as $arStatusData) {
        PNRating::create($arStatusData);
        }
    }
}