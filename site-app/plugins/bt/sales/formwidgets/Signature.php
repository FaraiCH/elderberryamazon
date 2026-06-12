<?php namespace Bt\Sales\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * signature Form Widget
 */
class Signature extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'signature';

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
        return $this->makePartial('signature');
    }

    /**
     * prepareVars for view data
     */
    public function prepareVars()
    {
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
//    public function loadAssets()
//    {
//        $this->addCss('css/signature.css', 'bt.sales');
//        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2-base/styles/material.css', "bt.plcommon");
//        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2-inputs/styles/material.css', "bt.plcommon");
//        $this->addJs('js/signature.js', 'bt.sales');
//        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2-base/dist/global/ej2-base.min.js', "bt.plcommon");
//        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2-inputs/dist/global/ej2-inputs.min.js', "bt.plcommon");
//    }
    public function loadAssets()
    {
        $this->addCss('css/signature.css', 'bt.sales');
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2-base/styles/material.css', "bt.plcommon");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2-inputs/styles/material.css', "bt.plcommon");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");

        $this->addJs('js/signature.js', 'bt.sales');
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2-base/dist/global/ej2-base.min.js', "bt.plcommon");
        $this->addJs('https://cdn.syncfusion.com/ej2/20.3.56/ej2-inputs/dist/global/ej2-inputs.min.js', "1.0.0");
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }

    public function onSupper(){
        \Flash::success("It's done");
    }

}


