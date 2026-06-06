<?php namespace Bt\Sticker\Traits;

trait StickerAssetControls
{
    /**
     * ControlSheetAjax is a control sheet dropdown control that uses ajax to make a backend call.
     * To use this function, provide the name of the function to trigger as the parameter.
     * You need to call or declare the same function called on the same file you declared ControlSheetAjax.
     */
    public function ControlSheetAjax($call = null) : string
    {
        return '<div class="form-group"  style="text-align: center">
                <select name="controlsheet" id="controlsheet" class="custom-select" data-handler="'.$call.'" data-minimum-input-length="1" >
                    <option value="">-- Select Control Sheet</option>
                </select>
            </div>';
    }
    /**
     * This button is an Ajax submit button that handles a dynamic request and response from the server
     * You can provide the Ajax handle as well as the text of the button
     */
    public function ButtonAjax($call = null, $buttonText = null) : string
    {
        return '<div style="text-align: center">
                <button type="submit" class="btn btn-primary" data-request="' .$call. '">'. $buttonText .'</button>
            </div>';
    }

    /**
     * This button is an Ajax submit button that handles a dynamic request and response from the server
     */
    public function StickerNoAjax($call = null, $name = null, $name2 = null, $value = null, $value2 = null, $hint = null, $hint2 = null) : string
    {
        return '<div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-xs-6">
                        <input style="text-align: center" data-track-input="" data-request="'. $call.'" type="number"  name="'.$name.'" value="'.$value.'"  class="form-control" placeholder="'.$hint.'" />
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-xs-6">
                        <input style="text-align: center" data-track-input="" data-request="'. $call.'" type="number" name="'.$name2.'" value="'.$value2.'"  class="form-control" placeholder="'.$hint2.'" />
                    </div>
                </div>
               ';
    }

    public function StickerInputAjax($call = null, $name = null, $value = null) : string
    {
        return '<div class="text-center">
                    <input style="text-align: center" data-track-input="" data-request="'. $call.'" type="number" name="'.$name.'" value="'.$value.'" id="'.$name.'" class="form-control" />
                </div>
                   ';
    }
}
