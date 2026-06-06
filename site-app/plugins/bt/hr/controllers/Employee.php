<?php namespace Bt\HR\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\HR\Models\Leavetype as LeaveTypeModel;
use Bt\Hr\Models\Ethnicity;
use Illuminate\Support\Facades\Session;

/**
 * Employee Back-end Controller
 */
class Employee extends Controller
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

        BackendMenu::setContext('Bt.HR', 'hr', 'employee');
        $this->vars['leaves'] = LeaveTypeModel::all();
        $this->vars['ethnicity'] = Ethnicity::all();
    }

    function reverse_birthday( $years ){
        return date('Y-m-d', strtotime($years . ' years ago'));
    }

    public function onEmployeeFilter(){
        if(!empty(\Input::get('age')))
            $_SESSION['age'] = $this->reverse_birthday(\Input::get('age'));
        $_SESSION['active'] = \Input::get('active');
        $_SESSION['age_format'] = \Input::get('age_format');
        $_SESSION['gender'] = \Input::get('gender');
        $_SESSION['ethnicity'] = \Input::get('ethnicity');
        \Flash::success('Filters Applied');
    }

    public function listExtendQuery($query, $definition)
    {
        if(!$this->user->hasAccess('bt.hr.developer')){
            $query->where('is_user_active', 1);
        }
    }
}
