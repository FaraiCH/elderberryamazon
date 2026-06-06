<?php namespace Bt\PLCommon;

use Backend;
use System\Classes\PluginBase;

/**
 * PLCommon Plugin Information File
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
            'name'        => 'PLCommon',
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

       public function registerFormWidgets()
    {
        return [
           
             'Bt\PLCommon\FormWidgets\InputCurrency' => 'inputcurrency',
             'Bt\PLCommon\FormWidgets\InputBigNumber' => 'inputbignumber',
             'Bt\PLCommon\FormWidgets\InputCurrencyMin' => 'inputcurrencymin',

        ];
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
            'Bt\PLCommon\Components\MyComponent' => 'myComponent',
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
            'admin.tableusers' => [
                'tab' => 'admin.tableusers',
                'label' => 'admin.tableusers'
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
        return []; // Remove this line to activate

        return [
            'plcommon' => [
                'label'       => 'PLCommon',
                'url'         => Backend::url('bt/plcommon/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['bt.plcommon.*'],
                'order'       => 500,
            ],
        ];
    }

    public function registerSettings() {
        return [
            'settings' => [
                'label'       => 'Table User Permision',
                'description' => 'Table User Permision',
                'category'    => 'Table User Permision',
                'icon'        => 'icon-cogs',
                // 'url'         => Backend::url('/pltask/settings'),
                'class' => 'Bt\PLCommon\Models\Settings',
                'order'       => 500,
                'keywords'    => 'Table User Permision',
                'permissions' => ['admin.tableusers'],
            ]
        ];

        return [
            'settings' => [
                'label' => 'janvince.smallcontactform::lang.plugin.name',
                'description' => 'janvince.smallcontactform::lang.plugin.description',
                'category'    => 'Small plugins',
                'icon' => 'icon-inbox',
                'class' => 'JanVince\SmallContactForm\Models\Settings',
                'keywords' => 'task settings',
                'order' => 990,
                'permissions' => ['rw.pltask.settings'],
            ]
        ];
    }

}
