<?php namespace Bt\Maintenance\Updates;

use Lang;
use Seeder;
use Bt\Sales\Models\Diameter as Diameter;
use Bt\Sales\Models\Product as Product;
use Bt\Sales\Models\SrnItem;
use Flynsarmy\CsvSeeder\CsvSeeder;

/**
 * Class SeederDefaultStatus
 * @package Lovata\OrdersShopaholic\Updates
 */
class SeederUpdateSrnItem extends Seeder
{
    public function __construct()
    {
        $this->table = 'your_table';
        $this->sFilePath = 'bt/sales/updates/csv/production_updates.csv';
    }

    public function run()
    {
    }
}

