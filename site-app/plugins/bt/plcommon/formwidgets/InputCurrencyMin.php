<?php namespace Bt\PLCommon\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * InputCurrencyMin Form Widget
 */
class InputCurrencyMin extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'inputcurrencymin';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('inputcurrencymin');
    }

    /**
     * prepareVars for view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/inputcurrencymin.css', 'RW.PLCommon');
        $this->addJs('js/inputcurrencymin.js', 'RW.PLCommon');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        if($value){
            $str = $value;
            $pattern = "/\s|R|,/i";
            $value = preg_replace($pattern, "", $str); // Outputs "Visit W3Schools!"    
        }else{
            $value = 0;
        }
        
        return $value;
    }
}
