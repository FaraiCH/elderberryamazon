<?php

namespace Bt\Reporting\Models;

use Backend\Models\ExportModel;

class QuotePerformanceExport extends ExportModel
{
    public $table = 'view_quote_perfomance';

    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }


}