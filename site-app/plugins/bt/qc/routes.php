<?php

use Bt\Production\Models\Jobcard;
use Bt\Production\Models\Push as PushModel;
use Bt\Sales\Models\Newquote;
use Carbon\Carbon;
#use Japps\Wall\Models\Wall as WallModel;
#use Modules\Cms\Classes\Controller as Controller;
use Bt\QC\Models\LabResults as ModelRawMaterialReceiving;
use Bt\QC\Models\Datapack;
use Bt\QC\Models\DataPackIndex;

//use Storage;


use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Sales\Models\Quoteitems;
use Bt\QC\Models\NCR;
use janvince\smallcontactform\Models\Message;
use Illuminate\Support\Facades\Storage;

use October\Rain\Support\Facades\Http;

//use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel;
//use Vdomah\Excel\Classes\Excel;

use Maatwebsite\Excel\Facades\Excel;
use Bt\Sales\Models\QuoteReponse as QuoteReponseModel;

#use Excel;
//use PDF;
use Renatio\DynamicPDF\Classes\PDF;
use JanVince\SmallContactForm\Models\Settings;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

Route::any('/feedback/download/{id}.pdf', function ($id) {
  $fields = Settings::getTranslated('form_fields', []);
  $messages = Message::find($id);
  // dd( $messages->form_data );
  //dd( $fields );
foreach ($fields as $key => &$value) {
    $value["answer"]  = "";
      $q = $value["name"];
      foreach ($messages->form_data as $ak => $av) {
        if($q == $ak){
          $value["answer"]  = $av;
        }
      }

}

  $pdf = PDF::loadView('bt.qc::pdffeedback',array('fields'=>$fields,'messages'=>$messages));
   return $pdf->setPaper('a4')->download("BT-FEEDBACK-".sprintf('%04d', $id).'.pdf');
  // return $pdf->setPaper('a4')->download("BT-QC-NCR-".sprintf('%04d', $id).'.pdf');
});


Route::any('/qc/ncr/download/{id}.pdf', function ($id) {
  $quote = NCR::find($id);

  $pdf = PDF::loadView('bt.qc::pdfncr',array('quote'=>$quote));
  return $pdf->setPaper('a4')->download("BT-QC-NCR-".sprintf('%04d', $id).'.pdf');
});

Route::any('/qc/ncr/download/{id}', function ($id) {
  $quote = NCR::find($id);

  $pdf = PDF::loadView('bt.qc::pdfncr',array('quote'=>$quote));
   return $pdf->setPaper('a4')->stream();
});


Route::any('/lab/photos/download/{id}.pdf', function ($id) {

  $quote = ModelRawMaterialReceiving::find($id);
  if(isset($_SESSION["pipereport_id"])){
      $pipereport = \Bt\QC\Models\PipeReport::find($_SESSION["pipereport_id"]);

    if(isset($pipereport->supplier_batch->id)){
         $pdf = PDF::loadView('bt.qc::pdfphotos',array('quote'=>$pipereport));
    }

  }else{
      $pdf = PDF::loadView('bt.qc::pdfphotos',array('quote'=>$quote));
  }
  $pdf->setPaper('a4','landscape')->save(namePhotospdf($id));

  //return $pdf->setPaper('a4','landscape')->stream();


  return $pdf->setPaper('a4','landscape')->download(namePhotospdf($id));


});

Route::any('/lab/coc/download/{id}.pdf', function ($id) {
  $quote = ModelRawMaterialReceiving::find($id);

  $pdf = PDF::loadView('bt.qc::pdfcoc',array('quote'=>$quote));
  return $pdf->setPaper('a4')->download("BT-LAB-COC-".sprintf('%04d', $id).'.pdf');
});


Route::any('/lab/coc/download/{mat_id}/{pipe_item_id}/{cs_id}.pdf', function ($mat_id,$pipe_item_id,$cs_id) {

    $quote = ModelRawMaterialReceiving::find($mat_id);
    $pipe = PipeModel::find($pipe_item_id);

    $pipereport = \Bt\QC\Models\PipeReport::where('item_id', $pipe->quoteitems->id)->first();

    if(!isset($pipereport->supplier_batch->id)){
        $pipereport = null;
    }else{
        $_SESSION['piperep'] = $pipereport;
    }
    $code = "<=";
    $cs = ControlSheet::find($cs_id);
    $_SESSION['cs'] = $cs_id;

    $pdf = PDF::loadView('bt.qc::pdfcocprime',array('quote'=>$quote,'pipe'=>$pipe,'cs'=>$cs, 'code' => $code, 'pipereport' => $pipereport));
    $pdf->setPaper('a4')->save(nameCOC($mat_id,$pipe_item_id,$cs_id));
    return $pdf->setPaper('a4')->download("BT-LAB-COC-".$mat_id."-".$pipe_item_id."-".$cs_id."-".'.pdf');

});

