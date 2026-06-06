<?php

namespace Bt\Sales;

use Backend;
use Bt\Sales\FormWidgets\Signature;
use System\Classes\PluginBase;
use Bt\Maintenance\Classes\Upcomingevent;
use Bt\Notify\Controllers\DailyEmail as ctDailyEmail;
use BackendMenu;

/**
 * Sales Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Sales',
            'description' => 'No description provided yet...',
            'author'      => 'Bt',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            $t = new ctDailyEmail;
            $t->onSendSRNDailyNotification();
        })->daily();
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        BackendMenu::registerContextSidenavPartial('Bt.Sales', 'sales', '$/bt/sales/partials/_sidebar.htm');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
    }

    public function registerFormWidgets()
    {
        return [
            Signature::class => 'signature',
            RichTextEditor::class => 'richtexteditor',
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Bt\Sales\Components\Newqoute' => 'BTNewQuote',
            'Bt\Sales\Components\NewqouteV2' => 'BTNewQuoteV2',
            'Bt\Sales\Components\Listquote' => 'BTQuoteList',
            'Bt\Sales\Components\Quoteitem' => 'BTQuoteItem',
            'Bt\Sales\Components\Homedisplay' => 'Homedisplay',
            'Bt\Sales\Components\CmCatalogue' => 'CmCatalogue',
            'Bt\Sales\Components\CmSrn' => 'CmSrn',
            'Bt\Sales\Components\CmBtAccount' => 'CmBtAccount',
            'Bt\Sales\Components\Srnnotify' => 'Srnnotify',
            'Bt\Sales\Components\LogisticsSchedule' => 'CmLogisticsSchedule',
            'Bt\Sales\Components\ConcessionForm' => 'CmConcessionForm',
            'Bt\Sales\Components\QuoteApproval' => 'CmQuoteApproval',

        ];
    }

    public function registerReportWidgets()
    {
        return [
//            'Bt\Sales\ReportWidgets\ReportDeliveryDistance' => [
//                'label'   => 'BT Delivery Distance',
//                'context' => 'dashboard',
//                'permissions' => [
//                    'bt.sales.sales',
//                ],
//            ],

        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {


        return [
            'bt.sales.sales' => [
                'tab' => 'Sales',
                'label' => '*Main Sales Tab',
                'order' => 3
            ],
            'bt.sales.quotes' => [
                'tab' => 'Sales',
                'label' => '**BT Sales Quote Side Menu',
                'order' => 4
            ],
            'bt.sales.logiticsignature' => [
                'tab' => 'Sales',
                'label' => 'Logitics Signature'
            ],
            'bt.sales.catalogue' => [
                'tab' => 'Sales',
                'label' => 'BT Sales Catalogue Side Menu'
            ],
            'bt.sales.clientlist' => [
                'tab' => 'Sales',
                'label' => 'BT Sales Client List Menu'
            ],
            'bt.sales.quotestatus' => [
                'tab' => 'Sales',
                'label' => 'BT Sales Quote Status Menu'
            ],
            'bt.sales.priceperkg' => [
                'tab' => 'Sales',
                'label' => 'BT Sales Price per kg Menu'
            ],
            'bt.sales.product' => [
                'tab' => 'Sales',
                'label' => 'BT Sales Product Menu'
            ],
            'bt.sales.supplier' => [
                'tab' => 'Sales',
                'label' => 'BT Catalogue Suppliers'
            ],
            'bt.sales.management' => [
                'tab' => 'Sales',
                'label' => 'Sales Management'
            ],
            'bt.sales.dashboardmanagement' => [
                'tab' => 'Sales',
                'label' => 'Dashbord Sales Management'
            ],
            'bt.sales.person' => [
                'tab' => 'Sales',
                'label' => 'Sales Person'
            ],
            'bt.sales.guest' => [
                'tab' => 'Sales',
                'label' => 'Guest'
            ],

            'bt.sales.secrete' => [
                'tab' => 'Sales',
                'label' => 'Secrete users'
            ],
            'bt.sales.pipeapprove' => [
                'tab' => 'Sales',
                'label' => 'Pipe Request Approval'
            ],
            'bt.sales.srn' => [
                'tab' => 'Sales',
                'label' => 'Main SRN Tab'
            ],
            'bt.sales.fabrication' => [
                'tab' => 'Sales',
                'label' => 'Fabrication'
            ],
            'bt.sales.logisticsapproval' => [
                'tab' => 'Sales',
                'label' => 'Logitics Approval'
            ],


        ];
    }



    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {


        return [
            'sales' => [
                'label'       => 'Sales',
                'url'         => Backend::url('bt/sales/Newquote'),
                'icon'        => 'icon-fax',
                'permissions' => ['bt.sales.sales'],
                'order'       => 103,
                'sideMenu' => [
                    'mydashboard' => [
                        'label'       => 'My Dashboard',
                        'url'         => Backend::url('bt/sales/mydashboard'),
                        'icon'        => 'icon-tachometer',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Quotes',
                        'attributes'  => ['Quotes'],
                    ],
                    'newquote' => [
                        'label'       => 'List',
                        'url'         => Backend::url('bt/sales/Newquote'),
                        'icon'        => 'icon-shopping-cart',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Quotes',
                        'attributes'  => ['Quotes'],
                    ],
                    'calendarplan' => [
                        'label'       => 'Scheduled Calendar',
                        'url'         => Backend::url('bt/sales/deliveryplan/calendarplan'),
                        'icon'        => 'icon-calendar',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],

                    'deliveryplan' => [
                        'label'       => 'Schedule Delivery',
                        'url'         => Backend::url('bt/sales/deliveryplan'),
                        'icon'        => 'icon-calendar-check-o',
                        'counter' => Upcomingevent::getDeliveryTotal(),
                        'permissions' => ['bt.sales.quotes'],
                        'counterLabel' => 'Upcoming schedule in 10 day',
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'stock_order' => [
                        'label'       => 'Available Ordered Notification',
                        'url'         => Backend::url('bt/sales/stockorder'),
                        'icon'        => 'icon-cubes',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'goodsreturn' => [
                        'label'       => 'Goods Returned',
                        'url'         => Backend::url('bt/sales/goodsreturn'),
                        'icon'        => 'icon-truck',
                        'permissions' => ['bt.sales.quotes'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],

                    'backorderclient' => [
                        'label'       => 'Back Orders by Client',
                        'url'         => Backend::url('bt/sales/newquote/backorderclient'),
                        'icon'        => 'icon-history',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Back Orders',
                        'attributes'  => ['Back Orders'],
                        'badge' => "new"
                    ],

                    'catalogue' => [
                        'label'       => 'Catalogue',
                        'url'         => Backend::url('bt/sales/Catalogue'),
                        'icon'        => 'icon-shopping-cart',
                        'permissions' => ['bt.sales.catalogue'],
                        'group'       => 'Quotes',
                        'attributes'  => ['Quotes'],
                    ],

                    //  'quotereponse' => [
                    //     'label'       => 'PO Documents',
                    //     'url'         => Backend::url('bt/sales/quotereponse'),
                    //     'icon'        => 'icon-check',
                    //     'permissions' => ['bt.sales.management'],
                    //     'group'       => 'Quotes',
                    //     'attributes'  => ['Quotes'],
                    // ],

                    'srn' => [
                        'label'       => 'SRN / Stock Delivery / Collection',
                        'url'         => Backend::url('bt/sales/Srn'),
                        'icon'        => 'icon-truck',
                        'permissions' => ['bt.sales.srn'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'fabrication' => [
                        'label'       => 'Fabrication',
                        'url'         => Backend::url('bt/sales/fabrication'),
                        'icon'        => 'icon-refresh',
                        'permissions' => ['bt.sales.fabrication'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'invoice' => [
                        'label'       => 'Invoices',
                        'url'         => Backend::url('bt/sales/invoice'),
                        'icon'        => 'icon-credit-card-alt',
                        'permissions' => ['bt.sales.srn'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'pickslip' => [
                        'label'       => 'Pick Slips',
                        'url'         => Backend::url('bt/sales/pickslip'),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.qc.lab', 'bt.sales.srn'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'tripsheet' => [
                        'label'       => 'Trip Sheet',
                        'url'         => Backend::url('bt/sales/tripsheet'),
                        'icon'        => 'icon-truck',
                        'permissions' => ['bt.sales.srn'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'client' => [
                        'label'       => 'Clients',
                        'url'         => Backend::url('bt/sales/Client'),
                        'icon'        => 'icon-id-badge',
                        'permissions' => ['bt.sales.clientlist'],
                        'group'       => 'Client & Suppliers',
                        'attributes'  => ['Client & Suppliers'],
                    ],
                    'supplier' => [
                        'label'       => 'Suppliers',
                        'url'         => Backend::url('bt/sales/supplier'),
                        'icon'        => 'icon-id-card',
                        'permissions' => ['bt.sales.product'],
                        'group'       => 'Client & Suppliers',
                        'attributes'  => ['Client & Suppliers'],
                    ],
                    'quotestatus' => [
                        'label'       => 'Quote Status',
                        'url'         => Backend::url('bt/sales/QuoteStatus'),
                        'icon'        => 'icon-cogs',
                        'permissions' => ['bt.sales.admin'],
                        'group'       => 'Admin',
                        'attributes'  => ['Admin'],
                    ],
                    'PNRating' => [
                        'label'       => 'PNRating',
                        'url'         => Backend::url('bt/sales/PNRating'),
                        'icon'        => 'icon-money',
                        'permissions' => ['bt.sales.management'],
                        'group'       => 'Admin',
                        'attributes'  => ['Admin'],
                    ],
                    'product' => [
                        'label'       => 'Price Guide',
                        'url'         => Backend::url('bt/sales/product'),
                        'icon'        => 'icon-money',
                        'permissions' => ['bt.sales.management'],
                        'group'       => 'Admin',
                        'attributes'  => ['Admin'],
                    ],

                    'discountitem' => [
                        'label'       => 'Discount Item',
                        'url'         => Backend::url('bt/sales/discountitem'),
                        'icon'        => 'icon-money',
                        'permissions' => ['bt.sales.management'],
                        'group'       => 'Admin',
                        'attributes'  => ['Admin'],
                    ],
                    'category' => [
                        'label'       => 'Catalogue Categories',
                        'url'         => Backend::url('bt/sales/category'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.sales.sales'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                    'reasonforreturn' => [
                        'label'       => 'Reasons For Returns',
                        'url'         => Backend::url('bt/sales/reasonforreturn'),
                        'icon'        => 'oc-icon-file-text-o',
                        'permissions' => ['bt.sales.quotes'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                    'clientcategory' => [
                        'label'       => 'Client Category',
                        'url'         => Backend::url('bt/sales/clientcategory'),
                        'icon'        => 'icon-cubes',
                        'permissions' => ['bt.sales.clientlist'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],




                    'transportfee' => [
                        'label'       => 'Transport Rates Overview',
                        'url'         => Backend::url('bt/sales/transportfee'),
                        'icon'        => 'icon-cc-visa',
                        'permissions' => ['bt.sales.quotes'],
                        'group'       => 'Quotes',
                        'attributes'  => ['Quotes'],
                    ],

                    'quoteitems' => [
                        'label'       => 'Quote Margins',
                        'url'         => Backend::url('bt/sales/quoteitems'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                    ],
                    'customersurvey' => [
                        'label'       => 'Customer Survey',
                        'url'         => Backend::url('bt/sales/newquote/customersurvey'),
                        'icon'        => 'icon-pencil',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                    ],
                    'purchase' => [
                        'label'       => 'Purchase Order',
                        'url'         => Backend::url('bt/sales/purchase'),
                        'icon'        => 'icon-credit-card-alt',
                        'permissions' => ['bt.sales.secrete'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                    ],
                    'piperequest' => [
                        'label'       => 'Request Pipes',
                        'url'         => Backend::url('bt/sales/piperequest'),
                        'icon'        => 'icon-exchange',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                    ],
                    'quote_over' => [
                        'label'       => 'Quote Overview',
                        'url'         => Backend::url('bt/sales/newquote/quote_overview'),
                        'icon'        => 'icon-calendar-times-o',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                    ],

                    'clientcategorytarget' => [
                        'label'       => 'Monthly Target',
                        'url'         => Backend::url('bt/sales/clientcategorytarget'),
                        'icon'        => 'icon-cubes',
                        'permissions' => ['bt.sales.clientlist'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                    ],
                    'QuoteProductionPlanoverview' => [
                        'label'       => 'Quote Production Plan / Overview',
                        'url'         => Backend::url('bt/sales/QuoteProductionPlan/overview'),
                        'icon'        => 'icon-history',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                        'badge' => "new"
                    ],
                    'QuoteProductionPlan' => [
                        'label'       => 'Quote Production Plan / List',
                        'url'         => Backend::url('bt/sales/QuoteProductionPlan'),
                        'icon'        => 'icon-history',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                        'badge' => "new"
                    ],
                    'backorderbydelivery' => [
                        'label'       => '*** Back Orders',
                        'url'         => Backend::url('bt/sales/newquote/backorderbydelivery'),
                        'icon'        => 'icon-history',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                        'badge' => "new"
                    ],
                    'backorders' => [
                        'label'       => 'Back Orders by Production',
                        'url'         => Backend::url('bt/sales/newquote/backorders'),
                        'icon'        => 'icon-history',
                        'permissions' => ['bt.sales.*'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                        'badge' => "new"
                    ],
                    'srnocr' => [
                        'label'       => 'Document Scans',
                        'url'         => Backend::url('bt/sales/salesocr'),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.sales.srn'],
                        'group'       => 'Other',
                        'attributes'  => ['Other'],
                    ],

                ],
            ],
        ];
    }
}
