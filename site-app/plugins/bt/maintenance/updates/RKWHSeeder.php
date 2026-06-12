<?php namespace Bt\Maintenance\Updates;

use Bt\Maintenance\Models\Electricity;
use Bt\Maintenance\Models\Tarrif;
use Carbon\Carbon;
use Seeder;

class RKWHSeeder extends Seeder
{
    public function __construct()
    {

    }
    public function run()
    {

        // Find Monthly Tarrif
        $tariffs = Tarrif::all();

        // Validate
        if(!empty($tariffs)){
            // Update Blended R/KWH on Electricity Readings
            foreach ($tariffs as $tarrif){
                $electricity_imports = Electricity::whereBetween('rdate', [$tarrif->start_date, $tarrif->end_date])->get();
                if(!empty($electricity_imports)){
                    foreach ($electricity_imports as $electricity_import){
                        $electricity_import->blended_rkwh = $tarrif->rand_per_kwh * $electricity_import->kwh;
                        $electricity_import->save();
                    }
                }
            }

        }


    }

}
