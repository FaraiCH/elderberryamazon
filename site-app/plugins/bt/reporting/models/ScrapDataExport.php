<?php

namespace Bt\Reporting\Models;

use Backend\Models\ExportModel;

class ScrapDataExport extends ExportModel
{
    public $table = 'view_scrapdata';

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
            return $query->whereBetween('cs_created_date', array($startdate, $enddate))->orderBy('id', 'desc')->get()->toArray();
        } else {
            return $query->orderBy('id', 'desc')->get()->toArray();
        }
    }


}
