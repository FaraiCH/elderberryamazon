<?php namespace Bt\Suppliers;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;
/**
 * suppliers Plugin Information File
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
            'name'        => 'suppliers',
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
        BackendMenu::registerContextSidenavPartial('Bt.Suppliers', 'suppliers', '$/bt/suppliers/partials/_sidebar.htm');
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
            'Bt\Suppliers\Components\MyComponent' => 'myComponent',
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
            'bt.suppliers.see' => [
                'tab' => 'Suppliers',
                'label' => 'Show Suppliers'
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
            'suppliers' => [
                'label'       => 'Supplier List',
                'url'         => Backend::url('bt/suppliers/materialsupplier'),
                'icon'        => 'icon-truck',
                'permissions' => ['bt.suppliers.*'],
                'order'       => 500,
                'sideMenu' => [
                    'materialsupplier' => [
                        'label'       => 'Suppler List',
                        'url'         => Backend::url('bt/suppliers/materialsupplier'),
                        'icon'        => 'icon-truck',
                        'permissions' => ['bt.suppliers.*'],
                        'group'       => 'Raw Material',
                        'attributes'  => ['Raw Material'],
                    ],
                    'category' => [
                        'label'       => 'Suppler Category',
                        'url'         => Backend::url('bt/suppliers/category'),
                        'icon'        => 'icon-ellipsis-h',
                        'permissions' => ['bt.suppliers.*'],
                        'group'       => 'Raw Material',
                        'attributes'  => ['Raw Material'],
                    ],
                    'vendor' => [
                        'label'       => 'Suppler Vendor Type',
                        'url'         => Backend::url('bt/suppliers/vendor'),
                        'icon'        => 'icon-ellipsis-v',
                        'permissions' => ['bt.suppliers.*'],
                        'group'       => 'Raw Material',
                        'attributes'  => ['Raw Material'],
                    ],
                ],
            ],
        ];
    }
}
