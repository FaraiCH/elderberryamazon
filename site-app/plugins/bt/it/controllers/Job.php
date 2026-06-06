<?php namespace Bt\IT\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use Bt\IT\Models\Job as JobModel;
use RainLab\User\Models\UserGroup;

/**
 * Job Back-end Controller
 */
class Job extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.IT', 'it', 'job');
    }

    public function export(){
        $this->pageTitle = "Download Tasks";
        BackendMenu::setContext('Bt.IT', 'it', 'export');
        $IT_group = UserGroup::where('id', 25)->first();
        $this->vars['it_group'] = $IT_group;

    }
}
