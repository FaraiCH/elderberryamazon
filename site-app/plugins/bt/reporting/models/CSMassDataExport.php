<?php

namespace Bt\Reporting\Models;

use Backend\Models\ExportModel;

class CSMassDataExport extends ExportModel
{
    public $table = 'view_ControlSheetMassData';

    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }


}
