<?php namespace Bt\JSEData;

use Backend;
use BackendMenu;
use System\Classes\PluginBase;

/**
 * JSEData Plugin Information File
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
            'name'        => 'JSEData',
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
        BackendMenu::registerContextSidenavPartial('Bt.JSEData', 'jsedata', '$/bt/jsedata/partials/_sidebar.htm');
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
            'Bt\JSEData\Components\MyComponent' => 'myComponent',
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
            'bt.jsedata.admin' => [
                'tab' => 'JSEData',
                'label' => 'Jase Data Admin',
                ['Developer']
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
            'jsedata' => [
                'label'       => 'JSE Data',
                'url'         => Backend::url('bt/jsedata/querybuilder'),
                'icon'        => 'icon-exchange',
                'permissions' => ['bt.jsedata.admin'],
                'order'       => 500,
                'sideMenu' => [
                    'querybuilder' => [
                        'label'       => 'Query Builder',
                        'url'         => Backend::url('bt/jsedata/querybuilder'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.jsedata.admin'],
                        'group'       => 'Data',
                        'attributes'  => ['Data'],
                        
                    ],
                    'company' => [
                        'label'       => 'Companies',
                        'url'         => Backend::url('bt/jsedata/company'),
                        'icon'        => 'icon-paper-plane',
                        'permissions' => ['bt.jsedata.admin'],
                        'group'       => 'JSE Company/Tickers',
                        'attributes'  => ['JSE Company/Tickers'],
                        
                    ],
                     'datamine' => [
                        'label'       => 'Data Mine',
                        'url'         => Backend::url('bt/jsedata/datamine'),
                        'icon'        => 'icon-database',
                        'permissions' => ['bt.jsedata.admin'],
                        'group'       => 'Data',
                        'attributes'  => ['Data'],
                        
                    ],

                     'inflation' => [
                        'label'       => 'Inflation',
                        'url'         => Backend::url('bt/jsedata/inflation'),
                        'icon'        => 'icon-cogs',
                        'permissions' => ['bt.jsedata.admin'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                        
                    ],
                    'industry' => [
                        'label'       => 'Industries',
                        'url'         => Backend::url('bt/jsedata/industry'),
                        'icon'        => 'icon-cogs',
                        'permissions' => ['bt.jsedata.admin'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                        
                    ],

                     'property' => [
                        'label'       => 'Data Properties',
                        'url'         => Backend::url('bt/jsedata/property'),
                        'icon'        => 'icon-cogs',
                        'permissions' => ['bt.jsedata.admin'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                        
                    ],
                     'querytype' => [
                        'label'       => 'Query Type',
                        'url'         => Backend::url('bt/jsedata/querytype'),
                        'icon'        => 'icon-cogs',
                        'permissions' => ['bt.jsedata.admin'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                        
                    ],
                ]
            ],
        ];
    }
}
