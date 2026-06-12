<?php namespace Bt\Operator\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\ControlSheet;
use Bt\Production\Models\Pipestickeritem;
use Bt\Production\Models\PrintStickerItems;
use Bt\Production\Models\QCStatus;
use FontLib\Table\Type\post;

/**
 * Stickers Backend Controller
 */
class Stickers extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Operator', 'operator', 'stickers');
    }

    public function setup(){
        $this->pageTitle = "Pipe Stickers";
        $controlsheetId = \Request::segment(6);
        if($controlsheetId > 0)
        {
            $controlsheetObj = ControlSheet::find($controlsheetId);

            $this->vars['controlsheet_id'] = $controlsheetId;
            $this->vars['controlsheetObj'] = $controlsheetObj;
            $this->vars['stickers'] = Pipestickeritem::where('controlsheet_id', $controlsheetId)->orderBy('sticker_id', 'desc')->orderBy('counter', 'desc')->get();
        }
        $this->addCss('/plugins/bt/operator/assets/css/style.css', "1.0.0");
        $this->addCss("/plugins/bt/sales/assets/css/dataTables.bootstrap5.min.css", "1.0.0");

        $this->addJs("/plugins/bt/operator/assets/js/main.js", "1.0.0");
        $this->addJs("/plugins/bt/sales/assets/js/datatables.min.js", "1.0.0");
    }

    public function onSelectControl(){
        if(\Input::has('controlsheet') && \Input::get('controlsheet') > 0){
           return \Redirect::to('/backend/bt/operator/stickers/setup/'.\Input::get('controlsheet'));
        }

    }

    public function onEditList(){
        $stickerObj = Pipestickeritem::where('sticker_id', \Input::get('sticker_id'))
            ->where('counter', \Input::get('counter'))->first();
        $qcstatus = QCStatus::all();
        return[
            '#stickerlist_' . $stickerObj->id => $this->makePartial('edit_sticker', ['stickerObj' => $stickerObj, 'qcstatus' => $qcstatus, 'stickerCount' => \Input::get('stickerCount')])
        ];
    }

    public function onSaveStickerEdit(){
        if(\Input::has('hidden_id') && \Input::get('hidden_id') > 0){
            $oldStickerObj = Pipestickeritem::where('sticker_id', \Input::get('hidden_id'))
                ->where('counter', \Input::get('hidden_counter'))->first();
            $oldStickerObj->controlsheet_id = null;
            $oldStickerObj->unit_length = null;
            $oldStickerObj->weight = null;
            $oldStickerObj->is_scrap = null;
            $oldStickerObj->qcstatus_id = null;
            $oldStickerObj->fail_pic = null;
            $oldStickerObj->product_id = null;
            $oldStickerObj->unit_price = null;
            $oldStickerObj->rand_per_kg = null;
            $oldStickerObj->save();
        }

        $stickerObj = Pipestickeritem::where('sticker_id', \Input::get('sticker_id'))
            ->where('counter', \Input::get('counter'))->first();

        if(!empty($stickerObj)){
            if((\Input::has('sticker_id') && \Input::get('sticker_id') > 0) && (\Input::has('counter') && \Input::get('counter') > 0)){
                $stickerObj->sticker_id = \Input::get('sticker_id');
                $stickerObj->counter = \Input::get('counter');
            }else{
                return \Flash::error('Please insert the full sticker number');
            }
            if(\Input::has('controlsheet') && \Input::get('controlsheet') > 0){
                $stickerObj->controlsheet_id = \Input::get('controlsheet');
                $controlsheet = ControlSheet::find(\Input::get('controlsheet'));
                if(!empty($controlsheet)){
                    $stickerObj->product_id = $controlsheet->jobcard->pipe->quoteitems->product_id;
                    $stickerObj->unit_price = $controlsheet->jobcard->pipe->quoteitems->unitprice;
                    $stickerObj->rand_per_kg = $controlsheet->jobcard->pipe->quoteitems->priceperkg;
                }
            }
            if(\Input::has('unit_length') && \Input::get('unit_length') > 0){
                $stickerObj->unit_length = \Input::get('unit_length');
            }
            if(\Input::has('unit_weight') && \Input::get('unit_weight') > 0){
                $stickerObj->weight = \Input::get('unit_weight');
            }
            if(\Input::has('is_scrap') && \Input::get('is_scrap') > 0){
                $stickerObj->is_scrap = \Input::get('is_scrap');
            }else{
                $stickerObj->is_scrap = 0;
            }
            if(\Input::has('qcstatus') && \Input::get('qcstatus') > 0){
                $stickerObj->qcstatus_id = \Input::get('qcstatus');
            }
            if(\Input::has('fail_pic') && \Input::get('fail_pic')){
                $stickerObj->fail_pic = \Input::file('fail_pic');
            }

            $stickerObj->save();
        }else{
            return  \Redirect::refresh();
        }

        return  \Redirect::refresh();
    }

    public function onCheckQcStatus(){
        if(\Input::get('qcstatus') == 2){
            return[
                '#fail_pic' => $this->makePartial('fail_pic')
            ];
        }
    }

    public function onCheckNum(){
        $sticker = Pipestickeritem::where('sticker_id', \Input::get('sticker_id'))->where('counter', \Input::get('counter'))->first();
        return[
            '#sticker_no_' => $this->makePartial('sticker_status', ['sticker' => $sticker])
        ];
    }

    public function onSearchControlSheet(){
        if(\Input::has('q') && \Input::get('q') > 0){
            $controlsheet  = ControlSheet::find(\Input::get('q'));
            if(isset($controlsheet->id)){
                if(isset($controlsheet->jobcard->pipe->quoteitems->quote_id)){
                    $results = [
                        $controlsheet->id => "CS#" . $controlsheet->id . " JB#" . $controlsheet->jobcard_id . "-" . $controlsheet->batch_id . " QUOTE#" . $controlsheet->jobcard->pipe->quoteitems->quote_id . " (" . $controlsheet->jobcard->pipe->quoteitems->quote->company_name. ")"
                    ];
                    return ['result' => $results];
                }

            }else{
                return ['result' => ['text' => 'No Results']];
            }

        }
    }
}
