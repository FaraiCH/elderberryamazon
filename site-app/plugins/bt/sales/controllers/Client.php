<?php namespace Bt\Sales\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Client Back-end Controller
 */
class Client extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ImportExportController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();
        //$this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        BackendMenu::setContext('Bt.Sales', 'sales', 'client');
    }
    public function formExtendFields($form)
    {
         if ($this->user->hasPermission(['bt.finance.fin']) || $this->user->hasPermission(['bt.finance.ho'])) {

                $form->addFields([
                'is_blocked' => [
                    'label'   => 'Block Client',
                    'type' => 'switch',
                    'span' => 'auto',
                    'tab' => 'Client',


                    'commentHtml' => true,
                    'comment' => 'Only Finance and Head Office can change this field',
                ],
            ]);

             $form->addFields([
                 'is_cod' => [
                     'label'   => 'COD Client?',
                     'type' => 'switch',
                     'span' => 'auto',
                     'tab' => 'Client',
                     'on' => 'Yes',
                     'off' => 'No',
                     'commentHtml' => true,
                     'comment' => 'Only Finance and Head Office can change this field',
                 ],
             ]);


        }else{
            $form->addFields([
                'is_blocked' => [
                    'label'   => 'Block Client',
                    'type' => 'switch',
                    'span' => 'auto',
                    'tab' => 'Client',
                    'disabled' => true ,
                    'commentHtml' => true,
                    'comment' => 'Only Finance and Head Office can change this field',
                ],
            ]);
             $form->addFields([
                 'is_cod' => [
                     'label'   => 'COD Client?',
                     'type' => 'switch',
                     'span' => 'auto',
                     'tab' => 'Client',
                     'disabled' => true ,
                     'on' => 'Yes',
                     'off' => 'No',
                     'commentHtml' => true,
                     'comment' => 'Only Finance and Head Office can change this field',
                 ],
             ]);
        }
        $form->addFields([
            'blocked_reason' => [
                'label'   => 'Blocked Reason',
                'type' => 'text',
                'span' => 'auto',
            ],
        ]);


    }
}
