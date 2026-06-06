<?php

use Carbon\Carbon;
use Bt\Finance\Models\Requisition;

use October\Rain\Support\Facades\Http;

//use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel;
//use Vdomah\Excel\Classes\Excel;

use Maatwebsite\Excel\Facades\Excel;

#use Excel;
//use PDF;
use Renatio\DynamicPDF\Classes\PDF;



Route::any('/finance/requisition/item/download/{id}.pdf', function ($id) {
  $quote = Requisition::find($id);
  $pdf = PDF::loadView('bt.finance::pdfrequsition',array('quote'=>$quote));
  return $pdf->setPaper('a4')->download("BT-REQUISITON-".sprintf('%04d', $id).'.pdf');
});

Route::any('/finance/requisition/invoice/download/{id}', function ($id) {

 $quote = Requisition::find($id);
  if(!empty($quote)){
    //return $quote->file;
    if(!empty($quote->invoice)){
        $a = explode('storage',$quote->invoice->path);
        $file = base_path('/storage'.$a[1]);
        if (file_exists($file)){
          return Response::download($file,$quote->invoice->file_name);
        }
    }
 }
 
   
});