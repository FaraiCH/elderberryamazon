<?php namespace Bt\Sticker;

use Backend;
use System\Classes\PluginBase;

/**
 * sticker Plugin Information File
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
            'name'        => 'sticker',
            'description' => 'No description provided yet...',
            'author'      => 'bt',
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
     * @return void
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
            'Bt\Sticker\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
//        return []; // Remove this line to activate

        return [
            'bt.sticker.production_op' => [
                'tab' => 'sticker',
                'label' => 'Production Operator'
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
//        return []; // Remove this line to activate

        return [
            'sticker' => [
                'label'       => 'Sticker',
                'url'         => Backend::url('bt/sticker/stickermain'),
                'icon'        => 'icon-print',
                'permissions' => ['bt.sticker.*'],
                'order'       => 500,
                'sideMenu' => [
                    'Sticker' => [
                        'label'       => 'Start Production Run',
                        'url'         => Backend::url('bt/sticker/stickermain'),
                        'icon'        => 'icon-print',
                        'permissions' => ['bt.sticker.production_op'],
                    ],
                ],
            ],
        ];
    }
}
