<?php namespace Bt\Notify;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;
/**
 * Notify Plugin Information File
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
            'name'        => 'Notify',
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
         BackendMenu::registerContextSidenavPartial('Bt.Notify', 'notify', '$/bt/notify/partials/_sidebar.htm');
    }

    /**

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
            'Bt\Notify\Components\CmCalendar' => 'CmCalendar',
            'Bt\Notify\Components\CmProjectdates' => 'CmProjectdates',

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
            'bt.notify.upcomingproject' => [
                'tab' => 'Notify',
                'label' => 'Upcoming Project',
                'roles' => ['team']
            ],
            'bt.notify.sendemail' => [
                'tab' => 'Notify',
                'label' => 'Send Email',
                'roles' => ['mufasa']
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
            'notify' => [
                'label'       => 'Notice',
                'url'         => Backend::url('bt/notify/projectdates'),
                'icon'        => 'icon-bullhorn',
                'permissions' => ['bt.notify.*'],
                'order'       => 120,
                'sideMenu' => [
                    'tvproject' => [
                        'label'       => 'Upcoming Dates',
                        'url'         => Backend::url('bt/notify/projectdates'),
                        'icon'        => 'icon-calendar-check-o',
                        'permissions' => ['bt.notify.upcomingproject'],
                        'group'       => 'Setup Audits',
                        'attributes'  => ['Setup Audits']
                    ],
                    'DailyEmail' => [
                        'label'       => 'Daily Emails',
                        'url'         => Backend::url('bt/notify/DailyEmail'),
                        'icon'        => 'icon-paper-plane',
                        'permissions' => ['bt.notify.sendemail'],
                        'group'       => 'Send Emails',
                        'attributes'  => ['Send Emails']
                    ],
                ],
            ],
        ];
    }
}