Route::any('/lab/letterhead/download/{id}.pdf', function ($id) {
	$datapack = Datapack::find($id);
  $ids = array();
  foreach ($datapack->dataoptions as $key => $value) {
    $ids[$value["index"]] = $value["index"];
  }


  $dtindex = DataPackIndex::whereIn('id',$ids)->get();
  $csarray = array();
  $batcharray = array();

  $newindex = array();
  foreach ($datapack->dataoptions as $value) {
     foreach ($dtindex as $dkey => $dvalue) {


      if($value["index"] == $dvalue->id){
        $a = array();
        if(isset($value["altname"]) && !empty($value["altname"]) && $value["altname"] != "" ){
         $a["altname"] = $value["altname"];
        }else{

          $a["altname"] = $dvalue->name;
        }


        if(isset($value["altlabel"]) && !empty($value["altlabel"]) ){
          $a["altlabel"] = $value["altlabel"];
        }else{
          $a["altlabel"] = $dvalue->abc;
        }


        if(isset($value["numbering"]) && !empty($value["numbering"]) ){
          $a["numbering"] = $value["numbering"];
        }else{
          $a["numbering"] = $dvalue->numbering;
        }

        $newindex[] = $a;
      }
    }
  }

  $dtindex = $newindex;





  #foreach ($datapack->quote->items as $key => $qitem) {
    #if($datapack->item_id == $qitem->id )
    $qitem = $datapack->item;
    $pipeReport = \Bt\QC\Models\PipeReport::where('item_id', $qitem)->first();


    foreach($qitem->pipe->schedules as $k=>$schedules){
      if(isset($schedules->controlsheet) ){
        if(isset($schedules->controlsheet) && isset($schedules->controlsheet->file)){
        $csarray["#CS".$schedules->controlsheet->id." ###".$schedules->controlsheet->file->file_name] = $schedules->controlsheet->file->path;
        }

        foreach($schedules->usedmaterials as $key=>$value){
            if(isset($pipeReport->supplier_batch->id)){
                if($pipeReport->supplier_batch->id == $value->receiving->id){
                    $batcharray[$value->receiving->productname->name." - Batch #".$value->receiving->supplier_batch] = '/lab/coc/download/'.$value->receiving->id.'/'.$qitem->id.'/'.$schedules->controlsheet->id.'.pdf';
                }
            }


        }
      }
    }
  #}

  	$pdf = PDF::loadView('bt.qc::pdfletter',array('quote'=>$datapack,'csarray'=>$csarray,'batcharray'=>$batcharray,'dtindex' =>$dtindex));

    $pdf->setPaper('a4')->save(nameLetterhead($id));

  	return $pdf->download("BT-DATABACK-".sprintf('%04d', $id).'.pdf');
});

function namePhotospdf($id){
  return "storage/app/temp/BT-PHOTOS-".sprintf('%04d', $id).'.pdf';
}

function nameLetterhead($id){
  return "storage/app/temp/BT-DATABACK-".sprintf('%04d', $id).'.pdf';
}

function nameCOC($mat_id,$pipe_item_id,$cs_id){
  return "storage/app/temp/BT-LAB-COC-".$mat_id."-".$pipe_item_id."-".$cs_id."-".'.pdf';
}


function getFileForpdf($path){
  $a = explode('storage',$path);
  return base_path('/storage'.$a[1]);

}


