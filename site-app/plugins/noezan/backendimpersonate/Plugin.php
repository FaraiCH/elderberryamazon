<?php namespace Noezan\BackendImpersonate;

use Backend;
use System\Classes\PluginBase;
use Backend\Controllers\Users as BackendUsersController;
use BackendAuth;
use Yaml;
use File;
use Event;
/**
 * BackendImpersonate Plugin Information File
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
            'name'        => 'BackendImpersonate',
            'description' => 'No description provided yet...',
            'author'      => 'Noezan',
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
         $this->extendBackendUsersController();
    }


     protected function extendBackendUsersController()
    {         

        BackendUsersController::extendFormFields(function($widget) {
            // Prevent extending of related form instead of the intended User form
            // if (!$widget->model instanceof UserModel) {
            //     return;
            // }

            $configFile = plugins_path('noezan/backendimpersonate/setup/fields.yaml');
            $config = Yaml::parse(File::get($configFile));
            $widget->addTabFields($config);
           
        });

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
            'Noezan\BackendImpersonate\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'noezan.backendimpersonate.some_permission' => [
                'tab' => 'BackendImpersonate',
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
        return []; // Remove this line to activate

        return [
            'backendimpersonate' => [
                'label'       => 'BackendImpersonate',
                'url'         => Backend::url('noezan/backendimpersonate/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['noezan.backendimpersonate.*'],
                'order'       => 500,
            ],
        ];
    }

    public function registerFormWidgets()
    {
        return [
            \Noezan\BackendImpersonate\FormWidgets\ImpersonateBtn::class => 'impersonate_btn',
           
        ];
    }
}
