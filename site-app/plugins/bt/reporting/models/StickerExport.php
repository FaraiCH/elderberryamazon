<?php

namespace Bt\Reporting\Models;

use Backend\Models\ExportModel;

class StickerExport extends ExportModel
{
    public $table = 'new_view_stickerdata';

    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->where('srn_date', '>', '2024-04-01 00:00:00')->where('pickslip_id', '!=', null)->get()->toArray();
    }


}