Route::any('/temp/po', function () {
  //$pdf = new \Clegginabox\PDFMerger\PDFMerger;
  $obj = QuoteReponseModel::where("quote_status_id",10)->get();
  $cars = array(1791,1778,1792,1625,1815,1769,1664,1800,1623,1632,1726,1745,1807,1831,1616,1666,1748,1531,1763,1781,1531,1817,1642,1793,1674,1754,1695,1719,1702,1795,1636,1659,1598);
  foreach ($obj as $key => $value) {
    if(isset($value->file->path) && $value->file->extension == "pdf"){
      $file_u = getFileForpdf($value->file->path);
      //dd($value->file);

      if(in_array($value->quote->id,$cars))
      if (file_exists($file_u)){
        //$pdf->addPDF($file_u, '1','P');
       // $pdf->download();

        //$a = explode('storage/',$file_u);
        //$file = storage_path($a[1]);
        $destination = storage_path('app/temp/aug_po');
        echo "\ncp $file_u $destination/po_".$value->quote->id.".pdf";

        //$destination = storage_path('app/temp/po');
        //Storage::copy($file,$destination);

      }


    }

  }

  // $file = 'storage/app/temp/potemp.pdf';
  // $pdf->merge('browser', $file, 'P');

  // $file_link = base_path('/'.$file);
  //   if (file_exists($file_link)){
  //     return Response::download($file_link,'DATABA.pdf');
  //   }


});
Route::any('/lab/letterhead/download/newme/{id}.pdf', function ($id) {

  $pdf = new \Clegginabox\PDFMerger\PDFMerger;
  $datapack = Datapack::find($id);
  $pipereport = null;
  if(isset($datapack->pipereport->supplier_batch->id)){
      $pipereport = $datapack->pipereport->id;
  }
  if(!empty($datapack->header)){
      $file_u = getFileForpdf($datapack->header->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '1','P');
      }
  }

  $l = nameLetterhead($id);

  $file_u = getFileForpdf($l);
  if (file_exists($file_u)){
    $pdf->addPDF($file_u, '1','P');
  }
  $countpages=1;
  foreach ($datapack->dataoptions as $key => $value) {
    $countpages++;
    $index = $value["index"];
    $file_u = getFileForpdf($l);
    if (file_exists($file_u)){
      $pdf->addPDF($file_u,$countpages ,'P');
    }
    if($index == 1){
      if(!empty($datapack->qualityplan)){
        $file_u = getFileForpdf($datapack->qualityplan->path);
        if (file_exists($file_u)){
          $pdf->addPDF($file_u, 'all','L');
        }
      }
    }

    if($index == 2){
      call_2($datapack,$pdf, $pipereport);
    }
    if($index == 3){
      call_3($datapack,$pdf, $pipereport);
    }
    if($index == 4){
      call_4($datapack,$pdf, $pipereport);
    }
    if($index == 5){
      call_5($datapack,$pdf, $pipereport);
    }

    if($index == 6){
      call_6($datapack,$pdf, $pipereport);
    }

    if($index == 7){
      call_7($datapack,$pdf, $pipereport);
    }

    if($index == 8){
      call_8($datapack,$pdf, $pipereport);
    }

    if($index == 9){
      call_9($datapack,$pdf, $pipereport);
    }

    if($index == 10){
      call_10($datapack,$pdf, $pipereport);
    }

    if($index == 12){
      call_12($datapack,$pdf, $pipereport);
    }



    if($index == 13){
      call_13($datapack,$pdf, $pipereport);
    }
  }


  $file = 'storage/app/temp/'.$id.'.pdf';
  $pdf->merge('browser', $file, 'P');

  $file_link = base_path('/'.$file);
  if (file_exists($file_link)){
    return Response::download($file_link,'DATABA.pdf');
  }

  if(!empty($datapack->footer)){
      $file_u = getFileForpdf($datapack->footer->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '1','P');
      }
  }
});

function call_2($datapack,$pdf, $pipereport){
    // #### CERTIFICATE OF ANYLYSES (COA)
    $checkifran = array();
    if(!empty($pipereport)){
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        if(isset($mypipe->coa_file) && isset($mypipe->coa_file->path))
            if(isset($mypipe->supplier_batch->productname->id)){
                $coa[$mypipe->supplier_batch->productname->name." - Batch #".$mypipe->supplier_batch->supplier_batch] = $mypipe->coa_file->path ;
            }

            if(!empty($mypipe->coa_file)){


                $file_u = getFileForpdf($mypipe->coa_file->path);
                if (file_exists($file_u)){
                    if(!in_array($mypipe->supplier_batch->id,$checkifran))
                        $pdf->addPDF($file_u, 'all','P');

                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }
    }else{
        if(isset($value->labresults->coa_file) && isset($value->labresults->coa_file->path))
            $coa[$value->labresults->productname->name." - Batch #".$value->labresults->supplier_batch] = $value->labresults->coa_file->path ;

        #foreach ($datapack->quote->items as $key => $qitem) {
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapipe->id == $quotepipe->id)
        if(isset($datapipe->schedules ))
            foreach($datapipe->schedules as $k=>$schedules){
                foreach($schedules->usedmaterials as $key=>$value){
                    if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                        if(isset($value->labresults->coa_file) && isset($value->labresults->coa_file->path)){
                            $file_u = getFileForpdf($value->labresults->coa_file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');

                                $checkifran[$value->receiving->id] = $value->receiving->id;
                            }
                        }
                    }
                }
            }
    }






 # }

}

