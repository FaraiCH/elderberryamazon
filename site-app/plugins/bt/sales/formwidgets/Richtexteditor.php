<?php namespace Bt\Sales\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * Richtexteditor Form Widget
 */
class Richtexteditor extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'bt_sales_richtexteditor';

    /**
     * 
     */
    public function widgetDetails()
    {
        return [
            'name' => 'Rich Text Editor',
            'description' => 'A WYSIWYG editor for rich text content.',
        ];
    }

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
        return $this->makePartial('richtexteditor');
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
        $this->addCss('css/richtexteditor.css', 'bt.sales');
        $this->addJs('js/richtexteditor.js', 'bt.sales');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
