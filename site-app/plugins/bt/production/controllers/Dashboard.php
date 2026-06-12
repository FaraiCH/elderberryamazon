<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Inventory\Models\CageMaterial as CageModel;
use Bt\Inventory\Models\DailyMaterial as ModelMaterial;
use Bt\Reporting\Models\ViewQuotePerformance as ModelQuotePerform;
use Bt\Reporting\Models\ViewSrnStickerData as ModelSrn;
use Carbon\Carbon;
use Input;

/**
 * Dashboard Backend Controller
 */
class Dashboard extends Controller
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

        BackendMenu::setContext('Bt.Production', 'production', 'dashboard');
    }

    public function view(){
         BackendMenu::setContext('Bt.Production', 'production', 'view');
        $this->pageTitle = "Dashboard";
        $this->addJs("/plugins/bt/production/assets/js/popthis.js", "1.0.0");
        $this->addJs("/plugins/bt/production/assets/js/scheduleinput.js", "1.0.0");
        $this->addCss("/plugins/bt/plcommon/assets/css/customform.css", "1.0.2");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        
        $current = Carbon::today();
        $materials = ModelMaterial::with('dailyincage')
        ->where('datecaptured', '>=',  $current->subDays(7))
        ->orderBy('datecaptured', 'asc')
        ->get();

        $events = [];
        foreach ($materials as $material) {
            $sumKg = $material->dailyincage->sum('kg');
            $desc = "Material Incage: " .  number_format($sumKg, 2, '.', ',') . " KG";

            $events[] = [
                'title' => $desc,
                'start' => $material->datecaptured,
                'color' => 'green',
                'url' => url("/backend/bt/production/dashboard/bydate?date=" . urlencode($material->datecaptured->format("Y-m-d"))),
            ];
        }

        $this->vars['events'] = $events;

    }

    public function bydate()
    {
        $id = \Request::segment(6);

        $mydate = Input::get("date");

        BackendMenu::setContext('Bt.Production', 'production', 'production', 'incage');
        $this->addCss("/plugins/bt/production/assets/css/card.css", "1.0.0");
        $this->pageTitle = "Material Incage ";

        // Retrieve materials with the specified daily material ID
        $material = CageModel::whereDate('datecaptured',$mydate)->get();

        // Retrieve data from ModelQuotePerform,
        $cs = ModelQuotePerform::whereDate('cs_run_date',$mydate)
        ->orderBy('cs_run_date', 'asc')
        ->get();



        // Retrieve data from ModelSrn
        $srn = ModelSrn::whereDate('schedule_date',$mydate)
        ->orderBy('schedule_date', 'asc')
        ->get();


        $totals = [
            'incage' => $material->sum('kg') ?? 0,
            'production_weight' => $cs->sum('totalproductionweight') ?? 0,
            'ordered_weight' => $cs->sum('ordered_totalweight') ?? 0,
            'ordered_cost' => $cs->sum('ordered_totalcost') ?? 0,
        ];




        // Set variables for the view
        $this->vars['srn'] = $srn;
        $this->vars['cs'] = $cs;
        $this->vars['material'] = $material;
        $this->vars['totals'] = $totals;


    }
}
