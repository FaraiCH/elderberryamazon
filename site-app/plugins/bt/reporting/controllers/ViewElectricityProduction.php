<?php namespace Bt\Reporting\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
use BackendAuth;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;

/**
 * View Electricity Production Backend Controller
 */
class ViewElectricityProduction extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        'Backend.Behaviors.ImportExportController',
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_export.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->vars['enddate'] = Carbon::now()->format('Y-m-d');
        $this->vars['startdate'] = Carbon::now()->addDays(-7)->format('Y-m-d');
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");

        BackendMenu::setContext('Bt.Reporting', 'reporting', 'viewelectricityproduction');
    }
    public function onDailyKHWExport()
    {
        $_SESSION['starter'] = \Input::get('startdate');
        $_SESSION['ender'] = \Input::get('enddate');
        Flash::success("Dates are saved. You can now export");
    }
}
