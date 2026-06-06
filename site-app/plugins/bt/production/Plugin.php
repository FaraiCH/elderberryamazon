<?php namespace Bt\Production;

use Backend;
use Bt\Production\Models\Pipe;
use Bt\Production\Models\Push;
use System\Classes\PluginBase;
use Bt\Production\Classes\Support as ProductionSupport;
use BackendMenu;
/**
 * Production Plugin Information File
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
            'name'        => 'Production',
            'description' => 'Production by BT...',
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
         BackendMenu::registerContextSidenavPartial('Bt.Production', 'production', '$/bt/production/partials/_sidebar.htm');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        \Event::listen('backend.list.extendQuery', function ($widget, $query) {
            // Test your model
            if ($widget->model instanceof Pipe) {
                $push = Push::find(\Request::segment(6));
                if($push->id == 41)
                    $query->where('start_date', '>', '2021-01-01');

            }
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {


        return [
            'Bt\Production\Components\Pushed' => 'ProductionPushed',
            'Bt\Production\Components\PushItems' => 'ProductionPushItems',
            'Bt\Production\Components\PushPipe' => 'ProductionPushPipe',
            'Bt\Production\Components\RunningScheduleGraphs' => 'RunningScheduleGraphs',
            'Bt\Production\Components\Menu' => 'ProductionMenu',
            'Bt\Production\Components\Summary' => 'CmSummary',
            'Bt\Production\Components\CmWeeklyProduction' => 'CmWeeklyProduction',
            'Bt\Production\Components\DayToDayScrap' => 'CmDayToDayScrap',
            'Bt\Production\Components\Schedule' => 'CmProductionSchedule',
            'Bt\Production\Components\CmpPrintpipesticker' => 'CmpPrintpipesticker',
            'Bt\Production\Components\CmStickerLanding' => 'CmStickerLanding',
            'Bt\Production\Components\CmPipeStickerHome' => 'CmPipeStickerHome',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    //  public function registerSettings() {

    //     return [

    //     ];
    // }
    public function registerPermissions()
    {


        return [
            'bt.production.setup' => [
                'tab' => 'Production',
                'label' => 'Production Setup'
            ],
             'bt.production.approve' => [
                'tab' => 'Production',
                'label' => 'Production Approve'
            ],
             'bt.production.admin' => [
                'tab' => 'Production',
                'label' => 'Production Admin',
                'roles' => ['production']
            ],

              'bt.production.btaccountmanager' => [
                'tab' => 'Production',
                'label' => 'BT Account Manager',
                'roles' => ['production']
            ],

            'bt.production.analysis' => [
                'tab' => 'Production',
                'label' => 'Analysis',
                'roles' => ['production']
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
            'production' => [
                'label'       => 'Production',
                'url'         => Backend::url('bt/production/push'),
                'icon'        => 'icon-hourglass-half',
                'permissions' => ['bt.production.*'],
                'order'       => 100,
                'sideMenu' => [
                    'dashboard' => [
                        'label'       => 'Dashboard',
                        'url'         => Backend::url('bt/production/dashboard/view'),
                        'icon'        => 'icon-dashboard',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Production',
                        'attributes'  => ['Production'],
                    ],
                    'push' => [
                        'label'       => 'Production',
                        'url'         => Backend::url('bt/production/push'),
                        'icon'        => 'icon-calendar',
                        'permissions' => ['bt.production.setup'],
                        'counter' => ProductionSupport::getStartedTotal(),
                        'group'       => 'Production',
                        'attributes'  => ['Production'],
                        'counterLabel' => 'Started Project'
                    ],
                      'breakdown' => [
                        'label'       => 'Baila Breakdown',
                        'url'         => Backend::url('bt/production/breakdown'),
                        'icon'        => 'icon-wrench',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Production',
                        'attributes'  => ['Production'],
                    ],

                    'schedule' => [
                        'label'       => 'Production Runs',
                        'url'         => Backend::url('bt/production/schedule'),
                        'icon'        => 'icon-hourglass-half',
                        'permissions' => ['bt.production.*'],
                        'group'       => 'Production',
                        'attributes'  => ['Production'],
                        'badge' => "new"
                    ],



                    'backorders' => [
                        'label'       => 'Back Orders',
                        'url'         => Backend::url('bt/production/productionplan/backorders'),
                        'icon'        => 'icon-history',
                        'permissions' => ['bt.production.*'],
                        'group'       => 'Production Report',
                        'attributes'  => ['Production Report'],
                        'badge' => "new"
                    ],

                    'weeklyrunsreport' => [
                        'label'       => 'Weekly Runs',
                        'url'         => Backend::url('bt/production/productionplan/weeklyrunsreport'),
                        'icon'        => 'icon-history',
                        'permissions' => ['bt.production.*'],
                        'group'       => 'Production Report',
                        'attributes'  => ['Production Report'],
                        'badge' => "new"
                    ],
                    'prodaily' => [
                        'label'       => 'Daily Production (Upload)',
                        'url'         => Backend::url('bt/production/prodaily'),
                        'icon'        => 'icon-file-excel-o',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Production Report',
                        'attributes'  => ['Production Report'],
                        'badge' => "new"
                    ],

                    'sheet' => [
                        'label'       => 'Daily Report',
                        'url'         => Backend::url('bt/production/prodaily/sheet'),
                        'icon'        => 'icon-list-ol',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Production Report',
                        'attributes'  => ['Production Report'],
                        'badge' => "new"
                    ],
                    'marginanalysis' => [
                        'label'       => 'Monthly Production Margin Analysis',
                        'url'         => Backend::url('bt/production/productionplan/marginanalysis'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.production.analysis'],
                        'group'       => 'Production Report',
                        'attributes'  => ['Production Report'],
                        'badge' => "new"
                    ],
                    'stockanalysis' => [
                        'label'       => 'Stock Analysis',
                        'url'         => Backend::url('bt/production/productionplan/stockanalysis'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.production.analysis'],
                        'group'       => 'Production Report',
                        'attributes'  => ['Production Report'],
                        'badge' => "new"
                    ],

                    'createplan' => [
                        'label'       => 'Production Plan',
                        'url'         => Backend::url('bt/production/productionplan'),
                        'icon'        => 'icon-book',
                        'group'       => 'Production',
                        'attributes'  => ['Production'],
                        'permissions' => ['bt.production.admin'],
                        'keywords' =>  'Create Plan',
                    ],


                    'minimumrun' => [
                        'label'       => 'Minimum Run',
                        'url'         => Backend::url('bt/production/minimumrun'),
                        'icon'        => 'icon-angle-double-up',
                        'group'       => 'Production',
                        'attributes'  => ['Production'],
                        'permissions' => ['bt.production.admin'],
                        'keywords' =>  'Create Plan',
                    ],
                    'runningparameter' => [
                        'label'       => 'Running Parameters',
                        'url'         => Backend::url('bt/production/runningparameter'),
                        'icon'        => 'icon-arrows-h',
                        'group'       => 'Production',
                        'attributes'  => ['Production'],
                        'permissions' => ['bt.production.admin'],
                        'keywords' =>  'Create Plan',
                    ],

                    'displayplans' => [
                        'label'       => 'Plans',
                        'url'         => Backend::url('bt/production/productionplan/home'),
                        'icon'        => 'icon-lightbulb-o',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Production',
                        'attributes'  => ['Production'],

                    ],
                    'jobcard' => [
                        'label'       => 'Job Cards',
                        'url'         => Backend::url('bt/production/jobcard'),
                        'icon'        => 'icon-cog',
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                        'permissions' => ['bt.production.setup'],
                    ],
                    'controlsheet' => [
                        'label'       => 'Control Sheet',
                        'url'         => Backend::url('bt/production/controlsheet'),
                        'icon'        => 'icon-cogs',
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                        'permissions' => ['bt.production.setup'],
                    ],
                    'btaccount' => [
                        'label'       => 'BT Account',
                        'url'         => Backend::url('bt/production/btaccount'),
                        'icon'        => 'icon-plus',
                        'group'       => 'Production',
                        'attributes'  => ['Production'],
                        'permissions' => ['bt.production.btaccountmanager'],
                    ],

                     'PrintSticker' => [
                        'label'       => 'Pipe Stickers',
                        'url'         => Backend::url('bt/production/printsticker'),
                        'icon'        => 'icon-print',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Printing',
                        'attributes'       => ['Printing'],
                    ],

                     'messages2plantstats' => [
                        'label'       => 'Plant Stats',
                        'url'         => Backend::url('bt/production/Line/plantstats'),
                        'icon'        => 'icon-paper-plane',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Plant',
                        'attributes'       => ['Plant'],
                    ],
                     'planthours' => [
                        'label'       => 'Plant Hours',
                        'url'         => Backend::url('bt/production/planthours'),
                        'icon'        => 'icon-clock-o',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Plant',
                        'attributes'       => ['Plant'],
                        'badge' => "new"
                    ],
                     'messages2' => [
                        'label'       => 'Lines',
                        'url'         => Backend::url('bt/production/Line'),
                        'icon'        => 'icon-cog',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Plant',
                        'attributes'       => ['Plant'],
                    ],
                    'scrapcode' => [
                        'label'       => 'Scrap Codes',
                        'url'         => Backend::url('bt/production/scrapcodes'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Setup',
                        'attributes'       => ['Setup'],
                    ],
                    'delayreason' => [
                        'label'       => 'Delay Reasons',
                        'url'         => Backend::url('bt/production/delayreason'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Setup',
                        'attributes'       => ['Setup'],
                    ],

                    'breakdownreason' => [
                        'label'       => 'Breakdown Reasons',
                        'url'         => Backend::url('bt/production/breakdownreason'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.production.setup'],
                        'group'       => 'Setup',
                        'attributes'       => ['Setup'],
                    ]

                ],
            ],
        ];
    }
}
