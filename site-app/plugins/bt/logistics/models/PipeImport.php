<?php


namespace Bt\Logistics\Models;

use Backend\Models\ImportModel;
use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\JobCardBatch;
use Bt\Production\Models\Schedule as ScheduleModel;

class PipeImport extends ImportModel
{
    public $rules = [];
    public function importData($results, $sessionKey = null)
    {
        //Import BATCH
        $dataObj = array();
        foreach ($results as $row => $data) {
            // Extract Batch No from $data array object
            // use batch number to match batch with what is on the system
            // Make sure items being referenced are produced (schedule)
            if (strpos($data['batch'], '-')) {
                $ex = explode('-', $data['batch']);
                $batch_no = (int) filter_var($ex[1], FILTER_SANITIZE_NUMBER_INT);
                $jobcard_id = (int) filter_var($ex[0], FILTER_SANITIZE_NUMBER_INT);
                $controlsheets = ControlSheet::where('jobcard_id', $jobcard_id)->where('batch_id', $batch_no)->get();
                foreach ($controlsheets as $controlsheet) {
                    if (isset($controlsheet->id)) {
                        $schedules = ScheduleModel::where('controlsheet_id', $controlsheet->id)->get();
                        foreach ($schedules as $schedule) {
                            if (isset($schedule->id)) {
                                $num = (int) filter_var($data['qty'], FILTER_SANITIZE_NUMBER_INT);
                                $quoteitems = $schedule->pipe->quoteitems;
                                $dataObj['quote'] = $quoteitems->quote->id;
                                $dataObj['batch'] = $controlsheet->batch_id;
                                $dataObj['qty'] = $num;
                                $dataObj['length'] = $quoteitems->unitlength;
                                $dataObj['pn'] = $quoteitems->product->PNRating->name;
                                $dataObj['product'] = $quoteitems->product->Diameter->name;
                                $dataObj['sdr'] = $quoteitems->product->PNRating->sdr;
                                $dataObj['unitprice'] = $quoteitems->unitprice;
                                $dataObj['totalamount'] = $quoteitems->unitprice * $num;
                                $dataObj['date'] = $schedule->pipe->start_date;
//                                trace_log($dataObj['batch']);
                            } else {
                                //Do not do a data fill and skip the rest of loop
                                //if batch does not match criteria
                                continue;
                            }
                        }
                    } else {
                        //Do not do a data fill and skip the rest of loop
                        //if batch does not match criteria
                        continue;
                    }
                }
                if (!empty($dataObj)) {
                    $pipeprice = new Pipeprice();
                    $pipeprice->fill($dataObj);
                    $pipeprice->save();
                    //Reset array for next row
                    $dataObj = [];
                }
            }
        }
    }
}
