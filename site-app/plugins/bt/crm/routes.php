<?php

use Carbon\Carbon;
#use Japps\Wall\Models\Wall as WallModel;
#use Modules\Cms\Classes\Controller as Controller;
use Bt\CRM\Models\ProductionReport;
use Bt\CRM\Models\ExportForm;
use October\Rain\Support\Facades\Http;

use RainLab\Blog\Models\Category as BlogCategory;
use Bt\Sales\Models\Newquote as QuoteModel;
//use Maatwebsite\Excel\Facades\Excel;

#use Excel;
//use PDF;
use Renatio\DynamicPDF\Classes\PDF;
//use Barryvdh\Snappy\Facades\SnappyPdf;
// // Route::any('/maintenance/item/download/schedule.pdf', function () {
//
// //   $quote = ModelSchedule::active()->orderBy('scheduledate')->get();
// //   $pdf = PDF::loadView('bt.maintenance::pdfschedule',array('quote'=>$quote));
// //   return $pdf->setPaper('a4', 'landscape')->download('schedule.pdf');
//
// //        });

Route::any('/crm/report/download/{id}/{keypass}.pdf', function ($id,$keypass) {
   $quote = ProductionReport::where('id',$id)->where('keypass',$keypass)->first();

   //return Response::view('bt.crm::pdfproductionreportpdf',array('report'=>$quote));

 //   $pdf = SnappyPdf::loadFile('http://i.btindustrial.co.za/crm/report/download/'.$id.'/'.$keypass);

 //   $pdf->setOption('enable-javascript', true);
	// $pdf->setOption('javascript-delay', 5000);
	// $pdf->setOption('enable-smart-shrinking', true);
	// $pdf->setOption('no-stop-slow-scripts', true);

	// return $pdf->inline('github.pdf');
//  dd($quote->quote->qpush );
 // return Response::view('bt.crm::pdfproductionreportpdf',array('report'=>$quote));
   //$ht = Response::view('bt.crm::pdfproductionreport',array('report'=>$quote))
 $pdf = Pdf::loadView('bt.crm::pdfproductionreportpdf',array('report'=>$quote));
 //   	$pdf->setOption('debug-javascript', true);
	// $pdf->setOption('enable-javascript', true);
	// $pdf->setOption('enable-javascript', true);
	// $pdf->setOption('javascript-delay', 5000);
	// $pdf->setOption('enable-smart-shrinking', false);
	// $pdf->setOption('no-stop-slow-scripts', false);

  //$pdf = SnappyPdf::loadView('bt.crm::pdfproductionreportpdf',array('report'=>$quote));
 //  $pdf = SnappyPdf::loadView('bt.crm::pdfproductionreportpdf',array('report'=>$quote));
  //$pdf->render();
 // $pdf->setOptions(['enable-javascript'=> true,'javascript-delay' => 13500,'no-stop-slow-scripts'=>true]);
  //return $pdf->setPaper('a4')->inline('report.pdf');
  return $pdf->setPaper('a4')->stream();
  //return $pdf->setPaper('a4')->download("BT-PRODUCTION-REPORT-".sprintf('%04d', $id).'.pdf');
});

Route::any('/crm/report/download/{id}/{keypass}', function ($id,$keypass) {

  $quote = ProductionReport::where('id',$id)->where('keypass',$keypass)->first();
//  dd($quote->quote->qpush );
  return Response::view('bt.crm::pdfproductionreport',array('report'=>$quote));

});
Route::any('/sales/report/download/{id}/{userid}', function ($id,$userid) {

  $quote = QuoteModel::where('id',$id)->where('user_id',$userid)->first();
//  dd($quote->quote->qpush );
  if(!empty($quote) ){
      return Response::view('bt.crm::pdfproductionreportofficeonly',array('quote'=>$quote));
  }else{
      echo "Invalid call";
  }


});


// // Route::any('/pipe/item/download/{id}', function ($id) {
//
// // 	$quote = PipeModel::find($id);
// // 	//dd($quote);
// // 	$pdf = PDF::loadView('bt.production::pdfpipe',array('quote'=>$quote));
// // 	$name = (!empty($quote->qpush->quote->invoice->name)?$quote->qpush->quote->invoice->name:"")." - ".$quote->qpush->quote->company_name." - ".$quote->quoteitems->description;
// // 	return $pdf->setPaper('a4', 'landscape')->download($name.'.pdf');
//
// //        });

Route::any('/crm/form/preview/{id}', function ($id) {
  $quote = ExportForm::where('id',$id)->first();
  $pdf = Pdf::loadView('bt.crm::pdfformexport',array('quote'=>$quote));
  return $pdf->setPaper('a4')->stream();

});

Route::any('/crm/form/preview/{id}.pdf', function ($id) {
  $quote = ExportForm::where('id',$id)->first();
  $pdf = Pdf::loadView('bt.crm::pdfformexport',array('quote'=>$quote));
  //return $pdf->setPaper('a4')->stream();
  return $pdf->setPaper('a4')->download("BT-EXPORT-FORM-".$id.'.pdf');

});

Route::any('/erp/userguide', function () {

  $categories = BlogCategory::with('posts_count')->getNested();
  //dd($categories);
  $pdf = Pdf::loadView('bt.crm::pdferpdoc',array('categories'=>$categories));
   return $pdf->setPaper('a4', 'landscape')->download('ERP-Traing.pdf');
   return $pdf->setPaper('a4')->stream();
  #return Response::view('bt.crm::pdferpdoc',array('categories'=>$categories));

});

Route::any('/erp/userguide/{id}', function ($id) {

  $categories = BlogCategory::where('slug',$id)->with('posts_count')->getNested();
  //dd($categories);
  $pdf = Pdf::loadView('bt.crm::pdferpdoc',array('categories'=>$categories));
  // return $pdf->setPaper('a4')->stream();
  return $pdf->setPaper('a4', 'landscape')->download("ERP-Traing-".$id.'.pdf');
  #return Response::view('bt.crm::pdferpdoc',array('categories'=>$categories));

});
