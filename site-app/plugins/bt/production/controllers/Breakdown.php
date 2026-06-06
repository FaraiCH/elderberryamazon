<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Breakdown Backend Controller
 */
class Breakdown extends Controller
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

        BackendMenu::setContext('Bt.Production', 'production', 'breakdown');
    }

    // Hide record when status Id == 5 as completed
    public function listExtendQuery($query, $definition = null)
    {
        $query->whereHas('mainjobcard', function ($q) {
            $q->where('status_id', '<>', 5);
        });
    }
}
