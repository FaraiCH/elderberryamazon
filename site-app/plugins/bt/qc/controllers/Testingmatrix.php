<?php namespace Bt\QC\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Backend\Facades\BackendAuth;
use Backend\Models\User;

use Bt\QC\Models\TestingMatrix as TestingMatrixModel;

use Flash;
/**
 * Testingmatrix Back-end Controller
 */
class Testingmatrix extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.QC', 'qc', 'testingmatrix');


    }

    public function calendar(){
        BackendMenu::setContext('Bt.QC', 'qc', 'matrixcalender');
        $this->pageTitle = "Matrix Calender | QC";
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/core/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/daygrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/timegrid/main.css", "1.0.0");
        $this->addCss("/themes/hambern-hambern-blank-bootstrap-4/assets/packages/list/main.css", "1.0.0");

        $current = Carbon::now();
        $events = array();
        $obj = TestingMatrixModel::all();
        foreach ($obj as $key => $value) {
              $color = '#4497e0';
              $date=date_create($value->test_date);
              $desc = "";


              if ($value->testtype->name == 'MFI')
                  $desc = $value->mfibatch_no_id;

              # 'Thermal Revision'
              if ($value->testtype->name == 2)
                  $desc = $value->therm_material_batch	;

              if ($value->testtype->name == 'Elongation')
                  $desc = 	$value->tensile_material_batch	;
              
              if ($value->testtype->name == 'OIT')
                  $desc = 	$value->oit_material_batch;

              if ($value->testtype->name == 'Hydrostatic') 
              {
                  if ($value->hydrotype == 0) {
                      $desc = 	$value->hydro100_pipebatch_no	;
                  }
                  if ($value->hydrotype == 1) {
                      $desc = 	$value->hydro165_pipebatch_no	;
                  }
                  if ($value->hydrotype == 2) {
                      $desc = 	$value->hydro1k_pipebatch_no	;
                  }
                  
              }

              if ($value->testtype->name == 'Carbon Black') 
              {
                  if ($value->carbon_type == 0) {
                      $desc = 	$value->content_material_batch	;
                  }
                  if ($value->carbon_type == 1) {
                      $desc = 	$value->dispersion_material_batch	;
                  }
              }

              if ($value->testtype->name == 'Density')
                  $desc = 	$value->density_material_batch;
          
            $events[] =  array('title' => ("#".$value->id." ".$value->testtype->name." / ".$desc." (".date_format($date,"Y/m/d ").")"), 'start'=> $value->test_date,'color'=>$color,"url"=> "/admin/bt/qc/testingmatrix/update/".$value->id );
        }

        $this->vars['events'] = $events;
        $current = Carbon::now();
        $this->vars['today'] = TestingMatrixModel::all();

    }
}
