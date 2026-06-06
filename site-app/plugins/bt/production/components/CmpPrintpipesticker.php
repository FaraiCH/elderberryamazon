<?php namespace Bt\Production\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Pipestickeritem as ModelPipestickeritem;


use Carbon;
use Backend\Models\User;
use RainLab\User\Models\UserGroup;
use BackendAuth;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;

/**
 * CmpPrintpipesticker Component
 */
class CmpPrintpipesticker extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'CmpPrintpipesticker Component',
            'description' => 'No description provided yet...'
        ];
    }

    public $sticker = "";
    public $appurl = "";
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

    public function onRun()
    {
        $pipestickeid = $this->property('pipestickeid');
        $printid = $this->property('printid');
        if(!empty($pipestickeid)){
            $this->sticker = ModelPipestickeritem::where('counter', $pipestickeid)->where('sticker_id', $printid)->get();
        }else{
            $this->sticker = ModelPipestickeritem::where('sticker_id', $printid)->orderby('counter')->get();
        }
        $this->appurl =  \Config::get('app.url');
    }
}
