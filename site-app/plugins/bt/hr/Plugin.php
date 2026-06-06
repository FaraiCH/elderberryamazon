<?php namespace Bt\HR;

use Backend;
use Bt\HR\Controllers\Employee;
use Bt\Hr\Models\Jobdescription;
use Bt\Hr\Models\Policy;
use RainLab\User\Controllers\Users;
use RainLab\User\Models\User;
use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use BackendMenu;
/**
 * HR Plugin Information File
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
            'name'        => 'HR',
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

         BackendMenu::registerContextSidenavPartial('Bt.HR', 'hr', '$/bt/hr/partials/_sidebar.htm');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    protected function extendUserModel()
    {
         UserModel::extend(function($model) {
            $model->belongsTo['employee'] = ['Bt\HR\Models\Employee','key'=>'email','otherKey'=>'email' ];
        });
        \Event::listen('backend.form.extendFields', function($widget){

            //Extend groups controller
            if (!$widget->getController() instanceof Users) return;
            if (!$widget->model instanceof User) return;

//            $widget->addFields([
//                'employee[phone]' => [
//                    'label' => 'Phone',
//                    'comment' => 'Type Phone number',
//                    'type' => 'number',
//                    'span' => 'auto'
//                ]
//            ]);
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
            'Bt\HR\Components\CmEmployee' => 'CmEmployee',
            'Bt\HR\Components\Birthday' => 'CmBirthday',
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
            'bt.hr.manage' => [
                'tab' => 'HR',
                'label' => 'HR Functions'
            ],
            'bt.hr.admin' => [
                'tab' => 'HR',
                'label' => 'HR Admin'
            ],
            'bt.hr.rates' => [
                'tab' => 'HR',
                'label' => 'HR Rates Per Hour'
            ],
            'bt.hr.developer' => [
                'tab' => 'HR',
                'label' => 'Developer Admin'
            ],
            'bt.hr.stats' => [
                'tab' => 'HR',
                'label' => 'Wage Bill Statistics'
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
        $job_description  = Jobdescription::all();
        $policies = Policy::all();
        $uploads = [
            'hr' => [
                'label'       => 'HR',
                'url'         => Backend::url('bt/hr/employee'),
                'icon'        => 'icon-leaf',
                'permissions' => ['bt.hr.manage'],
                'order'       => 108,
                'sideMenu' => [
                    'quotes' => [
                        'label'       => 'Employees',
                        'url'         => Backend::url('bt/hr/employee'),
                        'icon'        => 'icon-users',
                        'permissions' => ['bt.hr.manage'],
                        'group'       => 'Employees',
                        'attributes'  => ['Employees'],
                    ],
                    'ethnicity' => [
                        'label'       => 'Ethnicity',
                        'url'         => Backend::url('bt/hr/ethnicity'),
                        'icon'        => 'icon-user',
                        'permissions' => ['bt.hr.manage'],
                        'group'       => 'Employees',
                        'attributes'  => ['Employees'],
                    ],

                    'Incidents' => [
                        'label'       => 'Incidents',
                        'url'         => Backend::url('bt/hr/Incidents'),
                        'icon'        => 'icon-bullhorn',
                        'permissions' => ['bt.hr.manage'],
                        'group'       => 'Employees',
                        'attributes'  => ['Employees'],
                    ],

                    'AbsenceLeave' => [
                        'label'       => 'Absence/Leave',
                        'url'         => Backend::url('bt/hr/AbsenceLeave'),
                        'icon'        => 'icon-exchange',
                        'permissions' => ['bt.hr.manage'],
                        'group'       => 'Employees',
                        'attributes'  => ['Employees'],
                    ],

                    'Training' => [
                        'label'       => 'Training',
                        'url'         => Backend::url('bt/hr/Training'),
                        'icon'        => 'icon-handshake-o',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Employees',
                        'attributes'  => ['Employees'],
                    ],

                    'weeklyhour' => [
                        'label'       => 'Weekly Hours',
                        'url'         => Backend::url('bt/hr/weeklyhour'),
                        'icon'        => 'icon-sort-numeric-asc',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Employees',
                        'attributes'  => ['Employees'],
                    ],
                    'stats' => [
                        'label'       => 'Wages Stats',
                        'url'         => Backend::url('bt/hr/wagebill/stats'),
                        'icon'        => 'icon-dashboard',
                        'permissions' => ['bt.hr.stats'],
                        'group'       => 'Wages',
                        'attributes'  => ['Wages'],
                    ],

                    'hoursinput' => [
                        'label'       => 'Wages Input',
                        'url'         => Backend::url('bt/hr/wagebill/hoursinput'),
                        'icon'        => 'icon-calendar-plus-o',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Wages',
                        'attributes'  => ['Wages'],
                    ],

                    'wagebill' => [
                        'label'       => 'Wage Bill',
                        'url'         => Backend::url('bt/hr/wagebill'),
                        'icon'        => 'icon-money',
                        'permissions' => ['bt.hr.admin'],
                        'group'       => 'Wages',
                        'attributes'  => ['Wages'],
                    ],
                    'policy' => [
                        'label'       => 'Policy and Procedures',
                        'url'         => Backend::url('bt/hr/policy'),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Policies',
                        'attributes'  => ['Policies'],
                    ],
                    'jobdescription' => [
                        'label'       => 'Job Description',
                        'url'         => Backend::url('bt/hr/jobdescription'),
                        'icon'        => 'icon-address-book',
                        'permissions' => ['bt.hr.manage'],
                        'group'       => 'Policies',
                        'attributes'  => ['Policies'],
                    ],
                    'employeecontract' => [
                        'label'       => 'Employement Contract',
                        'url'         => Backend::url('bt/hr/employeecontract'),
                        'icon'        => 'icon-address-book',
                        'permissions' => ['bt.hr.manage'],
                        'group'       => 'Policies',
                        'attributes'  => ['Policies'],
                    ],
                    'weeklyhourgraph' => [
                        'label'       => 'Weekly Hour Graph',
                        'url'         => Backend::url('bt/hr/weeklyhour/graph'),
                        'icon'        => 'icon-bar-chart',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Employees',
                        'attributes'  => ['Employees'],
                    ],
                    'Department' => [
                        'label'       => 'Departments',
                        'url'         => Backend::url('bt/hr/Department'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                    'Designation' => [
                        'label'       => 'Designations',
                        'url'         => Backend::url('bt/hr/Designation'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                    'TrainingType' => [
                        'label'       => 'Training Type',
                        'url'         => Backend::url('bt/hr/TrainingTYpe'),
                        'icon'        => 'icon-list',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                ],
            ],
        ];
        $count = 1;
        foreach($job_description as $job){
            foreach($job->description_file as $file){
                if($job->rev > 0){
                    $uploads['hr']['sideMenu'][$job->name] = [
                        'label'       => $job->name .' (Revision: '. $job->rev . ')',
                        'url'         => $file->getPath(),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Job Description Docs',
                        'attributes'  => ['Job Description Docs'],
                    ];
                }else{
                    $uploads['hr']['sideMenu'][$job->name] = [
                        'label'       => $job->name,
                        'url'         => $file->getPath(),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Job Description Docs',
                        'attributes'  => ['Job Description Docs'],
                    ];
                }

            }
        }
        $pol_count = 0;
        foreach ($policies as $pol){
            foreach($pol->attach_file as $file){
                if($pol->rev > 0){
                    $uploads['hr']['sideMenu'][$pol->name] = [
                        'label'       => $pol->name .' (Revision: '. $pol->rev . ')',
                        'url'         => $file->getPath(),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Policies Docs',
                        'attributes'  => ['Policies Docs'],
                    ];
                }else{
                    $uploads['hr']['sideMenu'][$pol->name] = [
                        'label'       => $pol->name,
                        'url'         => $file->getPath(),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['bt.hr.*'],
                        'group'       => 'Policies Docs',
                        'attributes'  => ['Policies Docs'],
                    ];
                }

            }
        }
        return $uploads;
    }
}
