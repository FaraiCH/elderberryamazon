<?php namespace Bt\PLCommon\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * InputCurrency Form Widget
 */
class InputCurrency extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'inputcurrency';

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
        return $this->makePartial('inputcurrency');
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
        $this->addCss('css/inputcurrency.css', 'RW.PLCommon');
        $this->addJs('js/inputcurrency.js', 'RW.PLCommon');
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
