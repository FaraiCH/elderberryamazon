<?php namespace Bt\Factory;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;

/**
 * Factory Plugin Information File
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
            'name'        => 'Factory',
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
         BackendMenu::registerContextSidenavPartial('Bt.Factory', 'factory', '$/bt/factory/partials/_sidebar.htm');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

       public function registerReportWidgets()
    {
        return [
            'Bt\Factory\ReportWidgets\TV' => [
                'label'   => 'BT TV',
                'context' => 'dashboard',
                // 'permissions' => [
                //     'bt.sales.sales',
                // ],
            ],           
        ];
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
            'Bt\Factory\Components\MyComponent' => 'myComponent',
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
            'bt.factory.setup' => [
                'tab' => 'Factory',
                'label' => 'Factory Setting',
                'roles' => ['production']
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
            'factory' => [
                'label'       => 'Factory',
                'url'         => Backend::url('bt/factory/accesscard'),
                'icon'        => 'icon-shield',
                'permissions' => ['bt.factory.setup'],
                'order'       => 500,
                'sideMenu' => [
                    'accesscard' => [
                        'label'       => 'Access Card',
                        'url'         => Backend::url('bt/factory/accesscard'),
                        'icon'        => 'icon-credit-card',
                        'permissions' => ['bt.factory.setup'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                    'assettype' => [
                        'label'       => 'Asset Types',
                        'url'         => Backend::url('bt/factory/assettype'),
                        'icon'        => 'icon-dropbox',
                        'permissions' => ['bt.factory.setup'],
                        'group'       => 'asset',
                        'attributes'  => ['asset'],
                    ],
                    'assetuse' => [
                        'label'       => 'Asset Use',
                        'url'         => Backend::url('bt/factory/assetuse'),
                        'icon'        => 'icon-dropbox',
                        'permissions' => ['bt.factory.setup'],
                        'group'       => 'asset',
                        'attributes'  => ['asset'],
                    ],
                    'attendance' => [
                        'label'       => 'Attendance',
                        'url'         => Backend::url('bt/factory/attendance'),
                        'icon'        => 'icon-users',
                        'permissions' => ['bt.factory.setup'],
                        'group'       => 'Register',
                        'attributes'  => ['Register'],
                    ],
                    'attendancetype' => [
                        'label'       => 'Attendance Types',
                        'url'         => Backend::url('bt/factory/attendancetype'),
                        'icon'        => 'icon-users',
                        'permissions' => ['bt.factory.setup'],
                        'group'       => 'Register',
                        'attributes'  => ['Register'],
                    ],

                ],
            ],
        ];
    }
}
