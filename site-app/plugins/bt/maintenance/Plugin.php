<?php namespace Bt\Maintenance;

use Backend;
use System\Classes\PluginBase;
use Bt\Maintenance\Classes\Upcomingevent;
use Bt\Maintenance\Controllers\Tools as ctTools;
use BackendMenu;
/**

 * Maintenance Plugin Information File
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
            'name'        => 'Maintenance',
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
        BackendMenu::registerContextSidenavPartial('Bt.Maintenance', 'maintenance', '$/bt/maintenance/partials/_sidebar.htm');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            $t = new ctTools;
            $t->onSendDailyNotification();
        })->daily();
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {


        return [
            'Bt\Maintenance\Components\ToolsList' => 'ToolsList',
            'Bt\Maintenance\Components\CmSchedule' => 'CmSchedule',
            'Bt\Maintenance\Components\CmJobCard' => 'CmJobCard',
            'Bt\Maintenance\Components\CmpStoreStickerHome' => 'CmpStoreStickerHome',

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
            'bt.maintenance.maintenance' => [
                'tab' => 'Maintenance',
                'label' => 'General Maintenance'
            ],
            'bt.jobcard.approve' => [
                'tab' => 'Maintenance',
                'label' => 'Job Card Approval'
            ],
            'bt.jobcard.dashboard' => [
                'tab' => 'Maintenance',
                'label' => 'Dashboard'
            ],
            'bt.jobcard.guest' => [
                'tab' => 'Maintenance',
                'label' => 'Guest'
            ],
            'bt.jobcard.management' => [
                'tab' => 'Maintenance',
                'label' => 'Management'
            ],

            'bt.maintenance.tools' => [
                'tab' => 'Maintenance',
                'label' => 'Tools'
            ],

            'bt.maintenance.vendors' => [
                'tab' => 'Maintenance',
                'label' => 'Vendors'
            ],

            'bt.maintenance.storeproductitem' => [
                'tab' => 'Maintenance',
                'label' => 'Store Inventory '
            ],
            'bt.maintenance.plant' => [
                'tab' => 'Maintenance',
                'label' => 'plant'
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
            'maintenance' => [
                'label'       => 'Maintenance',
                'url'         => Backend::url('bt/maintenance/jobcard/guestdashboard'),
                'icon'        => 'icon-wrench',
                'permissions' => ['bt.maintenance.*'],
                'order'       => 106,
                'sideMenu' => [
                    'guestdashboard' => [
                        'label'       => 'Guest Dashboard',
                        'url'         => Backend::url('bt/maintenance/jobcard/guestdashboard'),
                        'icon'        => 'icon-tachometer',
                        'permissions' => ['bt.jobcard.guest'],
                        'attributes'  => ['Job Card'],
                    ],

                    'dashboard' => [
                        'label'       => 'Managers Dashboard',
                        'url'         => Backend::url('bt/maintenance/jobcard/dashboard'),
                        'icon'        => 'icon-tachometer',
                        'permissions' => ['bt.jobcard.dashboard'],
                        'attributes'  => ['Job Card'],
                        'counter' => Upcomingevent::getNewJobcardTotal(),
                    ],

                    'jobcardcreate' => [
                        'label'       => 'New Job Card',
                        'url'         => Backend::url('bt/maintenance/jobcard/create'),
                        'icon'        => 'icon-plus',
                        'permissions' => ['bt.jobcard.*'],
                        'attributes'  => ['Job Card'],
                    ],

                    'tools' => [
                        'label'       => 'Equipment/tools',
                        'url'         => Backend::url('bt/maintenance/tools'),
                        'icon'        => 'icon-rocket',
                        'permissions' => ['bt.maintenance.tools'],
                        'attributes'  => ['Tools'],
                    ],

                    'vehicles' => [
                        'label'       => 'Vehicles',
                        'url'         => Backend::url('bt/maintenance/vehicle'),
                        'icon'        => 'icon-bus',
                        'permissions' => ['bt.maintenance.tools'],
                        'attributes'  => ['Tools'],
                    ],
                     'equipmenttype' => [
                        'label'       => 'Equipment Type',
                        'url'         => Backend::url('bt/maintenance/equipmenttype'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.maintenance.tools'],
                        'attributes'  => ['Tools'],
                    ],

                    'checklist' => [
                        'label'       => 'Checklist Setup',
                        'url'         => Backend::url('bt/maintenance/Checklist'),
                        'icon'        => 'icon-cog',
                        'permissions' => ['bt.maintenance.tools'],
                        'attributes'  => ['Tools'],
                    ],
                    'equipmentregister' => [
                        'label'       => 'Equipment Register',
                        'url'         => Backend::url('bt/maintenance/EquipmentRegister'),
                        'icon'        => 'icon-cog',
                        'permissions' => ['bt.maintenance.tools'],
                        'attributes'  => ['Tools'],
                    ],
                    'storeproductitem' => [
                        'label'       => 'Store Product Item',
                        'url'         => Backend::url('bt/maintenance/storeproductitem'),
                        'icon'        => 'icon-list',
                        'attributes'  => ['Store Inventory'],
                    ],

                   'schedule' => [
                        'label'       => 'Schedule',
                        'url'         => Backend::url('bt/maintenance/schedule'),
                        'icon'        => 'icon-bell',
                        'permissions' => ['bt.maintenance.maintenance'],
                        'attributes'  => ['Maintenance'],
                    ],


                    'overview' => [
                        'label'       => 'Overview',
                        'url'         => Backend::url('bt/maintenance/overview'),
                        'icon'        => 'icon-bell',
                        'permissions' => ['bt.maintenance.maintenance'],
                        'attributes'  => ['Maintenance'],
                    ],


                    'jobcard' => [
                        'label'       => 'Job Card',
                        'url'         => Backend::url('bt/maintenance/jobcard'),
                        'icon'        => 'icon-wrench',
                        'counter' => Upcomingevent::getJobcardTotal(),
                        'permissions' => ['bt.maintenance.maintenance'],
                        'attributes'  => ['Maintenance'],
                    ],

                     'toolschecklist' => [
                        'label'       => 'Upcoming Maintenance',
                        'url'         => Backend::url('bt/maintenance/toolschecklist'),
                        'icon'        => 'icon-clock-o',
                        'counter' => Upcomingevent::getTotal(),
                        'permissions' => ['bt.maintenance.maintenance'],
                        'counterLabel' => 'Upcoming maintenance in 10 day',
                        'attributes'  => ['Maintenance'],
                    ],
                    'diesel' => [
                        'label'       => 'Diesel Usage',
                        'url'         => Backend::url('bt/maintenance/diesel'),
                        'icon'        => 'icon-bus',
                        'permissions' => ['bt.maintenance.maintenance'],
                        'attributes'  => ['Maintenance'],
                    ],
                     'elecmeter' => [
                        'label'       => 'Electricity Meter',
                        'url'         => Backend::url('bt/maintenance/elecmeter'),
                        'icon'        => 'icon-bolt',
                        'permissions' => ['bt.maintenance.plant'],
                        'attributes'  => ['Plant'],
                    ],
                    'provincialbill' => [
                        'label'       => 'Provincial Bill',
                        'url'         => Backend::url('bt/maintenance/provincialbill'),
                        'icon'        => 'icon-credit-card',
                        'permissions' => ['bt.maintenance.plant'],
                        'attributes'  => ['Plant'],
                    ],
//                    'elecmetergraph' => [
//                        'label'       => 'Elect Meters Graph',
//                        'url'         => Backend::url('bt/maintenance/elecmeter/graph'),
//                        'icon'        => 'icon-bar-chart',
//                        'permissions' => ['bt.maintenance.plant'],
//                        'attributes'  => ['Plant'],
//                    ],
                    'waterusage' => [
                        'label'       => 'Water Usage',
                        'url'         => Backend::url('bt/maintenance/waterusage'),
                        'icon'        => 'icon-tint',
                        'permissions' => ['bt.maintenance.plant'],
                        'attributes'  => ['Plant'],
                    ],
                    'waterusagegraph' => [
                        'label'       => 'Water Usage Graph',
                        'url'         => Backend::url('bt/maintenance/waterusage/graph'),
                        'icon'        => 'icon-bar-chart',
                        'permissions' => ['bt.maintenance.plant'],
                        'attributes'  => ['Plant'],
                    ],
                    'messages11' => [
                        'label'       => 'Staff',
                        'url'         => Backend::url('bt/maintenance/Staff'),
                        'icon'        => 'icon-users',
                        'permissions' => ['bt.maintenance.plant'],
                        'attributes'  => ['Plant'],
                    ],
                    'messages2' => [
                        'label'       => 'Vendors',
                        'url'         => Backend::url('bt/maintenance/Vendor'),
                        'icon'        => 'icon-address-book',
                        'permissions' => ['bt.maintenance.vendors'],
                        'attributes'  => ['Vendors'],
                    ],
                    'messages3' => [
                        'label'       => 'Vendor Type',
                        'url'         => Backend::url('bt/maintenance/VendorType'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.maintenance.vendors'],
                        'attributes'  => ['Vendors'],
                    ],
                      'messages3' => [
                        'label'       => 'Vendor Type',
                        'url'         => Backend::url('bt/maintenance/VendorType'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.maintenance.vendors'],
                        'attributes'  => ['Vendors'],
                    ],




                    // 'messages4' => [
                    //     'label'       => 'Equipment Types',
                    //     'url'         => Backend::url('bt/maintenance/EquipmentType'),
                    //     'icon'        => 'icon-list',
                    //     'permissions' => ['bt.maintenance.*'],
                    // ],
//                     'elecimport' => [
//                        'label'       => 'ElecMeter Import',
//                        'url'         => Backend::url('bt/maintenance/electricity'),
//                        'icon'        => 'icon-list',
//                        'permissions' => ['bt.maintenance.plant'],
//                          'attributes'  => ['Plant'],
//                    ],
//                    'elecimportgraph' => [
//                        'label'       => 'Elect Import Graph',
//                        'url'         => Backend::url('bt/maintenance/electricity/graph'),
//                        'icon'        => 'icon-bar-chart',
//                        'permissions' => ['bt.maintenance.plant'],
//                        'attributes'  => ['Plant'],
//                    ]

                ],
            ],
        ];
    }
}
