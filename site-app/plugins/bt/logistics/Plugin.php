<?php namespace Bt\Logistics;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;
/**
 * Logistics Plugin Information File
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
            'name'        => 'Logistics',
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
        BackendMenu::registerContextSidenavPartial('Bt.Logistics', 'logistics', '$/bt/logistics/partials/_sidebar.htm');
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
        return []; // Remove this line to activate

        return [
            'Bt\Logistics\Components\MyComponent' => 'myComponent',
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
            'bt.logistics.usagetype' => [
                'tab' => 'Logistics',
                'label' => 'User'
            ],
            'bt.logistics.admin' => [
                'tab' => 'Logistics',
                'label' => 'Admin'
            ],
            'bt.logistics.schedule' => [
                'tab' => 'Logistics',
                'label' => 'schedule'
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
            'logistics' => [
                'label'       => 'Logistics',
                'url'         => Backend::url('bt/logistics/schedule'),
                'icon'        => 'icon-car',
                'permissions' => ['bt.logistics.*'],
                'order'       => 500,
                'sideMenu' => [
                    'truck' => [
                        'label'       => 'Load Truck',
                        'url'         => Backend::url('bt/logistics/home/truck'),
                        'icon'        => 'icon-truck',
                        'permissions' => ['bt.logistics.usagetype'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'srn' => [
                        'label'       => 'QC SRN Approval',
                        'url'         => Backend::url('bt/logistics/home/srn'),
                        'icon'        => 'icon-check',
                        'permissions' => ['bt.logistics.usagetype'],
                        'group'       => 'Stock Release',
                        'attributes'  => ['Stock Release'],
                    ],
                    'home' => [
                        'label'       => 'Calendar',
                        'url'         => Backend::url('bt/logistics/home'),
                        'icon'        => 'icon-calendar',
                        'permissions' => ['bt.logistics.usagetype'],
                        'group'       => 'Schedule',
                        'attributes'  => ['Schedule'],
                    ],

                     'stockrelease' => [
                        'label'       => 'SRNs',
                        'url'         => Backend::url('bt/logistics/stockrelease'),
                        'icon'        => 'icon-calendar',
                        'permissions' => ['bt.logistics.usagetype'],
                        'group'       => 'Schedule',
                        'attributes'  => ['Schedule'],
                    ],
                      'binarea' => [
                        'label'       => 'Loading Bin Areas',
                        'url'         => Backend::url('bt/logistics/binarea'),
                        'icon'        => 'icon-cubes',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Loading Bins',
                        'attributes'  => ['Loading Bins'],
                    ],

                    'pipeprice' => [
                        'label'       => 'Pipe Prices',
                        'url'         => Backend::url('bt/logistics/pipeprice'),
                        'icon'        => 'icon-money',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Prices',
                        'attributes'  => ['Prices'],
                    ],
                     'schedule' => [
                        'label'       => 'Internal Vehicle Schedule',
                        'url'         => Backend::url('bt/logistics/schedule'),
                        'icon'        => 'icon-plus',
                        'permissions' => ['bt.logistics.schedule'],
                        'group'       => 'Schedule',
                        'attributes'  => ['Schedule'],
                    ],
                    'vehicle' => [
                        'label'       => 'Vehicle',
                        'url'         => Backend::url('bt/logistics/vehicle'),
                        'icon'        => 'icon-car',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Fleet Management',
                        'attributes'  => ['Fleet Management'],
                    ],
                    'vehiclefuelusagegraph' => [
                        'label'       => 'Vehicle Fuel Usage Graph',
                        'url'         => Backend::url('bt/logistics/vehiclefuelusage/graph'),
                        'icon'        => 'icon-bar-chart',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Fleet Management',
                        'attributes'  => ['Fleet Management'],
                    ],
                    'trailer' => [
                        'label'       => 'Trailer',
                        'url'         => Backend::url('bt/logistics/trailer'),
                        'icon'        => 'icon-car',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Fleet Management',
                        'attributes'  => ['Fleet Management'],
                    ],
                    'driver' => [
                        'label'       => 'Drivers',
                        'url'         => Backend::url('bt/logistics/driver'),
                        'icon'        => 'icon-user',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Fleet Management',
                        'attributes'  => ['Fleet Management'],
                    ],
                    'usagetype' => [
                        'label'       => 'Usage Type',
                        'url'         => Backend::url('bt/logistics/usagetype'),
                        'icon'        => 'icon-cogs',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                    'fueltype' => [
                        'label'       => 'Fuel Type',
                        'url'         => Backend::url('bt/logistics/fueltype'),
                        'icon'        => 'icon-car',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                ]
            ],
        ];
    }
}
