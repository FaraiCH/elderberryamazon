<?php namespace Bt\PLCommon\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * InputBigNumber Form Widget
 */
class InputBigNumber extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'inputbignumber';

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
        return $this->makePartial('inputbignumber');
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
        $this->addCss('css/inputbignumber.css', 'RW.PLCommon');
        $this->addJs('js/inputbignumber.js', 'RW.PLCommon');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        $str = $value;
        $pattern = "/\s|R|,/i";
        $value = preg_replace($pattern, "", $str); // Outputs "Visit W3Schools!"
        return $value;
    
    }
}
