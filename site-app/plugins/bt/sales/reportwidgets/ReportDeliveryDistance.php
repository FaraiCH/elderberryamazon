<?php namespace Bt\Sales\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\Product;
use Exception;

/**
 * ReportDeliveryDistance Report Widget
 */
class ReportDeliveryDistance extends ReportWidgetBase
{
    /**
     * @var string The default alias to use for this widget
     */
    protected $defaultAlias = 'ReportDeliveryDistanceReportWidget';

    /**
     * Defines the widget's properties
     * @return array
     */
    public function defineProperties()
    {
        return [
            'title' => [
                'title'             => 'backend::lang.dashboard.widget_title_label',
                'default'           => 'Report Delivery Distance Report Widget',
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error',
            ],
        ];
    }
    
    /**
     * Adds widget specific asset files. Use $this->addJs() and $this->addCss()
     * to register new assets to include on the page.
     * @return void
     */
    protected function loadAssets()
    {
    }
    
    /**
     * Renders the widget's primary contents.
     * @return string HTML markup supplied by this widget.
     */
    public function render()
    {
        try {
            $this->prepareVars();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        $obj = Quoteitems::all();
        $objProduct = Product::all();


        $this->vars['totaldistance'] = $obj->sum("unitlength");
        $this->vars['totalunits'] = $obj->sum("units");
        $this->vars['totalweight'] = $obj->sum("totalweight");

        $top = array();
        foreach ($objProduct as $key => $value) {
            if(isset($top[$value->PNRating->name]))
                $top[$value->PNRating->name] += $value->quoteitem->sum("unitlength");
            else
                $top[$value->PNRating->name] = $value->quoteitem->sum("unitlength");
        }

         $this->vars['top'] = $top;


        return $this->makePartial('reportdeliverydistance');
    }

    /**
     * Prepares the report widget view data
     */
    public function prepareVars()
    {
    }
}
