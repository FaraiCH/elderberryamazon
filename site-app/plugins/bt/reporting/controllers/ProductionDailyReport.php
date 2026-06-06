<?php namespace Bt\Reporting\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
use Input;

use Bt\Production\Models\ProductionPlan as ProductionPlanModel;
use Bt\Reporting\Models\ControlSheetMassData;

/**
 * Production Daily Reports Backend Controller
 */
class ProductionDailyReport extends Controller
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

        BackendMenu::setContext('Bt.Reporting', 'reporting', 'productiondailyreport');
    }

    public function index()
    {
        $this->pageTitle = "Production daily reports";

        // $startDate = Carbon::parse(Carbon::now()->subDays(30)->toDateString()); // start at previous 30 days
        // $endDate = Carbon::parse(Carbon::now()->addDays(7)->toDateString()); // end at next 7 days

        // $dateRange = [];
        // $currentDate = $startDate;

        // while($currentDate->lte($endDate)) {
        //     $dateRange[] = $currentDate->toDateString();
        //     $currentDate->addDay();
        // }

        // $this->vars['currentDate'] = Carbon::today()->toDateString();
        // $this->vars['dateRange'] = $dateRange;
    }

    public function dailyData()
    {
        $this->pageTitle = "Production daily reports data";
        $url_date = Input::get('query');

        $production_plans = ControlSheetMassData::whereDate('cs_run_date', '=', $url_date)
                            ->get();

        $this->vars['url_date'] = $url_date;
        $this->vars['production_plans'] = $production_plans;
    }
}
