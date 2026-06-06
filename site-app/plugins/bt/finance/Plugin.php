<?php namespace Bt\Finance;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;

/**
 * Finance Plugin Information File
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
            'name'        => 'Finance',
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
        BackendMenu::registerContextSidenavPartial('Bt.Finance', 'finance', '$/bt/finance/partials/_sidebar.htm');
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
            'Bt\Finance\Components\MyComponent' => 'myComponent',
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
            'bt.finance.tab' => [
                'tab' => 'Finance',
                'label' => 'Finance Tab'
            ],
            'bt.finance.ho' => [
                'tab' => 'Finance',
                'label' => 'Finance Head office'
            ],
            'bt.finance.linemanager' => [
                'tab' => 'Finance',
                'label' => 'Finance Line Manager'
            ],
            'bt.finance.fin' => [
                'tab' => 'Finance',
                'label' => 'Finance Gail'
            ],
            'bt.finance.approve' => [
                'tab' => 'Finance',
                'label' => 'Petty Cash Approval'
            ],
            'bt.finance.cardrecords' => [
                'tab' => 'Finance',
                'label' => 'Finance Rard Records'
            ],
            'bt.finance.reqList' => [
                'tab' => 'Finance',
                'label' => 'See full Requisition list'
            ]
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
            'finance' => [
                'label'       => 'Finance',
                'url'         => Backend::url('bt/finance/requisition'),
                'icon'        => 'icon-calculator',
                'permissions' => ['bt.finance.*'],
                'order'       => 106,
                'sideMenu' => [
                    'requisition' => [
                        'label'       => 'Requisition',
                        'url'         => Backend::url('bt/finance/requisition'),
                        'icon'        => 'icon-calculator',
                        'permissions' => ['bt.finance.*'],
                        'group'       => 'Requisitions',
                         'attributes'  => ['Requisitions'],
                    ],
                    'requisitionproject' => [
                        'label'       => 'Requisition Projects',
                        'url'         => Backend::url('bt/finance/requisitionproject'),
                        'icon'        => 'icon-bars',
                        'permissions' => ['bt.finance.*'],
                        'group'       => 'Requisitions',
                        'attributes'  => ['Requisitions'],
                    ],'requestpo' => [
                        'label'       => 'Request PO',
                        'url'         => Backend::url('bt/finance/requestpo'),
                        'icon'        => 'icon-file-powerpoint-o',
                        'permissions' => ['bt.finance.*'],
                        'group'       => 'Requisitions',
                        'attributes'  => ['Requisitions'],
                    ],
                    'pettycash' => [
                        'label'       => 'Petty Cash',
                        'url'         => Backend::url('bt/finance/pettycash'),
                        'icon'        => 'icon-credit-card-alt',
                        'permissions' => ['bt.finance.cardrecords'],
                        'group'       => 'Card Records',
                        'attributes'  => ['Card Records'],
                    ],
                    'cardrecords' => [
                        'label'       => 'Petty Cash Records',
                        'url'         => Backend::url('bt/finance/cardrecords'),
                        'icon'        => 'icon-credit-card',
                        'permissions' => ['bt.finance.cardrecords'],
                        'group'       => 'Card Records',
                        'attributes'  => ['Card Records'],
                    ],
                    'paymenttype' => [
                        'label'       => 'Payment Type',
                        'url'         => Backend::url('bt/finance/paymenttype'),
                        'icon'        => 'icon-credit-card-alt',
                        'permissions' => ['bt.finance.cardrecords'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],

                     'project' => [
                        'label'       => 'Projects',
                        'url'         => Backend::url('bt/finance/project'),
                        'icon'        => 'icon-umbrella',
                        'permissions' => ['bt.finance.*'],
                        'group'       => 'Setup',
                         'attributes'  => ['Setup'],
                    ],
                    'currencytype' => [
                        'label'       => 'Currency Type',
                        'url'         => Backend::url('bt/finance/currencytype'),
                        'icon'        => 'icon-cc-visa',
                        'permissions' => ['bt.finance.*'],
                        'group'       => 'Setup',
                        'attributes'  => ['Setup'],
                    ],
                ],
            ],
        ];
    }
}