function call_3($datapack,$pdf, $pipereport){
    ##CERTIFICATE OF CONFORMANCE (COC)
    $checkifran = array();
    $mysesh = null;
    if(!empty($pipereport)) {
        if(isset($_SESSION['cs']))
            $mysesh = $_SESSION['cs'];
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $schedule){
            if(isset($schedule->controlsheet)){
                if($schedule->controlsheet->id == $mysesh){
                    if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                        $l = nameCOC($mypipe->supplier_batch->id,$schedule->pipe_id,$schedule->controlsheet->id);
                        $file_u = getFileForpdf($l);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');
                            $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                        }
                    }
                }
            }
        }
    }else{
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            if(isset($schedules->controlsheet)){
                foreach($schedules->usedmaterials as $key=>$value){
                    if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                        $l = nameCOC($value->receiving->id,$schedules->pipe_id,$schedules->controlsheet->id);

                        $file_u = getFileForpdf($l);
                        if (file_exists($file_u)){
                            if(!in_array($value->receiving->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');

                            $checkifran[$value->receiving->id] = $value->receiving->id;
                        }
                    }
                }
            }
        }
    }
    #foreach ($datapack->quote->items as $key => $qitem) {


    #}

}

function call_4($datapack,$pdf, $pipereport){
  ###MELT FLOW INDEX TEST (MFI)
  $checkifran = array();
    if(!empty($pipereport)) {
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                if(isset($mypipe->mfifiles)){
                    foreach ($mypipe->mfifiles as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');
                        }
                    }
                    foreach ($mypipe->mfifiles_post as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');
                        }
                    }
                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }

        }
    }else{
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            foreach($schedules->usedmaterials as $key=>$value){
                if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                    if(isset($value->labresults->mfifiles)){
                        foreach ($value->labresults->mfifiles as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');
                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                    if(isset($value->labresults->mfifiles_post)){
                        foreach ($value->labresults->mfifiles_post as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');
                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }
    }
  #foreach ($datapack->quote->items as $key => $qitem) {
  #}
}

function call_5($datapack,$pdf, $pipereport){
  ### OXIDATION INDUCTION TIME (OIT)

    $checkifran = array();
    if(!empty($pipereport)) {
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;

        foreach($datapipe->schedules as $k=>$schedules){

            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                if(isset($mypipe->iot_file)) {
                    foreach ($mypipe->iot_file as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)) {
                            if (!in_array($mypipe->supplier_batch->id, $checkifran))
                                $pdf->addPDF($file_u, 'all', 'P');

                        }
                    }
                    foreach ($mypipe->iotfiles_post as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');
                        }
                    }
                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }

        }
    }else{
        #foreach ($datapack->quote->items as $key => $qitem) {
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            foreach($schedules->usedmaterials as $key=>$value){
                if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                    if(isset($value->labresults->iot_file)){
                        foreach ($value->labresults->iot_file as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');

                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }
    }


  #}
}


function call_6($datapack,$pdf, $pipereport){
  ###INSPECTION SHEET
}

function call_7($datapack,$pdf, $pipereport){

  ###HYDROSTATIC PRESSURE TEST
  $checkifran = array();
    if(!empty($pipereport)) {
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;
        foreach($datapipe->schedules as $k=>$schedules){

            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                if(isset($mypipe->hydro_file)){
                    foreach ($mypipe->hydro_file as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');
                        }
                    }
                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }

        }
        $checkifran = array();
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                if(isset($mypipe->hydro_file_2)){
                    foreach ($mypipe->hydro_file_2 as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');
                        }
                    }
                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }
        }
        #}

        $checkifran = array();
        #foreach ($datapack->quote->items as $key => $qitem) {

        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                if(isset($mypipe->hydro_file_3)){
                    foreach ($mypipe->hydro_file_3 as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');
                        }
                    }
                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }
        }

    }else{
        #foreach ($datapack->quote->items as $key => $qitem) {
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            foreach($schedules->usedmaterials as $key=>$value){
                if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                    if(isset($value->labresults->hydro_file)){
                        foreach ($value->labresults->hydro_file as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');
                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }

        $checkifran = array();
        #foreach ($datapack->quote->items as $key => $qitem) {
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            foreach($schedules->usedmaterials as $key=>$value){
                if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){

                    if(isset($value->labresults->hydro_file_2)){
                        foreach ($value->labresults->hydro_file_2 as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');
                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }
        #}

        $checkifran = array();
        #foreach ($datapack->quote->items as $key => $qitem) {

        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            foreach($schedules->usedmaterials as $key=>$value){
                if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                    if(isset($value->labresults->hydro_file_3)){
                        foreach ($value->labresults->hydro_file_3 as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');
                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }
    }
    }


  #}


#}

function call_8($datapack,$pdf, $pipereport){
  ### THERMAL REVISION TEST
  $checkifran = array();
  #foreach ($datapack->quote->items as $key => $qitem) {
    if(!empty($pipereport)) {
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;
        foreach($datapipe->schedules as $k=>$schedules){

            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
              if(isset($mypipe->thermal_file)){
                foreach ($mypipe->thermal_file as $f => $file) {
                    $file_u = getFileForpdf($file->path);
                    if (file_exists($file_u)){
                      if(!in_array($mypipe->supplier_batch->id,$checkifran))
                        $pdf->addPDF($file_u, 'all','P');
                    }
                  }
                  $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
              }
            }
      }
    }else{
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
            foreach ($datapipe->schedules as $k => $schedules) {
                foreach ($schedules->usedmaterials as $key => $value) {
                    if (isset($value->labresults->thermal_file)) {
                        foreach ($value->labresults->thermal_file as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)) {
                                if (!in_array($value->receiving->id, $checkifran))
                                    $pdf->addPDF($file_u, 'all', 'P');
                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }

  }
#}

function call_9($datapack,$pdf, $pipereport){

  ### OXIDATION INDUCTION TIME (OIT)


  $checkifran = array();
    if(!empty($pipereport)) {
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;
        foreach($datapipe->schedules as $k=>$schedules) {
            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                if(isset($mypipe->iot_file)){
                    foreach ($mypipe->iot_file as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');

                        }
                    }
                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }

                if(isset($mypipe->iotfiles_post)){
                    foreach ($mypipe->iotfiles_post as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');

                        }
                    }
                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }
        }
    }else{
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            foreach($schedules->usedmaterials as $key=>$value){
                if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                    if(isset($value->labresults->iot_file)){
                        foreach ($value->labresults->iot_file as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');

                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                    if(isset($value->labresults->iotfiles_post)){
                        foreach ($value->labresults->iotfiles_post as $f => $file) {
                            $file_u = getFileForpdf($file->path);
                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran))
                                    $pdf->addPDF($file_u, 'all','P');

                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }
    }
  #foreach ($datapack->quote->items as $key => $qitem) {

  #}
}

function call_10($datapack,$pdf, $pipereport){
  ###TENSILE TEST (ELONGATION AT BREAK)

  $checkifran = array();
  #foreach ($datapack->quote->items as $key => $qitem) {

    if(!empty($pipereport)) {
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;
        foreach($datapipe->schedules as $k=>$schedules){
            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                if(isset($mypipe->elongation_file)){
                    foreach ($mypipe->elongation_file as $f => $file) {
                        $file_u = getFileForpdf($file->path);

                        if (file_exists($file_u)){
                            if(!in_array($mypipe->supplier_batch->id,$checkifran)){



                                #----------------
                                try {
                                    $pdf->addPDF($file_u, 'all','P');
                                } catch (Exception $e) {

                                }
                                #----------------
                            }


                        }
                    }
                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }

        }
    }else{
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        # if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            foreach($schedules->usedmaterials as $key=>$value){
                if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                    if(isset($value->labresults->elongation_file)){
                        foreach ($value->labresults->elongation_file as $f => $file) {
                            $file_u = getFileForpdf($file->path);

                            if (file_exists($file_u)){
                                if(!in_array($value->receiving->id,$checkifran)){



                                    #----------------
                                    try {
                                        $pdf->addPDF($file_u, 'all','P');
                                    } catch (Exception $e) {
                                        trace_log("Print my file $file_u ".$e->getMessage());
                                    }
                                    #----------------
                                }


                            }
                        }
                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }
    }

  #}
}

function call_12($datapack,$pdf, $pipereport){
  ###PRODUCTION CONTROL SHEET


  #foreach ($datapack->quote->items as $key => $qitem) {

      $datapipe = Quoteitems::find($datapack->item_id)->pipe;
   #if($datapack->item_id == $qitem->id )
    foreach($datapipe->schedules as $k=>$schedules){
      if(isset($schedules->controlsheet) && isset($schedules->controlsheet->file)){
        $file_u = getFileForpdf($schedules->controlsheet->file->path);
        if (file_exists($file_u)){
          $pdf->addPDF($file_u, 'all','L');
        }
      }
    }
  #}
}

function call_13($datapack,$pdf, $pipereport){
    ## PHOTOS OF SAMPLES
    $checkifran = array();
    if(!empty($pipereport)) {
        $mypipe = \Bt\QC\Models\PipeReport::find($pipereport);
        $datapipe = Quoteitems::find($mypipe->item_id)->pipe;
        foreach($datapipe->schedules as $k=>$schedules){
            if(isset($mypipe->supplier_batch) && isset($mypipe->supplier_batch->productname) && $mypipe->supplier_batch->productname->cat_id != 2){
                $l = namePhotospdf($mypipe->supplier_batch->id);
                $file_u = getFileForpdf($l);
                if (file_exists($file_u)){
                    if(!in_array($mypipe->supplier_batch->id,$checkifran))
                        $pdf->addPDF($file_u, 'all','L');

                    $checkifran[$mypipe->supplier_batch->id] = $mypipe->supplier_batch->id;
                }
            }

        }
    }else{
        #foreach ($datapack->quote->items as $key => $qitem) {
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
        #if($datapack->item_id == $qitem->id )
        foreach($datapipe->schedules as $k=>$schedules){
            foreach($schedules->usedmaterials as $key=>$value){
                if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
                    $l = namePhotospdf($value->receiving->id);
                    $file_u = getFileForpdf($l);
                    if (file_exists($file_u)){
                        if(!in_array($value->receiving->id,$checkifran))
                            $pdf->addPDF($file_u, 'all','L');

                        $checkifran[$value->receiving->id] = $value->receiving->id;
                    }
                }
            }
        }
    }


    #}
}

Route::any('/lab/letterhead/download/me/{id}.pdf', function ($id) {
    $pipereport = null;

    if(isset($_SESSION['piperep'])){
        $pipereport =  $_SESSION['piperep'];
    }
  $pdf = new \Clegginabox\PDFMerger\PDFMerger;
  $datapack = Datapack::find($id);


  if(!empty($datapack->header)){
      $file_u = getFileForpdf($datapack->header->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '1','P');
      }
  }

  $l = nameLetterhead($id);
  // dd($l);


  $file_u = getFileForpdf($l);
  if (file_exists($file_u)){
    $pdf->addPDF($file_u, '1','P');
  }

  // if(!empty($datapack->template)){
  //     $file_u = getFileForpdf($datapack->template->path);
  //     if (file_exists($file_u)){
  //       $pdf->addPDF($file_u, '1','P');
  //     }
  // }

  ##qualityplan
  if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '2','P');
      }
  }

  if(!empty($datapack->qualityplan)){
      $file_u = getFileForpdf($datapack->qualityplan->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, 'all','L');
      }
  }



  ###### COC

   ##CERTIFICATE OF CONFORMANCE (COC)
  if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '3','P');
      }
  }
  $checkifran = array();
  $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules){
      if(isset($schedules->controlsheet) ){
        foreach($schedules->usedmaterials as $key=>$value){
            if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
              $l = nameCOC($value->receiving->id,$schedules->pipe_id,$schedules->controlsheet->id);

              $file_u = getFileForpdf($l);
              if (file_exists($file_u)){
                if(!in_array($value->receiving->id,$checkifran))
                  $pdf->addPDF($file_u, 'all','P');

                $checkifran[$value->receiving->id] = $value->receiving->id;
              }
            }
        }
      }
    }
