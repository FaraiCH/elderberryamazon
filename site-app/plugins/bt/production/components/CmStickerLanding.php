<?php

namespace Bt\Production\Components;

use Bt\Logistics\Models\Binarea;
use Bt\Production\Controllers\Pipe;
use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\JobCardBatch;
use Bt\Production\Models\Pipestickeritem as PipeSticker;
use Bt\Production\Models\PrintSticker;
use Bt\Production\Models\QCStatus;
use Bt\Qc\Models\Qcreason;
use Bt\Sales\Models\Pickslip;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\Srn;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Flash;
use RainLab\User\Facades\Auth;
use function PHPUnit\Framework\assertStringContainsStringIgnoringCase;
use Session;
use Input;
use Request;

/**
 * CmStickerLanding Component
 */
class CmStickerLanding extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'cmStickerLanding Component',
            'description' => 'No description provided yet...'
        ];
    }

    public $item = "";
    public $qcstatus = "";
    public $binarea = "";
    public $controlsheet = "";
    public $reason = "";
    public $pickslip = "";
    public $userDetails = "";

    /**
     * wall thickness min
     * @var string
     */
    public string $wallThicknessMin;

    /**
     * wall thickness max
     * @var string
     */
    public string $wallThicknessMax;

    /**
     * standard wall thickness min
     * @var string
     */
    public string $standardWallThicknessMin;

    /**
     * standard wall thickness max
     * @var string
     */
    public string $standardWallThicknessMax;

    public function defineProperties()
    {
        return [
            'printid' => [
                'title'       => 'Property controlsheet_id',
                'description' => 'Slug for business item',
                'default'     => '{{ :printid }}',
                'type'        => 'string'
            ],
            'pipestickeid' => [
                'title'       => 'Property sticker_id',
                'description' => 'Slug for business item',
                'default'     => '{{ :pipestickeid }}',
                'type'        => 'string'
            ],

        ];
    }

    public function loadAssets()
    {
        $this->addCss('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', 'Bt.Production');
        $this->addCss('assets/css/sticker.css', 'Bt.Production');
        $this->addCss('assets/css/select2.css', 'Bt.Production');
        $this->addJs('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', 'Bt.Production');
        $this->addJs('assets/js/select2.js', 'Bt.Production');
        $this->addJs('assets/js/sticker/ajax_search.js', 'Bt.Production');
        $this->addJs('assets/js/sticker/sticker.js', 'Bt.Production');
    }
    public function init()
    {
        $this->loadAssets();
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');


        $this->item = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
        $this->userDetails = Auth::getUser();
        if (empty($this->userDetails)) {
            return \Redirect::to('/pipestickers/invalid');
        }

        if(optional($this->item)->controlsheets) {
            // get wall thickness min from db
            $this->wallThicknessMin = optional($this->item)->wall_thickness_min ?? '';

            // get wall thickness max from db
            $this->wallThicknessMax = optional($this->item)->wall_thickness_max ?? '';

            // get standard wall thickness min from db
            $this->standardWallThicknessMin = optional($this->item->controlsheets)->minwall ?? '';

            // get standard wall thickness max from db
            $this->standardWallThicknessMax = optional($this->item->controlsheets)->maxwall ?? '';
        }

        $this->qcstatus = QCStatus::all();
        $this->binarea = Binarea::all();
        $this->reason = Qcreason::all();
        $current = Carbon::now();
        $this->pickslip = Pickslip::where('created_at', '>', $current->addDays(-60))->orderBy('id', 'desc')->get();
        $current = Carbon::now();
        $this->srn = Srn::where('created_at', '>', $current->addDays(-10))->orderBy('id', 'desc')->get();
        $current = Carbon::now();
        $this->controlsheet = ControlSheet::where('created_at', '>', '2023-10-01')
            ->orWhere('opendate', Carbon::today())->where('active', 0)->orderby('id', 'desc')->orderby('jobcard_id', "desc")->get();
    }

    public function onQC()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
        $qcstate = Input::get('qcstatus');
        $status = QCStatus::find($qcstate);
        $qcreason = Input::get('qcreason');

        $wallThicknessMin = Input::get('wall-thickness-min');
        $wallThicknessMax = Input::get('wall-thickness-max');

        if (!empty($status)) {
            $sticker->qcstatus_id = $status->id;
            if (!empty($qcreason)) {
                $sticker->reason_id = $qcreason;
            } else {
                $sticker->reason_id = null;
            }

            if (Input::has('fail_pic')) {
                $sticker->fail_pic = Input::file('fail_pic');
            }

            if($wallThicknessMin) {
                $sticker->wall_thickness_min = $wallThicknessMin;
            }

            if($wallThicknessMax) {
                $sticker->wall_thickness_max = $wallThicknessMax;
            }

            $sticker->qc_updated_by_id = Auth::getUser()->id;
            $sticker->save();
            \Flash::success('Saved');
            return  \Redirect::refresh();
        }
    }
    public function onBin()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
        $binarea = Input::get('binarea');
        $status = Binarea::find($binarea);
        if (!empty($status)) {
            $sticker->binarea_id = $status->id;
        }
        if (!empty($weight)) {
            $sticker->weight = $weight;
        }

        $sticker->save();
        \Flash::success('Saved');
        return  \Redirect::refresh();
    }

    public function onSaveControl()
    {

        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');

        if (Input::has('cs') && Input::get('cs') > 0) {
            $cs_id = Input::get('cs');
            $mycontolsheet = ControlSheet::find($cs_id);
            $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();

            if (!empty($sticker)) {
                $sticker->controlsheet_id = $cs_id;
                
                if (!empty($mycontolsheet)&& $mycontolsheet->jobcard && $mycontolsheet->jobcard->pipe && $mycontolsheet->jobcard->pipe->quoteitems) {
                    $sticker->product_id = $mycontolsheet->jobcard->pipe->quoteitems->product_id;
                    $sticker->unit_price = $mycontolsheet->jobcard->pipe->quoteitems->unitprice;
                    $sticker->rand_per_kg = $mycontolsheet->jobcard->pipe->quoteitems->priceperkg;
                    $sticker->quote_item_id = $mycontolsheet->jobcard->pipe->quoteitems->id;

                    $jobcard_id = $mycontolsheet->jobcard->id;
                    $batch = JobCardBatch::where('jobcard_id', $jobcard_id)->first();

                    if ($batch) {
                        $sticker->batch_id = $batch->id;
                    }
                }

                if ($sticker->is_scrap == 1) {
                    #Validate Scrap
                    #Require weight
                    if (Input::has('weight') && Input::get('weight') > 0) {
                        $sticker->weight = Input::get('weight');
                        if (Input::has('weight_pic')) {
                            $sticker->weight_pic = Input::file('weight_pic');
                        }
                        if ((Input::has('length') && Input::get('length') > 0)) {
                            $sticker->unit_length = Input::get('length');
                        }
                        
                        $sticker->save();
                        return \Redirect::refresh();
                    } else {
                        \Flash::error('Please Add Weight');
                    }
                } else {

                    #Validate standard weight
                    $mycontolsheet = ControlSheet::find($cs_id);
                    $sticker->weight = Input::get('weight');
                    if (Input::has('weight_pic')) {
                        $sticker->weight_pic = Input::file('weight_pic');
                    }
                    if ((Input::has('length') && Input::get('length') > 0)) {
                        $sticker->unit_length = Input::get('length');
                    }
                    // if (!empty($mycontolsheet)) {
                    //     $sticker->product_id = $mycontolsheet->jobcard->pipe->quoteitems->product_id;
                    //     $sticker->unit_price = $mycontolsheet->jobcard->pipe->quoteitems->unitprice;
                    //     $sticker->rand_per_kg = $mycontolsheet->jobcard->pipe->quoteitems->priceperkg;
                    // }
                    $sticker->prod_updated_by_id =  Auth::getUser()->id;
                    $sticker->sticker_scanned_date = now();
                    $sticker->save();
                    return \Redirect::refresh();
                }
            } else {
                \Flash::error('Control sheet not found');
            }
        } else {
            \Flash::error('Please select control sheet');
        }
    }

    public function onLoader()
    {
        $qcstatus_id = Input::get('qcstatus');
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        $this->reason = Qcreason::all();
        $this->item = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();

        if (!empty($qcstatus_id)) {
            if ($qcstatus_id == 2 || $qcstatus_id == 3) {
                return [
                    '#reason' => $this->renderPartial('@reason_partial.htm', ['status' => Input::get('qcstatus')])
                ];
            } else {
                return [
                    '#reason' => $this->renderPartial('@end_partial.htm')
                ];
            }
        }
    }

    public function onPickSlip()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        $save = 0;
        if (Input::has('pickslip') && Input::get('pickslip') > 0) {



            $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
            if (!empty($sticker)) {
                $sticker->pickslip_id = Input::get('pickslip');
                $save = 1;

                $sticker->save();
                return \Redirect::refresh();

                # Check if in quote
                $quoteitems = $sticker->controlsheets->jobcard->pipe->qpush->quote->items;
                if (!empty($quoteitems)) {
                    foreach ($quoteitems as $item) {
                        if ($item->product_id == $sticker->product_id) {
                            #Check if max pickslip
                            #Make sure that even if Sales add the same pipe again in the quote, it is still counted
                            $pipisticker = PipeSticker::where('pickslip_id', Input::get('pickslip'))->where('product_id', $sticker->product_id)->get();
                            $quoteitemcount = Quoteitems::where('product_id', $sticker->product_id)->where("quote_id", $sticker->controlsheets->jobcard->pipe->qpush->quote_id)->get();
                            if ($pipisticker->count() <= $quoteitemcount->sum('units')) {
                                $sticker->pickslip_id = Input::get('pickslip');
                                $save = 1;
                                \Flash::success("Sticker Units " . $pipisticker->count() . " Q Units " . $quoteitemcount->sum('units'));
                            } else {
                                \Flash::error("Units are full");
                            }
                        }
                    }
                    if ($save == 1) {
                        $sticker->save();
                        return \Redirect::refresh();
                    } else {
                        \Flash::error("It did not save");
                    }
                } else {
                    \Flash::error("Quote has no items");
                }
            }
        }
    }

    public function onRelease()
    {
        $release = \Input::get('release');
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
        if ($release == 1) {
            $sticker->release_date = Carbon::now();
            $sticker->save();
            return \Redirect::refresh();
        }
    }

    public function onRemovePick()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
        if (!empty($sticker)) {
            $sticker->pickslip_id = null;
            $sticker->dispatch_date = null;
            $sticker->save();
            return \Redirect::refresh();
        }
    }

    //Find in Scrap Select
    public function onConfirmScrap()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        if (Input::has('scrap') && Input::get('scrap') > 0) {
            $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
            if (!empty($sticker)) {
                $sticker->is_scrap = Input::get('scrap');
                $sticker->save();
                return [
                    '#weight_part' => $this->renderPartial('@weight_partial.htm', ['printpipe' => $sticker])
                ];
            }
        }
    }

    //Find in Control Sheet Select
    public function onSetLength()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        if (Input::has('cs') && Input::get('cs') > 0) {
            $control = ControlSheet::find(Input::get('cs'));
            if (!empty($control)) {
                return [
                    '#length' => $this->renderPartial('@length_partial.htm', ['control' => $control])
                ];
            }
        }
    }

    public  function onCompare()
    {
        /** check here */
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        $control = ControlSheet::find(Input::get('cs'));
        $standardWight = 0;
        if (Input::has('weight') && Input::get('weight') > 0) {
            $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
            if (!empty($sticker)) {
                //$compare item and quote lengths
                $item_length = $control->jobcard->pipe->quoteitems->unitlength;
                $sticker_length = $sticker->unit_length;
                if ($item_length != $sticker_length) {
                    if (Input::has('length') && Input::get('length') > 0) {
                        $standardWight = Input::get('length') * $control->jobcard->pipe->quoteitems->product->production_value;
                    }
                } else {
                    $standardWight = $control->standardweight;
                }
                return [
                    '#result' => $this->renderPartial('@weight_result.htm', ['itemweight' => Input::get('weight'), 'standardweight' => $standardWight, 'sticker' => $sticker])
                ];
            }
        }
    }

    public function PipeStatsFloor($product_id, $unit_length)
    {
        if (!empty($product_id) && !empty($unit_length)) {
            return PipeSticker::where("product_id", $product_id)->where("unit_length", $unit_length)->doesntHave('srn')->get();
        }
    }

    public  function PipeStatsDelivered($product_id, $unit_length, $quote)
    {
        return PipeSticker::where("product_id", $product_id)->where("unit_length", $unit_length)->Has('srn')->whereHas('pickslip', function ($query) use ($quote) {
            $query->where('quote_id', $quote);
        })->get();
    }

    public function PipeAge($given_date)
    {
        $date = new \DateTime($given_date);
        $now = new \DateTime();
        $interval = $now->diff($date);
        return $interval->days;
    }

    public function onEditControl()
    {
        $controlsheet = ControlSheet::where('created_at', '>', '2023-10-01')->orWhere('opendate', Carbon::today())->where('active', 0)->orderby('id', 'desc')->orderby('jobcard_id', "desc")->get();
        return [
            '#edit_control' => $this->renderPartial("@edit_printmycard.htm", ['controlsheets' => $controlsheet, 'section' => 1])
        ];
    }

    public function onSetNewControl()
    {

        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');

        if (Input::has('new_control_sheet') && Input::get('new_control_sheet') > 0) {
            $controlsheetObj = ControlSheet::find(Input::get('new_control_sheet'));
            $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
            $sticker->controlsheet_id = Input::get('new_control_sheet');
            $sticker->binarea_id = null;
            //$sticker->weight = null;
            $sticker->pickslip = null;
            $sticker->product_id = $controlsheetObj->jobcard->pipe->quoteitems->product_id;
            $sticker->unit_price = $controlsheetObj->jobcard->pipe->quoteitems->unitprice;
            $sticker->rand_per_kg = $controlsheetObj->jobcard->pipe->quoteitems->priceperkg;
            //$sticker->unit_length = null;
            $sticker->qcstatus_id = null;
            $sticker->qcdate = null;
            $sticker->bin_date = null;
            $sticker->reason_id = null;
            $sticker->qc_updated_by_id =  null;
            $sticker->quote_item_id =  null;
            $sticker->prod_updated_by_id =  Auth::getUser()->id;
            $sticker->save();
        }

        return \Redirect::refresh();
    }

    public function onCancelSetNewControl()
    {
        return \Redirect::refresh();
    }

    public function onEditLength()
    {
        return [
            '#edit_length' => $this->renderPartial("@edit_printmycard.htm", ['section' => 2])
        ];
    }

    public function onSaveNewLength()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        if (Input::has('new_length') && Input::get('new_length') > 0) {
            $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
            $sticker->unit_length = Input::get('new_length');
            $sticker->prod_updated_by_id =  Auth::getUser()->id;
            $sticker->save();
        }
        return \Redirect::refresh();
    }

    public function onEditNewBin()
    {
        $bin = Binarea::all();
        return [
            '#edit_bin' => $this->renderPartial("@edit_printmycard.htm", ['binarea' => $bin, 'section' => 3])
        ];
    }

    public function onSaveNewBin()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        if (Input::has('new_binarea') && Input::get('new_binarea') > 0) {
            $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
            $sticker->binarea_id = Input::get('new_binarea');
            $sticker->save();
        }
        return \Redirect::refresh();
    }

    public function onEditWeight()
    {
        return [
            '#edit_weight' => $this->renderPartial("@edit_printmycard.htm", ['section' => 4])
        ];
    }

    public function onSaveNewWeight()
    {
        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        if (Input::has('new_weight') && Input::get('new_weight') > 0) {
            $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();
            $sticker->weight = Input::get('new_weight');
            $sticker->prod_updated_by_id =  Auth::getUser()->id;
            $sticker->save();
        }
        return \Redirect::refresh();
    }

    public function onUpdateUpdatedAtTimestamp()
    {

        $printid = $this->property('printid');
        $pipestickeid = $this->property('pipestickeid');
        $sticker = PipeSticker::where('sticker_id', $printid)->where('counter', $pipestickeid)->first();

        if (!empty($sticker)) {
            $sticker->sticker_scanned_date = now();
            if (Input::has('scannedStatus') && Input::get('scannedStatus') > 0) {
                $sticker->is_active = Input::get('scannedStatus');
            } else {
                $sticker->is_active = 0;
            }
            $sticker->save();
            return \Redirect::refresh();
        }
    }

    /**
     * triggers when reason select input changes
     * @return array
     */
    public function onStickerLandingReason(): array {
        if(Input::get('qcreason') == 2) {
            return ['#wall-thickness' => $this->renderPartial('@wall_thickness_partial')];
        }
        return ['#wall-thickness' => $this->renderPartial('@end_partial.htm')];
    }

    public function onGetControlSheet(){
        $controlObj = [];
        trace_log(post());
        if (Input::has('q') && Input::get('q') != null) {
            $controlsheets = ControlSheet::where('id', 'like', '%' . Input::get('q') . '%')->orWhere('jobcard_id', 'like', '%' . Input::get('q') . '%')->orWhere('batch_id', 'like', '%' . Input::get('q') . '%')->limit(10)->get();
            if (isset($controlsheets)) {
                foreach ($controlsheets as $controlsheet) {
                    $controlObj[] = ['id' => $controlsheet->id, 'text' => 'CS#' . $controlsheet->id . ': JB#' . $controlsheet->jobcard_id . '-' . $controlsheet->batch_id];
                }
                return json_encode($controlObj);
            } else {
                return json_encode(array(array('id' => 0, 'text' => 'No Control Sheet Found')));
            }
        }
    }
}
