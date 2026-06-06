<?php

use Renatio\DynamicPDF\Classes\PDF;
use Bt\Production\Models\ControlSheet;
use \Bt\Production\Models\BtAccount;

Route::any('/batchsearch/view/details/{id}-{control}', function ($id, $control) {
    $cont =  ControlSheet::where('batch_id', $control)->first();
    $batch = $cont->jobcard_id. "-" . $cont->batch_id;
    $btaccount = BtAccount::where('quote_id', $cont->jobcard->pipe->qpush->quote_id)->get();
    $pdf = PDF::loadView('bt.reporting::result', array('cont' => $cont, 'batch' => $batch, 'btaccount' => $btaccount));
    return $pdf->setPaper('a3')->stream();
});