//  }


  // ###PRODUCTION CONTROL SHEET
  // if(!empty($datapack->template)){
  //     $file_u = getFileForpdf($datapack->template->path);
  //     if (file_exists($file_u)){
  //       $pdf->addPDF($file_u, '6','P');
  //     }
  // }

  // foreach ($datapack->quote->items as $key => $qitem) {
  //  if($datapack->item_id == $qitem->id )
  //   foreach($qitem->pipe->schedules as $k=>$schedules){
  //     if(isset($schedules->controlsheet) && isset($schedules->controlsheet->file)){
  //       $file_u = getFileForpdf($schedules->controlsheet->file->path);
  //       if (file_exists($file_u)){
  //         $pdf->addPDF($file_u, 'all','L');
  //       }
  //     }
  //   }
  // }

  // ###QC INSPECTION REPORT
  // if(!empty($datapack->template)){
  //     $file_u = getFileForpdf($datapack->template->path);
  //     if (file_exists($file_u)){
  //       $pdf->addPDF($file_u, '7','P');
  //     }
  // }



  //  foreach ($datapack->quote->items as $key => $qitem) {
  //  if($datapack->item_id == $qitem->id )
  //   foreach($qitem->pipe->schedules as $k=>$schedules){
  //     if(isset($schedules->controlsheet) && isset($schedules->controlsheet->fileinspectionreport)){
  //       $file_u = getFileForpdf($schedules->controlsheet->fileinspectionreport->path);
  //       if (file_exists($file_u)){
  //         $pdf->addPDF($file_u, 'all','P');
  //       }
  //     }
  //   }
  // }



  ###MELT FLOW INDEX TEST (MFI)
   if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '4','P');
      }
  }



  ###MELT FLOW INDEX TEST (MFI)
   if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '5','P');
      }
  }



  $checkifran = array();
    $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
