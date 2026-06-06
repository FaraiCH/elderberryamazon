<?php namespace Bt\PLCommon\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * LightstoneSelector Form Widget
 */
class LightstoneSelector extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'rw_plcommon_lightstone_selector';

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
        return $this->makePartial('lightstoneselector');
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
        $this->addCss('css/lightstoneselector.css', 'RW.PLCommon');
        $this->addJs('js/lightstoneselector.js', 'RW.PLCommon');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
