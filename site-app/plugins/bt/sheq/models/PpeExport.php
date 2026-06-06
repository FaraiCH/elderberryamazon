<?php


namespace Bt\Sheq\Models;


use Backend\Models\ExportModel;

class PpeExport extends ExportModel
{
    public $table = 'bt_sheq_ppes';
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }
}
