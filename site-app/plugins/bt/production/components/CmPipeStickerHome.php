<?php namespace Bt\Production\Components;

use Bt\Production\Models\PrintSticker;
use Cms\Classes\ComponentBase;
use Bt\Production\Models\Pipestickeritem as ModelPipestickeritem;
use Input;
use Redirect;

/**
 * CmPipeStickerHome Component
 */
class CmPipeStickerHome extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'CmPipeStickerHome Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'printitem' => [
                'title'       => 'Property PrintItem',
                'description' => 'Slug for business item',
                'default'     => '{{ :printitem }}',
                'type'        => 'string'
            ],
        ];
    }
    public function onRun(){
        $this->loadAssets();
        $sticker_id = $this->property('printitem');
        $stickeritem = ModelPipestickeritem::find($sticker_id);
        $this->page['printitem'] = $stickeritem;
        $this->page['allstickers'] = PrintSticker::orderBy('id', 'desc')->get();
    }
     public function loadAssets()
    {
        $this->addCss('assets/css/sticker.css', 'Bt.Production');
        $this->addCss("/plugins/bt/reporting/assets/css/backlaout.css", "1.0.0");
    }
    public function onSearch(){
        if(Input::has('stickerparent') && Input::has('stickerchild') && Input::get('stickerparent') > 0 &&  Input::get('stickerchild') > 0){
            $sticker = ModelPipestickeritem::where('counter', Input::get('stickerchild'))->where('sticker_id', Input::get('stickerparent'))->first();
            if(!empty($sticker)){

               \Flash::success("Sticker found...");
                $url = $this->controller->pageUrl('stickers/stickerlanding',[':printid'=>$sticker->sticker_id,':pipestickeid'=>$sticker->counter]);

                return Redirect::to($url);

            }else{
                \Flash::error('Sticker not found, please search again');
            }
        }else{
             \Flash::error('Please enter sticker number');
        }
    }
}
