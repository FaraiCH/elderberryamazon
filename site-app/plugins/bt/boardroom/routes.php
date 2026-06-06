<?php

use Carbon\Carbon;
use Bt\Boardroom\Models\Visitor as VisitorModel;
use October\Rain\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Renatio\DynamicPDF\Classes\PDF;



Route::any('/backend/boardroom/visitors/export', function () {
    $now = Carbon::now();
    $visitors = VisitorModel::where('date', '>=', $now)->orderBy('date', 'desc')->get();

    $pdf = PDF::loadView('bt.boardroom::pdfVisitors',array('visitors' =>$visitors));
    return $pdf->setPaper('a4', 'landscape')->download('Visitor_'.$now.'.pdf');
});

Route::any('/backend/boardroom/visitors/download/{id}', function ($id) {
    $now = Carbon::now();
    $induction = VisitorModel::find($id);

    $pdf = PDF::loadView('bt.boardroom::pdfInduction',array('Induction' =>$induction));
    return $pdf->setPaper('a4', 'portrait')->download('Induction_'.$now.'.pdf');
});
Route::any('/backend/boardroom/visitors/download/', function () {
    $induction = [];
    $now = Carbon::now();
    $pdf = PDF::loadView('bt.boardroom::pdfInduction',array('Induction' =>$induction));
    return $pdf->setPaper('a4', 'portrait')->download('Induction_'.$now.'.pdf');
});

