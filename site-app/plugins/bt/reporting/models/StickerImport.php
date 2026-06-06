<?php
namespace Bt\Reporting\Models;

use Backend\Models\ImportModel;
use \Bt\Production\Models\Pipestickeritem;
class StickerImport extends ImportModel
{
    public $rules = [];
    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
            if (isset($data['pickslip'])) {
                $stickeritem = Pipestickeritem::find($data['id']);
                if (!empty($stickeritem)) {
                    if(!isset($stickeritem->dispatch_date)){
                        $stickeritem->pickslip_id = $data['pickslip'];
                        $stickeritem->dispatch_date = now();
                        $stickeritem->save();
                    }
                }
            }
        }
    }
}
