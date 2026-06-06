<?php

namespace Bt\Reporting\Models;

use Backend\Models\ExportModel;

class ProductionElectricityExport extends ExportModel
{
    public $table = 'view_weeky_production_vs_electricity';

    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }


}
