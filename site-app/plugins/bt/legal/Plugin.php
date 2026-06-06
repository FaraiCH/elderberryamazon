<?php namespace Bt\Legal;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;
/**
 * legal Plugin Information File
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
            'name'        => 'legal',
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
        BackendMenu::registerContextSidenavPartial('Bt.Legal', 'legal', '$/bt/legal/partials/_sidebar.htm');
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
            'Bt\Legal\Components\MyComponent' => 'myComponent',
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
            'bt.legal.admin' => [
                'tab' => 'legal',
                'label' => 'Legal Admin',
                ['Legal-Team']
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
            'legal' => [
                'label'       => 'Legal',
                'url'         => Backend::url('bt/legal/document'),
                'icon'        => 'icon-copyright',
                'permissions' => ['bt.legal.*'],
                'order'       => 107,
                'sideMenu' => [
                    'document' => [
                        'label'       => 'Documents',
                        'url'         => Backend::url('bt/legal/document'),
                        'icon'        => 'icon-folder-open',
                        'permissions' => ['bt.legal.*'],
                        'group'       => 'Uploads',
                        'attributes'  => ['Uploads'],
                    ],
                    'category' => [
                        'label'       => 'Folders',
                        'url'         => Backend::url('bt/legal/category'),
                        'icon'        => 'icon-file-text',
                        'permissions' => ['bt.legal.*'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],


                ],
            ]
        ];
    }
}
