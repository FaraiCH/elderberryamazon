<?php namespace Bt\Operator\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Breakdown as ModelBreak;
use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;
use Carbon\Carbon;
use BackendAuth;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;

/**
 * Breakdown Backend Controller
 */
class Breakdown extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        // 'Backend.Behaviors.RelationController'

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

        BackendMenu::setContext('Bt.Operator', 'operator', 'breakdown');
    }
    
}
