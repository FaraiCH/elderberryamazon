<?php

use Carbon\Carbon;
#use Japps\Wall\Models\Wall as WallModel;
#use Modules\Cms\Classes\Controller as Controller;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\Srn as ModelSrn;
use Bt\Maintenance\Models\Schedule as ModelSchedule;
use Bt\Maintenance\Models\JobCard as ModelJobCard;
use October\Rain\Support\Facades\Http;
use Bt\Maintenance\Models\Tools as ToolsModel;
//use PDF;
use Renatio\DynamicPDF\Classes\PDF;

Route::any('/maintenance/item/download/schedule.pdf', function () {

 $date = Carbon::now();
  $quote = ModelSchedule::active()->orderBy('scheduledate')->get();
  $pdf = PDF::loadView('bt.maintenance::pdfschedule',array('quote'=>$quote));
  return $pdf->setPaper('a4', 'landscape')->download('Maintenance_Schedule_'.$date->format('d-m-Y').'.pdf');

});

Route::any('/jobcard/item/download/{id}.pdf', function ($id) {
  $quote = ModelJobCard::find($id);
  $pdf = PDF::loadView('bt.sales::pdfjobarditem',array('quote'=>$quote));
  return $pdf->download("BT-JOBCARD-".sprintf('%04d', $id).'.pdf');
});

Route::any('/schedule/item/download/{id}.pdf', function ($id) {
  $quote = ModelSchedule::find($id);
  $pdf = PDF::loadView('bt.sales::pdfscheduleitem',array('quote'=>$quote));
  return $pdf->download("BT-SCHEDULE-".sprintf('%04d', $id).'.pdf');
});

Route::any('/tools/item/download/{id}.pdf', function ($id) {
  $quote = ToolsModel::find($id);
  $pdf = PDF::loadView('bt.maintenance::pdftoolsitem',array('quote'=>$quote));
  return $pdf->download("BT-TOOL-".sprintf('%04d', $id).'.pdf');
});

Route::any('/checklist/item/download/{id}.pdf', function ($id) {
  $quote = ToolsModel::find($id);
  $pdf = PDF::loadView('bt.maintenance::pdftoolschecklist',array('quote'=>$quote,'cid'=>null));
  return $pdf->download("BT-TOOL-CHECKLIST".sprintf('%04d', $id).'.pdf');
});

Route::any('/checklist/item/download/{id}/{cid}.pdf', function ($id,$cid) {
  $quote = ToolsModel::find($id);
  $pdf = PDF::loadView('bt.maintenance::pdftoolschecklist',array('quote'=>$quote,'cid'=>$cid));
  return $pdf->download("BT-TOOL-CHECKLIST".sprintf('%04d', $id).'.pdf');
});


Route::get('/home/electric-reading/', [\Bt\Maintenance\Controllers\Electricity::class, 'showPDF']);
Route::get('/home/electric-reading/yearly/', [\Bt\Maintenance\Controllers\Electricity::class, 'showYearly']);
