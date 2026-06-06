<?php namespace Bt\SHEQ;

use Backend;
use BackendMenu;

use Bt\SHEQ\Classes\SheqSupport;
use System\Classes\PluginBase;

/**
 * SHEQ Plugin Information File
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
            'name'        => 'SHEQ',
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
        BackendMenu::registerContextSidenavPartial('Bt.SHEQ', 'sheq', '$/bt/sheq/partials/_sidebar.htm');
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
       // return []; // Remove this line to activate

        return [
            'Bt\SHEQ\Components\CmAudit' => 'CmAudit',
            'Bt\SHEQ\Components\CmCovid' => 'CmCovid',
            'Bt\SHEQ\Components\Cmquestions' => 'CmQuestions',
            'Bt\SHEQ\Components\Test' => 'CmTest',
            'Bt\SHEQ\Components\Cmanswers' => 'Cmanswers',
            'Bt\Sheq\Components\QuestionnaireCreate' => 'CmQuestionnaireCreate',
            'Bt\Sheq\Components\CmWhistleBlower' => 'CmWhistleBlower',
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
            'bt.sheq.some_permission' => [
                'tab' => 'SHEQ',
                'label' => 'View SHEQ Permisions'
            ],
            'bt.sheq.documents' => [
                'tab' => 'SHEQ',
                'label' => 'Documents Update'
            ],
            'bt.sheq.audits' => [
                'tab' => 'SHEQ',
                'label' => 'Audits'
            ],
            'bt.sheq.driver' => [
                'tab' => 'SHEQ',
                'label' => 'Driver License'
            ],
            'bt.sheq.general' => [
                'tab' => 'SHEQ',
                'label' => 'General'
            ],
            'bt.sheq.medical' => [
                'tab' => 'SHEQ',
                'label' => 'Medical'
            ],
            'bt.sheq.covid' => [
                'tab' => 'SHEQ',
                'label' => 'Covid'
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
            'sheq' => [
                'label'       => 'SHEQ',
                'url'         => Backend::url('bt/sheq/finddoc'),
                'icon'        => 'icon-fire-extinguisher',
                'permissions' => ['bt.sheq.*'],
                'order'       => 500,
                'sideMenu' => [
                    'whistleblower' => [
                        'label'       => 'WhistleBlower',
                        'url'         => Backend::url('bt/sheq/whistleblower'),
                        'icon'        => 'icon-info-circle',
                        'permissions' => ['bt.sheq.whistle'],
                        'group'       => 'Whistle Blower',
                        'attributes'  => ['Whistle Blower'],
                    ],
                    'finddoc' => [
                        'label'       => 'Find Document',
                        'url'         => Backend::url('bt/sheq/document/finddoc'),
                        'icon'        => 'icon-folder-open',
                        'permissions' => ['bt.sheq.*'],
                        'group'       => 'Document',
                        'attributes'  => ['Documents'],
                    ],

                    'document' => [
                        'label'       => 'Document',
                        'url'         => Backend::url('bt/sheq/document'),
                        'icon'        => 'icon-folder-open',
                        'permissions' => ['bt.sheq.documents'],
                        'group'       => 'Document',
                        'attributes'  => ['Documents'],
                    ],
                    'category' => [
                        'label'       => 'Departments & Folders',
                        'url'         => Backend::url('bt/sheq/category'),
                        'icon'        => 'icon-file-text',
                        'permissions' => ['bt.sheq.documents'],
                        'group'       => 'Document',
                        'attributes'  => ['Documents'],
                    ],


                    'quotes' => [
                        'label'       => 'Audits',
                        'url'         => Backend::url('bt/sheq/audits'),
                        'icon'        => 'icon-calendar-check-o',
                        'permissions' => ['bt.sheq.audits'],
                        'group'       => 'Audits',
                        'attributes'  => ['Audits'],
                    ],
                    'training' => [
                        'label'       => 'Training Sessions',
                        'url'         => Backend::url('bt/sheq/training'),
                        'icon'        => 'icon-file-word-o ',
                        'permissions' => ['bt.sheq.general'],
                        'group'       => 'Training',
                        'attributes'  => ['Training'],
                    ],
                    'questions' => [
                        'label'       => 'Questions',
                        'url'         => Backend::url('bt/sheq/question'),
                        'icon'        => 'icon-list-ol',
                        'permissions' => ['bt.sheq.general'],
                        'group'       => 'Training',
                        'attributes'  => ['Training'],
                    ],
                    'questionelement' => [
                        'label'       => 'Question Element',
                        'url'         => Backend::url('bt/sheq/questionelement'),
                        'icon'        => 'icon-list-alt',
                        'permissions' => ['bt.sheq.general'],
                        'group'       => 'Training',
                        'attributes'  => ['Training'],
                    ],
                    'questionnaire' => [
                        'label'       => 'Questionnaire',
                        'url'         => Backend::url('bt/sheq/questionnaire'),
                        'icon'        => 'icon-list-alt',
                        'permissions' => ['bt.sheq.general'],
                        'group'       => 'Training',
                        'attributes'  => ['Training'],
                    ],
                    'employeequestionnaire' => [
                        'label'       => 'Employee Questionnaire',
                        'url'         => Backend::url('bt/sheq/employeequestionnaire'),
                        'icon'        => 'icon-list-alt',
                        'permissions' => ['bt.sheq.general'],
                        'counter' =>    SheqSupport::EmpQuestionCounter(),
                        'group'       => 'Training',
                        'attributes'  => ['Training'],
                    ],
                    //  'employeequetionnaireanswer' => [
                    //     'label'       => 'Employee Quetionnaire Answer',
                    //     'url'         => Backend::url('bt/sheq/employeequetionnaireanswer'),
                    //     'icon'        => 'icon-list-alt',
                    //     'permissions' => ['bt.sheq.general'],
                    //     'group'       => 'Training',
                    //     'attributes'  => ['Training'],
                    // ],
                    'Injuries' => [
                        'label'       => 'Injuries',
                        'url'         => Backend::url('bt/sheq/injuries'),
                        'icon'        => 'icon-ambulance',
                        'permissions' => ['bt.sheq.covid'],
                        'group'       => 'Injuries',
                        'attributes'  => ['Injuries'],
                    ],
                    'Injuriesstats' => [
                        'label'       => 'Injury Stats',
                        'url'         => Backend::url('bt/sheq/injuries/stats'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.sheq.covid'],
                        'group'       => 'Injuries',
                        'attributes'  => ['Injuries'],
                    ],
                    'incident' => [
                        'label'       => 'Incident',
                        'url'         => Backend::url('bt/sheq/incident'),
                        'icon'        => 'icon-eye',
                        'permissions' => ['bt.sheq.covid'],
                        'group'       => 'Incidents',
                        'attributes'  => ['Incidents'],
                    ],
                    'evac' => [
                        'label'       => 'Evacuation Drill',
                        'url'         => Backend::url('bt/sheq/evacuation'),
                        'icon'        => 'icon-building-o',
                        'permissions' => ['bt.sheq.covid'],
                        'group'       => 'Incidents',
                        'attributes'  => ['Incidents'],
                    ],
                    'team' => [
                        'label'       => 'Team Members',
                        'url'         => Backend::url('bt/sheq/team'),
                        'icon'        => 'icon-user',
                        'permissions' => ['bt.sheq.covid'],
                        'group'       => 'Incidents',
                        'attributes'  => ['Incidents'],
                    ],
                    'covid' => [
                        'label'       => 'COVID 19',
                        'url'         => Backend::url('bt/sheq/covidscreens'),
                        'icon'        => 'icon-calendar-check-o ',
                        'permissions' => ['bt.sheq.covid'],
                        'group'       => 'Covid',
                        'attributes'  => ['Covid'],
                    ],
                    'covidsreenstat' => [
                        'label'       => 'COVID Stats',
                        'url'         => Backend::url('bt/sheq/covidscreens/stats'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.sheq.covid'],
                        'group'       => 'Covid',
                        'attributes'  => ['Covid'],
                    ],
                    'ppe' => [
                        'label'       => 'PPE & Uniform',
                        'url'         => Backend::url('bt/sheq/ppe'),
                        'icon'        => 'icon-industry ',
                        'permissions' => ['bt.sheq.general'],
                        'group'       => 'PPE & Uniform',
                        'attributes'  => ['PPE & Uniform'],
                    ],
//                    'ppetype' => [
//                        'label'       => 'Type',
//                        'url'         => Backend::url('bt/sheq/ppetype'),
//                        'icon'        => 'icon-industry ',
//                        'permissions' => ['bt.sheq.general'],
//                        'group'       => 'PPE & Uniform',
//                        'attributes'  => ['PPE & Uniform'],
//                    ],
//                    'ppeimport' => [
//                        'label'       => 'PPE Import',
//                        'url'         => Backend::url('bt/sheq/ppe/importtype'),
//                        'icon'        => 'icon-file-excel-o ',
//                        'permissions' => ['bt.sheq.general'],
//                        'group'       => 'PPE & Uniform',
//                        'attributes'  => ['PPE & Uniform'],
//                    ],
                    'ppestats' => [
                        'label'       => 'PPE & Uniform Stats',
                        'url'         => Backend::url('bt/sheq/ppe/stats'),
                        'icon'        => 'icon-line-chart',
                        'permissions' => ['bt.sheq.general'],
                        'group'       => 'PPE & Uniform',
                        'attributes'  => ['PPE & Uniform'],
                    ],
                    'driver' => [
                        'label'       => 'Forklift Driver License',
                        'url'         => Backend::url('bt/sheq/driver'),
                        'icon'        => 'icon-industry ',
                        'permissions' => ['bt.sheq.general'],
                        'group'       => 'Drivers',
                        'attributes'  => ['Drivers'],
                    ],
                    'driverstats' => [
                        'label'       => 'Forklift Driver Stats',
                        'url'         => Backend::url('bt/sheq/driver/stats'),
                        'icon'        => 'icon-line-chart ',
                        'permissions' => ['bt.sheq.driver'],
                        'group'       => 'Drivers',
                        'attributes'  => ['Drivers'],
                    ],
                    'medical' => [
                        'label'       => 'Medicals',
                        'url'         => Backend::url('bt/sheq/medical'),
                        'icon'        => 'icon-ambulance ',
                        'permissions' => ['bt.sheq.medical'],
                        'group'       => 'Medical',
                        'attributes'  => ['Medical'],
                    ],
//                    'supplier' => [
//                        'label'       => 'Medical Suppliers',
//                        'url'         => Backend::url('bt/sheq/supplier'),
//                        'icon'        => 'icon-credit-card-alt',
//                        'permissions' => ['bt.sheq.*'],
//                        'group'       => 'Medical',
//                        'attributes'  => ['Medical'],
//                    ],
//                    'supplierimport' => [
//                        'label'       => 'Medical Suppliers Import',
//                        'url'         => Backend::url('bt/sheq/supplier/importtype'),
//                        'icon'        => 'icon-credit-card-alt',
//                        'permissions' => ['bt.sheq.*'],
//                        'group'       => 'Medical',
//                        'attributes'  => ['Medical'],
//                    ],
                    'fire' => [
                        'label'       => 'Fire Hydrant',
                        'url'         => Backend::url('bt/sheq/fire'),
                        'icon'        => 'icon-fire ',
                        'permissions' => ['bt.sheq.general'],
                        'group'       => 'Fire',
                        'attributes'  => ['Fire'],

                    ],

                ]
            ],

        ];
    }
}
