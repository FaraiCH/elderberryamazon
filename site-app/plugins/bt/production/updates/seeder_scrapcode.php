<?php namespace Bt\Production\Updates;

use Lang;
use Seeder;
use Bt\Production\Models\ScrapCodes;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederScrapCode extends Seeder
{
    public function run()
    {
        $arStatusList = [
        ['code' => 'SU','reason' => 'start up'],
        ['code' => 'SD','reason' => 'SHUTDOWN'],
        ['code' => 'PF','reason' => 'POWER FAILURE'],
        ['code' => 'MD ','reason' => 'MECHANICAL BREAKDOWN'],
        ['code' => 'ED','reason' => 'ELECTRICAL BREAKDOWN'],
        ['code' => 'HE','reason' => 'HOPPER EMPTY'],
        ['code' => 'OP','reason' => 'OVALITY PROBLEMS'],
        ['code' => 'WC','reason' => 'WATER CIRCULATION PROBLEMS'],
        ['code' => 'CF','reason' => 'COMPRESSOR FAILURE'],
        ['code' => 'HOB','reason' => 'HAULL OFF BREAKDOWN'],
        ['code' => 'HOS','reason' => 'HAULL OFF SLIPPERING'],
        ['code' => 'VPT','reason' => 'VACCUM PUMP/TANK TRIPPING'],  
        ['code' => 'WPB','reason' => 'WATER PUMP BREAKDOWN'],
        ['code' => 'OD','reason' => 'OD OUT OF SPEC'],
        ['code' => 'WT','reason' => 'WALL THICKNESS UNDERSPEC'],
        ['code' => 'RIP','reason' => 'RIPPLES ON PIPES'],
        ['code' => 'ROP','reason' => 'ROUGHS INSIDE/OUTSIDE PIPES'],
        ['code' => 'POR','reason' => 'POROSITY'],
        ['code' => 'LN','reason' => 'LINES INSIDE/OUTSIDE PIPES'],
        ['code' => 'WM','reason' => 'WATER MARK INSIDE/OUTSIDE PIPES'],
        ['code' => 'BMB','reason' => 'BAD MATERIAL BATCH']
        ];

        foreach ($arStatusList as $arStatusData) {
        ScrapCodes::create($arStatusData);
        }
    }
}