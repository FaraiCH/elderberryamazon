<?php namespace Bt\Hr\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Policy Backend Controller
 */
class Policy extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.HR', 'hr', 'policy');
    }

    public function listExtendQuery($query, $definition = null)
    {
        if ($this->user->hasPermission(['bt.hr.admin']) || $this->user->is_superuser) {
           $query->where('created_at', '>', 0);
        }
        else{
            $query->where('is_visible', '>', 0);
        }
    }
}
