<?php namespace Bt\Boardroom;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;

/**
 * Boardroom Plugin Information File
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
            'name'        => 'Boardroom',
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
         BackendMenu::registerContextSidenavPartial('Bt.Boardroom', 'boardroom', '$/bt/boardroom/partials/_sidebar.htm');

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
            'Bt\Boardroom\Components\Visitors' => 'CmVisitors',
            'Bt\Boardroom\Components\VisitorInvitation' => 'CmVisitorInvitation',
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
            'bt.boardroom.tab' => [
                'tab' => 'Boardroom',
                'label' => 'Boardroom Tab'
            ],
            'bt.boardroom.approve' => [
                'tab' => 'Boardroom',
                'label' => 'Booking Approval'
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
            'boardroom' => [
                'label'       => 'Boardroom',
                'url'         => Backend::url('bt/boardroom/booking'),
                'icon'        => 'icon-exchange',
                'permissions' => ['bt.boardroom.*'],
                'order'       => 106,
                'sideMenu' => [
                      'appointment' => [
                        'label'       => 'Dashboard',
                        'url'         => Backend::url('bt/boardroom/booking/appointment'),
                        'icon'        => 'icon-calendar',
                        'permissions' => ['bt.boardroom.*'],
                        'group'       => 'Reception',
                        'attributes'  => ['Reception'],
                    ],

                    'new_booking' => [
                        'label'       => 'New Boardroom Booking',
                        'url'         => Backend::url('bt/boardroom/booking/create'),
                        'icon'        => 'icon-plus',
                        'permissions' => ['bt.boardroom.*'],
                        'group'       => 'Boardroom',
                        'attributes'  => ['Boardroom'],
                    ],
                    'booking' => [
                        'label'       => 'Boardroom Booking List',
                        'url'         => Backend::url('bt/boardroom/booking'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.boardroom.*'],
                        'group'       => 'Boardroom',
                        'attributes'  => ['Boardroom'],
                    ],
                    'newvisitor' => [
                        'label'       => 'New Visitors',
                        'url'         => Backend::url('bt/boardroom/visitor/create'),
                        'icon'        => 'icon-plus',
                        'permissions' => ['bt.boardroom.*'],
                        'group'       => 'BT Visitors',
                        'attributes'  => ['BT Visitors'],
                    ],
                    'visitor' => [
                        'label'       => 'Visitors List',
                        'url'         => Backend::url('bt/boardroom/visitor'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.boardroom.*'],
                        'group'       => 'BT Visitors',
                        'attributes'  => ['BT Visitors'],
                    ]


                ],
            ],
        ];
    }
}
