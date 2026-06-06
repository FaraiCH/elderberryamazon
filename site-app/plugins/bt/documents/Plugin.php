<?php namespace Bt\Documents;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;
/**
 * Documents Plugin Information File
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
            'name'        => 'Documents',
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
        BackendMenu::registerContextSidenavPartial('Bt.Documents', 'documents', '$/bt/documents/partials/_sidebar.htm');
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
            'Bt\Documents\Components\MyComponent' => 'myComponent',
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
            'bt.documents.some_permission' => [
                'tab' => 'Documents',
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
            'documents' => [
                'label'       => 'Documents',
                'url'         => Backend::url('bt/documents/document'),
                'icon'        => 'icon-folder-open',
                'permissions' => ['bt.documents.*'],
                'order'       => 107,
                'sideMenu' => [
                    'document' => [
                        'label'       => 'Document',
                        'url'         => Backend::url('bt/documents/document'),
                        'icon'        => 'icon-folder-open',
                        'permissions' => ['bt.documents.*'],
                        'group'       => 'Uploads',
                        'attributes'  => ['Uploads']
                    ],
                    'category' => [
                        'label'       => 'Folders',
                        'url'         => Backend::url('bt/documents/category'),
                        'icon'        => 'icon-file-text',
                        'permissions' => ['bt.documents.*'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ], 

                    'general' => [
                        'label'       => 'General Doc',
                        'url'         => "/erp/userguide/general",
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.documents.*'],
                        'group'       => 'Training Manuals',
                        'attributes'  => ['Training Manuals'],
                    ],

                    'production' => [
                        'label'       => 'Production Doc',
                        'url'         => "/erp/userguide/production",
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.documents.*'],
                        'group'       => 'Training Manuals',
                        'attributes'  => ['Training Manuals'],
                    ],

                    'sales' => [
                        'label'       => 'Sales Doc',
                        'url'         => "/erp/userguide/sales",
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.documents.*'],
                        'group'       => 'Training Manuals',
                        'attributes'  => ['Training Manuals'],
                    ], 

                     'finance' => [
                        'label'       => 'Finance Doc',
                        'url'         => "/erp/userguide/finance",
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.documents.*'],
                        'group'       => 'Training Manuals',
                        'attributes'  => ['Training Manuals'],
                    ], 

                      'full' => [
                        'label'       => 'All ',
                        'url'         => "/erp/userguide",
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.documents.*'],
                        'group'       => 'Training Manuals',
                        'attributes'  => ['Training Manuals'],
                    ], 


                    
                   
                ],
            ],
        ];
    }
}
