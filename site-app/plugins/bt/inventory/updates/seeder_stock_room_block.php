<?php namespace Bt\Inventory\Updates;

use Lang;
use Seeder;
use Bt\Inventory\Models\StockRoomBlock;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederStockRoomBlock extends Seeder
{
    public function run()
    {
        $arStatusList = array();
       

        for ($i=1; $i < 26; $i++) { 
        foreach (range('A', 'Z') as $column){
               
        $arStatusList[] = array('zone_row'=> $i,'zone_column_number'=> $column,'zone_stack_height'=> 3);

               
        }

        }

        foreach ($arStatusList as $arStatusData) {
        StockRoomBlock::create($arStatusData);
        }
    }
}