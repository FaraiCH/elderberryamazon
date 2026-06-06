<?php namespace Bt\QC;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;

/**
 * QC Plugin Information File
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
            'name'        => 'QC',
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
         BackendMenu::registerContextSidenavPartial('Bt.QC', 'qc', '$/bt/qc/partials/_sidebar.htm');

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
            'Bt\QC\Components\MyComponent' => 'myComponent',
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
            'bt.qc.some_permission' => [
                'tab' => 'QC',
                'label' => 'Quality Control',
                ['qc-team','production','logistic-team']
            ],
             'bt.qc.approval' => [
                'tab' => 'QC',
                'label' => 'QC Approval',
                'roles' => ['qc-team']
            ],
            'bt.qc.documents' => [
                'tab' => 'QC',
                'label' => 'QC Documents',
                'roles' => ['qc-team']
            ],
            'bt.qc.lab' => [
                'tab' => 'QC',
                'label' => 'QC Lab',
                'roles' => ['qc-team']
            ],
            'bt.qc.qms' => [
                'tab' => 'QC',
                'label' => 'QC QMS',
                'roles' => ['qc-team']
            ],
            'bt.qc.ncr' => [
                'tab' => 'QC',
                'label' => 'QC NCR',
                'roles' => ['qc-team','production','logistic-team']
            ],
            'bt.qc.setup' => [
                'tab' => 'QC',
                'label' => 'QC Setup',
                'roles' => ['qc-team']
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
            'qc' => [
                'label'       => 'QC',
                'url'         => Backend::url('bt/qc/productioninspection'),
                'icon'        => 'icon-check-square-o',
                'permissions' => ['bt.qc.*'],
                'order'       => 105,
                'sideMenu' => [
                    'productioninspection' => [
                        'label'       => 'Production Inspection',
                        'url'         => Backend::url('bt/qc/productioninspection'),
                        'icon'        => 'icon-home',
                        'permissions' => ['bt.qc.lab'],
                    ],
                    'qcequipment' => [
                        'label'       => 'QC Equipments',
                        'url'         => Backend::url('bt/qc/qcequipment'),
                        'icon'        => 'icon-rocket',
                        'group'       => 'Lab',
                        'permissions' => ['bt.qc.lab'],
                        'attributes'  => ['Lab'],
                    ],
                    'pipereport' => [
                        'label'       => 'Pipe Report',
                        'url'         => Backend::url('bt/qc/pipereport'),
                        'icon'        => 'icon-eyedropper',
                        'group'       => 'Lab',
                        'permissions' => ['bt.qc.lab'],
                        'attributes'  => ['Lab'],
                    ],
                    'document' => [
                        'label'       => 'Document',
                        'url'         => Backend::url('bt/qc/document'),
                        'icon'        => 'icon-folder-open',
                        'permissions' => ['bt.qc.documents'],
                        'group'       => 'Document',
                        'attributes'  => ['Documents'],
                    ],
                    'category' => [
                        'label'       => 'Departments & Folders',
                        'url'         => Backend::url('bt/qc/category'),
                        'icon'        => 'icon-file-text',
                        'permissions' => ['bt.qc.documents'],
                        'group'       => 'Document',
                        'attributes'  => ['Documents'],
                    ],
                    'datapack' => [
                        'label'       => 'Data Pack',
                        'url'         => Backend::url('bt/qc/datapack'),
                        'icon'        => 'icon-inbox',
                        'permissions' => ['bt.qc.documents'],
                        'group'       => 'Document',
                         'attributes'  => ['Documents'],
                    ],
                    'labresults' => [
                        'label'       => 'Lab Results',
                        'url'         => Backend::url('bt/qc/labresults'),
                        'icon'        => 'icon-eyedropper',
                        'permissions' => ['bt.qc.lab'],
                        'group'       => 'Lab',
                         'attributes'  => ['Lab'],
                    ],
                    'datapackindex' => [
                        'label'       => 'Index',
                        'url'         => Backend::url('bt/qc/datapackindex'),
                        'icon'        => 'icon-umbrella',
                        'permissions' => ['bt.qc.lab'],
                        'group'       => 'Lab',
                         'attributes'  => ['Lab'],
                    ],
                     'qms' => [
                        'label'       => 'QMS',
                        'url'         => Backend::url('bt/qc/qms'),
                        'icon'        => 'icon-commenting',
                        'permissions' => ['bt.qc.qms'],
                        'group'       => 'QMS',
                         'attributes'  => ['QMS'],
                    ],
                     'ncr' => [
                        'label'       => 'NCR',
                        'url'         => Backend::url('bt/qc/ncr'),
                        'icon'        => 'icon-commenting-o',
                        'permissions' => ['bt.qc.ncr'],
                        'group'       => 'NCR',
                         'attributes'  => ['NCR'],
                    ],
                    'ncrtype' => [
                        'label'       => 'Types',
                        'url'         => Backend::url('bt/qc/ncrtype'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.qc.setup'],
                        'group'       => 'NCR',
                        'attributes'  => ['NCR'],
                    ],

                    'feedbackform' => [
                        'label'       => 'Feed Back Form',
                        'url'         => Backend::url('bt/qc/feedbackform'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.qc.ncr'],
                        'group'       => 'Feed back form',
                        'attributes'  => ['Feed back form'],
                        'badge' => "new"
                    ],
                    'matrixcalender' => [
                        'label'       => 'Matrix Calender',
                        'url'         => Backend::url('bt/qc/testingmatrix/calendar'),
                        'icon'        => 'icon-calendar-plus-o',
                        'permissions' => ['bt.qc.documents'],
                        'group'       => 'Lab',
                         'attributes'  => ['Lab'],
                    ],
                    // 'testtypes' => [
                    //     'label'       => 'Test Types',
                    //     'url'         => Backend::url('bt/qc/testtypes'),
                    //     'icon'        => 'icon-list',
                    //     'permissions' => ['bt.qc.lab'],
                    //     'group'       => 'Lab',
                    //      'attributes'  => ['Lab'],
                    // ],
                    'testingmatrix' => [
                        'label'       => 'Testing Matrix',
                        'url'         => Backend::url('bt/qc/testingmatrix'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.qc.lab'],
                        'group'       => 'Lab',
                         'attributes'  => ['Lab'],
                    ],
                    'reqcertificate' => [
                        'label'       => 'Requested Certificates',
                        'url'         => Backend::url('bt/qc/reqcertificate'),
                        'icon'        => 'icon-certificate',
                        'permissions' => ['bt.qc.lab'],
                        'group'       => 'Documents',
                         'attributes'  => ['Documents'],
                    ],
                    'qcreason' => [
                        'label'       => 'QC Reasons',
                        'url'         => Backend::url('bt/qc/qcreason'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.qc.lab'],
                        'group'       => 'Pipe Approval',
                        'attributes'  => ['Pipe Approval'],
                    ],

                ],
            ],
        ];
    }
}
