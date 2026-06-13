<?php

use Carbon\Carbon;
use Bt\Logistics\Models\Vehicle as ModelVehicle;
use October\Rain\Support\Facades\Http;
use Renatio\DynamicPDF\Classes\PDF;
use Bt\Sales\Models\Pickslip;

Route::any('/admin/bt/logistics/pipe/export',function () {
    return Excel::download(new \Bt\Logistics\Models\PipeExport(), 'Pipe-Export.xlsx');
});
Route::any('/vehicle/item/download/{id}.pdf', function ($id) {
  $quote = ModelVehicle::find($id);
  $pdf = PDF::loadView('bt.logistics::pdfvehicle',array('quote'=>$quote));
  return $pdf->download("BT-Vehicle".sprintf('%04d', $id).'.pdf');
});

Route::any('/print/truckload/{id}.pdf', function ($id) {
    $pickslip = Pickslip::find($id);
    $pdf = PDF::loadView('bt.logistics::pdfTruckLoad',array('picklsip'=>$pickslip));
    return $pdf->download("BT-Truck".sprintf('%04d', $id).'.pdf');
});

Route::get('/logistics/dispatch/daily', function (){
    return Excel::download(new \Bt\Logistics\Classes\DailyLogistics(), 'Daily Dispatch.xlsx');
});