//    if($datapack->item_id == $qitem->id )
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules) {
      foreach($schedules->usedmaterials as $key=>$value){
        if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
            if(isset($pipereport)) {
                if(isset($pipereport->mfifiles_post)){
                    foreach ($pipereport->mfifiles_post as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($value->receiving->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');
                        }
                    }
                    $checkifran[$value->receiving->id] = $value->receiving->id;
                }
            }else{
                if(isset($value->labresults->mfifiles_post)){
                    foreach ($value->labresults->mfifiles_post as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($value->receiving->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');


                        }
                    }
                    $checkifran[$value->receiving->id] = $value->receiving->id;
                }
            }

        }
      }
    }
//  }


 ### OXIDATION INDUCTION TIME (OIT)
  if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '6','P');
      }
  }

  $checkifran = array();
    $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
//    if($datapack->item_id == $qitem->id )
      $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules){
      foreach($schedules->usedmaterials as $key=>$value){
        if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
            if(isset($pipereport)){
                if(isset($pipereport->iot_file)){
                    foreach ($pipereport->iot_file as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($value->receiving->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');

                        }
                    }
                    $checkifran[$value->receiving->id] = $value->receiving->id;
                }
                if(isset($pipereport->iotfiles_post)){
                    foreach ($pipereport->iotfiles_post as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($value->receiving->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');

                        }
                    }
                    $checkifran[$value->receiving->id] = $value->receiving->id;
                }
            }else{
                if(isset($value->labresults->iot_file)){
                    foreach ($value->labresults->iot_file as $f => $file) {
                        $file_u = getFileForpdf($file->path);
                        if (file_exists($file_u)){
                            if(!in_array($value->receiving->id,$checkifran))
                                $pdf->addPDF($file_u, 'all','P');

                        }
                    }
                    $checkifran[$value->receiving->id] = $value->receiving->id;
                }
            }

        }
      }
    }
