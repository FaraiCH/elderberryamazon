<?php namespace Bt\Logistics\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\JobCardBatch;
use Bt\Production\Models\Schedule as ScheduleModel;

/**
 * Pipeprice Backend Controller
 */
class Pipeprice extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.ImportExportController',
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Logistics', 'logistics', 'pipeprice');
    }

    public function formAfterSave($model)
    {

        $job_batch = JobCardBatch::find($model->batch_id);
        if (isset($job_batch->id)) {
            $controlsheets = ControlSheet::where('jobcard_id', $job_batch->jobcard_id)
                ->get();
            foreach ($controlsheets as $controlsheet) {
                if (isset($controlsheet->id)) {
                    $schedules = ScheduleModel::where('controlsheet_id', $controlsheet->id)->get();
                    if (!empty($schedules)) {
                        foreach ($schedules as $schedule) {
                            if (isset($schedule->id)) {
                                $quoteitems = $schedule->pipe->quoteitems;
                                $model->unitsproduce = $schedules->sum('total_units_passed_qc');
                                $model->quote = $quoteitems->quote->id;
                                $model->length = $quoteitems->unitlength;
                                $model->pn = $quoteitems->product->PNRating->name;
                                $model->product = $quoteitems->product->Diameter->name;
                                $model->sdr= $quoteitems->product->PNRating->sdr;
                                $model->unitprice = $quoteitems->unitprice;
                                $model->totalamount = $quoteitems->unitprice * $model->qty;
                                $model->totalproduceamount = $quoteitems->unitprice * $schedules->sum('total_units_passed_qc');
                                $model->date = $schedule->pipe->start_date;
                                $model->save();
                            } else {
                                //Do not do a data fill and skip the rest of loop
                                //if batch does not match criteria
                                return false;
                            }
                        }
                    }
                } else {
                    //Do not do a data fill and skip the rest of loop
                    //if batch does not match criteria
                    return false;
                }
            }

            //Reset array for next row
        }
    }
}
