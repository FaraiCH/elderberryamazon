<?php namespace Bt\Sales\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\Diameter;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederDiameter extends Seeder
{
    public function run()
    {
        $arStatusList = array();
        $str = "16,20,25,32,40,50,63,75,90,110,125,140,160,180,200,225,250,280,315,355,400,450,500,560,630,710,800,900,1000";
        $pieces = explode(",", $str);
        foreach ($pieces as $key => $value) {
        $arStatusList[] = array('name'=> $value);
        }


        foreach ($arStatusList as $arStatusData) {
        Diameter::create($arStatusData);
        }
    }
}