//  }

    ### THERMAL REVISION TEST
  if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '7','P');
      }
  }

    $checkifran = array();
      $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
//    if($datapack->item_id == $qitem->id )
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules){
      foreach($schedules->usedmaterials as $key=>$value){
        if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
          if(isset($value->labresults->thermal_file)){
            foreach ($value->labresults->thermal_file as $f => $file) {
                $file_u = getFileForpdf($file->path);
                if (file_exists($file_u)){
                  if(!in_array($value->receiving->id,$checkifran))
                    $pdf->addPDF($file_u, 'all','P');


                }
              }
              $checkifran[$value->receiving->id] = $value->receiving->id;
          }
        }
      }
    }
//  }

  ###TENSILE TEST (ELONGATION AT BREAK)
  if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '8','P');
      }
  }

  $checkifran = array();
    $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
//    if($datapack->item_id == $qitem->id )
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules){
      foreach($schedules->usedmaterials as $key=>$value){
        if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
          if(isset($value->labresults->elongation_file)){
            foreach ($value->labresults->elongation_file as $f => $file) {
                $file_u = getFileForpdf($file->path);

                if (file_exists($file_u)){
                  if(!in_array($value->receiving->id,$checkifran)){



                    #----------------
                      try {
                          $pdf->addPDF($file_u, 'all','P');
                      } catch (Exception $e) {
                          trace_log("Print my file $file_u ".$e->getMessage());
                      }
                    #----------------
                  }


                }
              }
              $checkifran[$value->receiving->id] = $value->receiving->id;
          }
        }
      }
    }
