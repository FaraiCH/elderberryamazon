<?php namespace Bt\Reporting;

use Backend;
use System\Classes\PluginBase;
use Bt\PLCommon\Classes\RunStoreProcedures;

/**
 * reporting Plugin Information File
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
            'name'        => 'reporting',
            'description' => 'No description provided yet...',
            'author'      => 'bt',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            RunStoreProcedures::runSetQuoteClientID();
            RunStoreProcedures::runSetStickerSrnID();

        })->everyTenMinutes();

        $schedule->call(function () {
            RunStoreProcedures::runprocedurePrepareElecricityReport();


        })->weekly()->mondays()->at('18:00');

    }


    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        Backend\Facades\BackendMenu::registerContextSidenavPartial('Bt.Reporting', 'reporting', '$/bt/reporting/partials/_sidebar.htm');

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
            'Bt\Reporting\Components\MyComponent' => 'myComponent',
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
            'bt.reporting.some_permission' => [
                'tab' => 'reporting',
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
            'reporting' => [
                'label'       => 'Reporting',
                'url'         => Backend::url('bt/reporting/batchsearch/batch'),
                'icon'        => 'icon-book',
                'order'       => 500,
                'sideMenu' => [
                    'batchsearch' => [
                        'label'       => 'Batch Search',
                        'url'         => Backend::url('bt/reporting/batchsearch/find'),
                        'icon'        => 'icon-search',
                        'group'       => 'Search',
                        'attributes'  => ['Search'],
                    ],
                    'batchslist' => [
                        'label'       => 'Batch List',
                        'url'         => Backend::url('bt/reporting/batchsearch/batch'),
                        'icon'        => 'icon-list',
                        'group'       => 'Search',
                        'attributes'  => ['Search'],
                    ],
                    'pipeprice' => [
                        'label'       => 'Today Stock',
                        'url'         => Backend::url('bt/logistics/pipeprice'),
                        'icon'        => 'icon-money',
                        'permissions' => ['bt.logistics.admin'],
                        'group'       => 'Prices',
                        'attributes'  => ['Prices'],
                    ],
                    'list' => [
                        'label'       => 'Approvals',
                        'url'         => Backend::url('bt/reporting/approvals/list'),
                        'icon'        => 'icon-thumbs-o-up',
                        'group'       => 'Reporting',
                        'attributes'  => ['Reporting'],
                    ],

                    'Agepipe' => [
                        'label'       => 'Pipe Age',
                        'url'         => Backend::url('bt/reporting/agepipe'),
                        'icon'        => 'icon-thumbs-o-up',
                        'group'       => 'Reporting',
                        'attributes'  => ['Reporting'],
                    ],
                    'viewstickerdata' => [
                        'label'       => 'Sticker Data',
                        'url'         => Backend::url('bt/reporting/viewstickerdata'),
                        'icon'        => 'icon-list',
                        'group'       => 'Reporting',
                        'attributes'  => ['Logistics Reports'],
                    ],
                    'viewsrnstickerdata' => [
                        'label'       => 'SRN VS Sticker Units',
                        'url'         => Backend::url('bt/reporting/viewsrnstickerdata'),
                        'icon'        => 'icon-list',
                        'group'       => 'Reporting',
                        'attributes'  => ['Logistics Reports'],
                    ],
                    'controlsheetmassdata' => [
                        'label'       => 'ControlSheet Mass Data',
                        'url'         => Backend::url('bt/reporting/controlsheetmassdata'),
                        'icon'        => 'icon-list',
                        'group'       => 'Reporting',
                        'attributes'  => ['Production Reports'],
                    ],
                    'production_daily_reports' => [
                        'label'       => 'Production daily reports',
                        'url'         => Backend::url('bt/reporting/productiondailyreport'),
                        'icon'        => 'icon-list',
                        'group'       => 'Reporting',
                        'attributes'  => ['Production Reports'],
                    ],
                    'viewweekyproductionelectricity' => [
                        'label'       => 'Weekly Production vs Electricity',
                        'url'         => Backend::url('bt/reporting/viewweekyproductionelectricity'),
                        'icon'        => 'icon-bolt',
                        'group'       => 'Reporting',
                        'attributes'  => ['Production Reports'],
                    ],
                    'viewelectricityproduction' => [
                        'label'       => 'Daily Production KWH',
                        'url'         => Backend::url('bt/reporting/viewelectricityproduction'),
                        'icon'        => 'icon-bolt',
                        'group'       => 'Reporting',
                        'attributes'  => ['Production Reports'],
                    ],
                    'viewscrapdata' => [
                        'label'       => 'ControlSheet Scrap Data',
                        'url'         => Backend::url('bt/reporting/viewscrapdata'),
                        'icon'        => 'icon-cogs',
                        'group'       => 'Reporting',
                        'attributes'  => ['Production Reports'],
                    ],
                    'viewquoteperformance' => [
                        'label'       => 'Quote Performance',
                        'url'         => Backend::url('bt/reporting/viewquoteperformance'),
                        'icon'        => 'icon-list',
                        'group'       => 'Reporting',
                        'attributes'  => ['Production Reports'],
                    ],
                ]
            ],
        ];
    }
}
