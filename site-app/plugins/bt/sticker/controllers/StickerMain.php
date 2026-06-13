<?php namespace Bt\Sticker\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\ControlSheet;
use Bt\Sticker\Traits\AjaxFunctions;
use Bt\Sticker\Traits\StickerAssetControls;
use FontLib\Table\Type\post;
use Redirect;
use Input;
/**
 * Sticker Main Backend Controller
 */
class StickerMain extends Controller
{
    //Use this trait to create reusable control assets
    use StickerAssetControls, AjaxFunctions;

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

        BackendMenu::setContext('Bt.Sticker', 'sticker', 'stickermain');
    }

    public function index()
    {
        $this->pageTitle = "Control Sheet Setup";
        BackendMenu::setContext('Bt.Sticker', 'sticker', 'stickermain');

        $this->vars['controlsheet_dropdown'] =  $this->ControlSheetAjax('onControlSheet');
        $this->vars['button'] =  $this->ButtonAjax('onSubmitControlSheet', 'Setup Stickers');
    }

    public function onControlSheet() : array
    {
        // Create the response for the Ajax Call by the ControlSheet
        return $this->AjaxSearch(ControlSheet::class, Input::get('q'));
    }

    public function onSubmitControlSheet()
    {
        // Go to the Sticker Page with the Control Sheet Number if Validated
        if(Input::get('controlsheet') > 1)
        {
            return Redirect::to('/admin/bt/sticker/stickermain/production/'. Input::get('controlsheet'));
        }
        else
        {
            \Flash::error('Please input the correct Control Sheet');
        }
    }

    public function production(string $id)
    {
        $this->addJs('/plugins/bt/sticker/assets/js/controls.js', '1.0.0');
        $this->pageTitle = "Production Stickers";
        $controlSheet = ControlSheet::find($id);
        $this->vars['controlsheet_id'] = $id;
        $this->vars['sticker_no'] = $this->StickerNoAjax('onStickerSearch','sticker1', 'sticker2',null,null,'First No', 'Second No');
        $this->vars['weight_input'] = $this->StickerInputAjax('onGetWeight', 'weight', $controlSheet->standardweight);
        $this->vars['length_input'] = $this->StickerInputAjax('onGetLength', 'length', $controlSheet->pipelenght);
        $this->vars['button'] = $this->ButtonAjax('onStickerSubmit', 'Save');
    }

    public function onStickerSearch()
    {
        trace_log(post());
    }

    public function onGetWeight()
    {

    }

    public function onGetLength()
    {

    }
}
