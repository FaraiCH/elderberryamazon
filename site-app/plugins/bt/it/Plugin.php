<?php namespace Bt\IT;

use Backend;
use System\Classes\PluginBase;

/**
 * IT Plugin Information File
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
            'name'        => 'IT',
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
            'Bt\IT\Components\MyComponent' => 'myComponent',
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
            'bt.it.tasks' => [
                'tab' => 'IT',
                'label' => 'Set Tasks'
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
            'it' => [
                'label'       => 'Tasks',
                'url'         => Backend::url('bt/it/job'),
                'icon'        => 'icon-bullhorn',
                'permissions' => ['bt.it.tasks'],
                'order'       => 110,
                'sideMenu' => [
                    'dashboard' => [
                        'label'       => 'Dashboard',
                        'url'         => Backend::url('bt/it/dashboard'),
                        'icon'        => 'icon-tachometer',
                        'permissions' => ['bt.it.tasks'],
                    ],
                    'quotes' => [
                        'label'       => 'Ticket',
                        'url'         => Backend::url('bt/it/job'),
                        'icon'        => 'icon-bullhorn',
                        'permissions' => ['bt.it.tasks'],
                    ],
                    'jobtype' => [
                        'label'       => 'Ticket Type',
                        'url'         => Backend::url('bt/it/jobtype'),
                        'icon'        => 'icon-leaf',
                        'permissions' => ['bt.it.tasks'],
                    ],
                    'ticketstage' => [
                        'label'       => 'Ticket Stage',
                        'url'         => Backend::url('bt/it/ticketstage'),
                        'icon'        => 'icon-rocket',
                        'permissions' => ['bt.it.tasks'],
                    ],
                    'ticketdownload' => [
                        'label'       => 'Ticket Download',
                        'url'         => Backend::url('bt/it/job/export'),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.it.tasks'],
                    ],
                ],
            ],
        ];
    }
}
