<?php namespace Bt\HR\Updates;

use Lang;
use Seeder;
use  Bt\HR\Models\TrainingType;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederTraininng extends Seeder
{
    public function run()
    {
        $arStatusList = [
            [

                'name' => 'Training 1'
            ], [
                'name' => 'Training 2'
            ], [
                'name' => 'Training 3'
            ],
        ];

        foreach ($arStatusList as $arStatusData) {
            TrainingType::create($arStatusData);
        }
    }
}
