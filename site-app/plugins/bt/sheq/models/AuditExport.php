<?php


namespace Bt\Sheq\Models;


use Backend\Models\ExportModel;

class AuditExport extends ExportModel
{
    public $table = 'bt_sheq_audits';
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }
}
