<?php namespace Bt\Operator;

use Backend;
use System\Classes\PluginBase;

/**
 * Operator Plugin Information File
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
            'name'        => 'Operator',
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
            'Bt\Operator\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        //return []; // Remove this line to activate

        return [
            'bt.operator.some_permission' => [
                'tab' => 'Operator',
                'label' => 'Some permission'
            ],
            'bt.operator.sticker' => [
                'tab' => 'Operator',
                'label' => 'Sticker Function'
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
        //return []; // Remove this line to activate

        return [
            'operator' => [
                'label'       => 'Operator',
                'url'         => Backend::url('bt/operator/home'),
                'icon'        => 'icon-child',
                'permissions' => ['bt.operator.*'],
                'order'       => 121,
                'sideMenu' => [
                    'push' => [
                        'label'       => 'Home',
                        'url'         => Backend::url('bt/operator/home'),
                        'icon'        => 'icon-home',
                        'permissions' => ['bt.operator.*']
                    ],
                    'breakdown' => [
                        'label'       => 'Baila Breakdown',
                        'url'         => Backend::url('bt/operator/breakdown'),
                        'icon'        => 'icon-wrench',
                        'permissions' => ['bt.operator.*']
                    ],
                    'contacts' => [
                        'label'       => 'Emegency',
                        'url'         => Backend::url('bt/operator/contacts'),
                        'icon'        => 'icon-phone',
                        'permissions' => ['bt.operator.*']
                    ],

                    'stickers' => [
                        'label'       => 'Pipe Stickers',
                        'url'         => Backend::url('bt/operator/stickers/setup'),
                        'icon'        => 'icon-print',
                        'permissions' => ['bt.operator.sticker'],
                        'group'       => 'Stickers',
                        'attributes'       => ['Stickers'],
                    ],
                ],
            ],
        ];
    }
}
