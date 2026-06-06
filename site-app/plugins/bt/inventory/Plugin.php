<?php namespace Bt\Inventory;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;

/**
 * Inventory Plugin Information File
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
            'name'        => 'Inventory',
            'description' => 'No description provided yet...',
            'author'      => 'Bt',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        BackendMenu::registerContextSidenavPartial('Bt.Inventory', 'inventory', '$/bt/inventory/partials/_sidebar.htm');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Bt\Inventory\Components\PointEntry' => 'BTPointEntry',
            'Bt\Inventory\Components\PointEntryList' => 'BTPointEntryList',
            'Bt\Inventory\Components\PointEntryItem' => 'BTPointEntryItem',
            'Bt\Inventory\Components\NewStock' => 'BTNewStock',
            'Bt\Inventory\Components\StockList' => 'BTStockList',
            'Bt\Inventory\Components\StockItem' => 'BTStockItem',
            'Bt\Inventory\Components\StockGraphs' => 'StockGraphs',
            'Bt\Inventory\Components\OutStockList' => 'OutStockList',
            'Bt\Inventory\Components\InCageMaterial' => 'InCageMaterial',
            'Bt\Inventory\Components\CmRawMaterialRecon' => 'CmRawMaterialRecon',
            'Bt\Inventory\Components\CmRawMaterialReceiving' => 'CmRawMaterialReceiving',
            'Bt\Inventory\Components\CmMaterialValue' => 'CmMaterialValue',
            'Bt\Inventory\Components\CmDayToDay' => 'CmDayToDay',
            'Bt\Inventory\Components\CmInCageAll' => 'CmInCageAll',



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
            'bt.inventory.rawmaterial' => [
                'tab' => 'Raw Material',
                'label' => '*Raw material tab',
                'order' => 1
            ],
            'bt.inventory.materialrelease' => [
                'tab' => 'Raw Material',
                'label' => '**Raw material release tab',
                'order' => 2
            ],
            'bt.inventory.purchase' => [
                'tab' => 'Raw Material',
                'label' => 'Purchase',
                'order' => 3
            ],
            'bt.inventory.recon' => [
                'tab' => 'Raw Material',
                'label' => 'Raw material recon tab',
                'order' => 4
            ],
            'bt.inventory.incage' => [
                'tab' => 'Raw Material',
                'label' => 'Raw incage material tab',
                'order' => 4
            ],
            'bt.inventory.products' => [
                'tab' => 'Raw Material',
                'label' => 'Raw products tab',
                'order' => 5
            ],
             'bt.inventory.suppliers' => [
                'tab' => 'Raw Material',
                'label' => 'Raw suppliers tab',
                'order' => 6
            ],
            'bt.inventory.permission_release' => [
                'tab' => 'Raw Material',
                'label' => 'Material Permission Release',
                'order' => 7
            ],
            'bt.inventory.permission_incage' => [
                'tab' => 'Raw Material',
                'label' => 'Material Permission Incage',
                'order' => 8
            ],
            'bt.inventory.permission_Request' => [
                'tab' => 'Raw Material',
                'label' => 'Material Permission Request',
                'order' => 9
            ],
             'bt.inventory.permission_used' => [
                'tab' => 'Raw Material',
                'label' => 'Material Permission Used',
                'order' => 10
            ],
            'bt.inventory.buyouts' => [
                'tab' => 'Buy Outs',
                'label' => 'Buy Out Permissions',
                'order' => 11
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
            'inventory' => [
                'label'       => 'Raw Material',
                'url'         => Backend::url('bt/inventory/RawMaterialReceiving'),
                'icon'        => 'icon-ship',
                'permissions' => ['bt.inventory.rawmaterial'],
                'order'       => 102,
                'sideMenu' => [
                    'materialdashboard' => [
                        'label'       => 'Material Dashboard',
                        'url'         => Backend::url('bt/inventory/materialdashboard'),
                        'icon'        => 'icon-tachometer',
                        'permissions' => ['bt.inventory.*'],
                        'group'       => 'Dashboard',
                        'attributes'  => ['Dashboard'],
                    ],
                    'dailymaterial' => [
                        'label'       => 'Daily Material Stock Take',
                        'url'         => Backend::url('bt/inventory/dailymaterial'),
                        'icon'        => 'icon-balance-scale',
                        'permissions' => ['bt.inventory.materialrelease'],
                        'group'       => 'BOM',
                        'attributes'  => ['BOM'],
                    ],
                     'raw_production_plan' => [
                        'label'       => 'Daily Material To Baila Machines',
                        'url'         => Backend::url('bt/inventory/rawproductionplan'),
                        'icon'        => 'icon-calendar-plus-o',
                        'permissions' => ['bt.inventory.materialrelease'],
                        'group'       => 'BOM',
                        'attributes'  => ['BOM'],
                    ],
                    'bagbatch' => [
                        'label'       => 'Bag Batch',
                        'url'         => Backend::url('bt/inventory/bagbatch'),
                        'icon'        => 'icon-calendar-plus-o',
                        'permissions' => ['bt.inventory.purchase'],
                        'group'       => 'Material',
                        'attributes'  => ['Material'],
                    ],


                    'materialrelease' => [
                        'label'       => 'Material Release',
                        'url'         => Backend::url('bt/inventory/RawMaterialReceiving'),
                        'icon'        => 'icon-minus-square-o',
                        'permissions' => ['bt.inventory.materialrelease'],
                        'group'       => 'Material',
                        'attributes'  => ['Material'],
                    ],

                    'blendedpurchase' => [
                        'label'       => 'Blended Purchase Prices',
                        'url'         => Backend::url('bt/inventory/blendedpurchase'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.inventory.materialrelease'],
                        'group'       => 'Material',
                        'attributes'  => ['Material'],
                    ],

                     'messages1_1' => [
                        'label'       => 'Purchase',
                        'url'         => Backend::url('bt/inventory/purchase'),
                        'icon'        => 'icon-shopping-cart',
                        'permissions' => ['bt.inventory.purchase'],
                        'group'       => 'Material',
                        'attributes'  => ['Material'],
                    ],
                    'messages1_2' => [
                        'label'       => 'Buy Outs',
                        'url'         => Backend::url('bt/inventory/buyout'),
                        'icon'        => 'icon-shopping-cart',
                        'permissions' => ['bt.inventory.buyouts'],
                        'group'       => 'Material',
                        'attributes'  => ['Material'],
                    ],
                    // 'messages4' => [
                    //     'label'       => 'Raw Material Recon',
                    //     'url'         => Backend::url('bt/inventory/RawMaterialRecon'),
                    //     'icon'        => 'icon-check-square-o',
                    //     'permissions' => ['bt.inventory.recon'],
                    // ],
                     'messages3' => [
                        'label'       => 'Print Stickers',
                        'url'         => Backend::url('bt/inventory/printsticker'),
                        'icon'        => 'icon-print',
                        'permissions' => ['bt.inventory.*'],
                        'group'       => 'Print',
                        'attributes'  => ['Print'],
                    ],
                     'messages2' => [
                        'label'       => 'Material Names',
                        'url'         => Backend::url('bt/inventory/PartNames'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.inventory.products'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],

                    'messages2_2' => [
                        'label'       => 'Suppliers',
                        'url'         => Backend::url('bt/inventory/Supplier'),
                        'icon'        => 'icon-star-o',
                        'permissions' => ['bt.inventory.suppliers'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],

                    'messages5' => [
                        'label'       => 'Cagetories',
                        'url'         => Backend::url('bt/inventory/MaterialCat'),
                        'icon'        => 'icon-sitemap',
                        'permissions' => ['bt.inventory.*'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ]
                ],
            ],
        ];
    }
}