//  }










  ###HYDROSTATIC PRESSURE TEST
  if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '9','P');
      }
  }

  $checkifran = array();
    $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
//    if($datapack->item_id == $qitem->id )
      $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules){
      foreach($schedules->usedmaterials as $key=>$value){
        if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
          if(isset($value->labresults->hydro_file)){
            foreach ($value->labresults->hydro_file as $f => $file) {
                $file_u = getFileForpdf($file->path);
                if (file_exists($file_u)){
                  if(!in_array($value->receiving->id,$checkifran))
                    $pdf->addPDF($file_u, 'all','P');


                }
              }
              $checkifran[$value->receiving->id] = $value->receiving->id;
          }




        }
      }
    }
//  }

    $checkifran = array();
      $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
//    if($datapack->item_id == $qitem->id )
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules){
      foreach($schedules->usedmaterials as $key=>$value){
        if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){

           if(isset($value->labresults->hydro_file_2)){
            foreach ($value->labresults->hydro_file_2 as $f => $file) {
                $file_u = getFileForpdf($file->path);
                if (file_exists($file_u)){
                  if(!in_array($value->receiving->id,$checkifran))
                    $pdf->addPDF($file_u, 'all','P');


                }
              }
              $checkifran[$value->receiving->id] = $value->receiving->id;
          }


        }
      }
    }
//  }

    $checkifran = array();
      $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
//    if($datapack->item_id == $qitem->id )
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules){
      foreach($schedules->usedmaterials as $key=>$value){
        if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){



           if(isset($value->labresults->hydro_file_3)){
            foreach ($value->labresults->hydro_file_3 as $f => $file) {
                $file_u = getFileForpdf($file->path);
                if (file_exists($file_u)){
                  if(!in_array($value->receiving->id,$checkifran))
                    $pdf->addPDF($file_u, 'all','P');


                }
              }
              $checkifran[$value->receiving->id] = $value->receiving->id;
          }
        }
      }
    }
//  }













   ## PHOTOS OF SAMPLES
  if(!empty($datapack->template)){
      $file_u = getFileForpdf($datapack->template->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '10','P');
      }
  }

  $checkifran = array();
    $skip = 0;
  if($skip == 0)
//  foreach ($datapack->quote->items as $key => $qitem) {
//    if($datapack->item_id == $qitem->id )
        $datapipe = Quoteitems::find($datapack->item_id)->pipe;
    foreach($datapipe->schedules as $k=>$schedules){
      foreach($schedules->usedmaterials as $key=>$value){
        if(isset($value->receiving) && isset($value->receiving->productname) && $value->receiving->productname->cat_id != 2){
          $l = namePhotospdf($value->receiving->id);
          $file_u = getFileForpdf($l);
          if (file_exists($file_u)){
            if(!in_array($value->receiving->id,$checkifran))
              $pdf->addPDF($file_u, 'all','L');

            $checkifran[$value->receiving->id] = $value->receiving->id;
          }
        }
      }
    }
//  }

  if(!empty($datapack->footer)){
      $file_u = getFileForpdf($datapack->footer->path);
      if (file_exists($file_u)){
        $pdf->addPDF($file_u, '1','P');
      }
  }

  //dd(Storage::get($datapack->qualityplan));

 // $pdf->addPDF('http://i.btindustrial.co.za/lab/letterhead/download/'.$id.'.pdf', '1');

  //$pdf->addPDF('C:\xampp\htdocs\btindustrial\storage\app/uploads/public/5f0/dae/4a7/5f0dae4a7ede0826054706.pdf', '1','P');
  // $pdf->addPDF('samplepdfs/three.pdf', 'all');

  // //You can optionally specify a different orientation for each PDF
  // $pdf->addPDF('samplepdfs/one.pdf', '1, 3, 4', 'L');
  // $pdf->addPDF('samplepdfs/two.pdf', '1-2', 'P');
    $file = 'storage/app/temp/'.$id.'.pdf';
    $pdf->merge('browser', $file, 'P');
    dd($file);
    $file_link = base_path('/'.$file);
        if (file_exists($file_link)){
          return Response::download($file_link,'DATABA.pdf');
        }

  //return $pdf->download("BT-DATABACK-".sprintf('%04d', $id).'.pdf');
});



