<?php namespace Bt\JSEData\Updates;

use Lang;
use Seeder;

use Bt\JSEData\Models\Company;
use Bt\JSEData\Models\Property as PropertyModel;
use Bt\JSEData\Models\ShareData;
use Bt\JSEData\Models\ShareDataAVG;
use Carbon\Carbon;
use DB;

class UpdatesFA extends Seeder
{
    public function __construct()
    {
    }

    public function run()
    {
    }

    private function setTODate($value,$format = 'j F Y'){
         try {
                return \Carbon\Carbon::createFromFormat($format, $value);
                 } catch (\ErrorException $e) {
                    return null;
                 }
    }
}
