<?php namespace Bt\Floor;

use Backend;
use System\Classes\PluginBase;

/**
 * Floor Plugin Information File
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
            'name'        => 'Floor',
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
        return [
            'Bt\Floor\Components\FloorGraph' => 'FloorGraph',
            'Bt\Floor\Components\FloorScraps' => 'FloorScraps',
            'Bt\Floor\Components\FloorPipes' => 'FloorPipes',
            'Bt\Floor\Components\CmDeliveryScrapPipe' => 'CmDeliveryScrapPipe',
            'Bt\Floor\Components\CmDeliveryClientPipe' => 'CmDeliveryClientPipe',
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
            'bt.floor.some_permission' => [
                'tab' => 'Floor',
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
            'floor' => [
                'label'       => 'Floor Scrap',
                'url'         => Backend::url('bt/floor/DeliveryScrapPipe'),
                'icon'        => 'icon-refresh',
                'permissions' => ['bt.floor.*'],
                'order'       => 109,
                'sideMenu' => [
                    // 'messages' => [
                    //     'label'       => 'Delivery Client Pipe',
                    //     'url'         => Backend::url('bt/floor/DeliveryClientPipe'),
                    //     'icon'        => 'icon-exchange',
                    //     'permissions' => ['bt.floor.*'],
                    // ], 
                    'messages2' => [
                        'label'       => 'Scrap',
                        'url'         => Backend::url('bt/floor/DeliveryScrapPipe'),
                        'icon'        => 'icon-exchange',
                        'permissions' => ['bt.floor.*'],
                    ],
                    // 'messages3' => [
                    //     'label'       => 'Stock Pipe Count',
                    //     'url'         => Backend::url('bt/floor/Stockpipe'),
                    //     'icon'        => 'icon-line-chart',
                    //     'permissions' => ['bt.floor.*'],
                    // ],
                     'messages4' => [
                        'label'       => 'Manual Scrap Weight',
                        'url'         => Backend::url('bt/floor/Scrappipe'),
                        'icon'        => 'icon-trash',
                        'permissions' => ['bt.floor.*'],
                    ],
                    //  'messages5' => [
                    //     'label'       => 'Stock Name',
                    //     'url'         => Backend::url('bt/floor/Stockname'),
                    //     'icon'        => 'icon-cog',
                    //     'permissions' => ['bt.floor.*'],
                    // ],
                    //  'messages6' => [
                    //     'label'       => 'Stock Size',
                    //     'url'         => Backend::url('bt/floor/Stocksize'),
                    //     'icon'        => 'icon-cog',
                    //     'permissions' => ['bt.floor.*'],
                    // ]
                   
                ],
            ],
        ];
    }
}
