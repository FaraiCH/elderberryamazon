<?php

namespace Bt\Reporting\Models;

use Backend\Models\ExportModel;

class ExportDailyElectricityProduction extends ExportModel
{
    public $table = 'view_electricity_production';

    public function exportData($columns, $sessionKey = null)
    {
        // $query = self::make();
        // return $query->get()->toArray();

        $startdate = null;
        $enddate = null;
        $query = self::make();
        if (isset($_SESSION['starter'])) {
            $startdate = $_SESSION['starter'];
            $enddate = $_SESSION['ender'];
            return $query->whereBetween('production_date', array($startdate, $enddate))->orderBy('week_id', 'desc')->get()->toArray();
        } else {
            return $query->orderBy('week_id', 'desc')->get()->toArray();
        }

    }


}
