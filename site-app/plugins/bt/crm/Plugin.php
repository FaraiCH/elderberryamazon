<?php namespace Bt\CRM;

use Backend;
use System\Classes\PluginBase;

/**
 * CRM Plugin Information File
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
            'name'        => 'CRM',
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
            'Bt\CRM\Components\MyComponent' => 'myComponent',
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
            'bt.crm.some_permission' => [
                'tab' => 'CRM',
                'label' => 'Some permission'
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
            'crm' => [
                'label'       => 'CRM',
                'url'         => Backend::url('bt/crm/productionreport'),
                'icon'        => 'icon-suitcase',
                'permissions' => ['bt.crm.*'],
                'order'       => 500,
                'sideMenu' => [
                    'messages_0' => [
                        'label'       => 'Production Report',
                        'url'         => Backend::url('bt/crm/productionreport'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.crm.*'],
                    ],
                     'messages_1' => [
                        'label'       => 'Clients',
                        'url'         => Backend::url('bt/crm/client'),
                        'icon'        => 'icon-user-plus',
                        'permissions' => ['bt.crm.*'],
                    ],
                     'messages_2' => [
                        'label'       => 'Export Form',
                        'url'         => Backend::url('bt/crm/exportform'),
                        'icon'        => 'icon-paper-plane-o',
                        'permissions' => ['bt.crm.*'],
                    ],
                ],
            ],
        ];
    }
}
