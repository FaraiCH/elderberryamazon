<?php namespace Bt\Logistics\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Sales\Models\Srn as SrnModel;
use Input;
use Carbon\Carbon;
use Flash;
use Redirect;
use Illuminate\Support\Facades\Session;

/**
 * Stockrelease Backend Controller
 */
class Stockrelease extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = '$/bt/sales/controllers/srn/stock_config_relation.yaml';


    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Logistics', 'logistics', 'stockrelease');
        // $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        $this->addJs("/plugins/bt/production/assets/js/popthis.js", "1.0.0");
        $this->addJs("/plugins/bt/production/assets/js/scheduleinput.js", "1.0.0");



         #Add CSS
        // $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.0");
        // $this->addCss("/plugins/bt/sales/assets/css/backlaout.css", "1.0.0");
        // $this->addCss("/plugins/bt/sales/assets/css/dataTables.bootstrap5.min.css", "1.0.0");
        // $this->addCss("/plugins/bt/sales/assets/css/responsive.bootstrap5.min.css", "1.0.0");
        // $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");

        #Add JS
        // $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        // $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        // $this->addJs("/plugins/bt/sales/assets/js/backlaout.js", "1.0.0");
        // $this->addJs("/plugins/bt/sales/assets/js/datatables.min.js", "1.0.0");
        // $this->addJs("/plugins/bt/sales/assets/js/dataTables.bootstrap5.min.js", "1.0.0");
        // $this->addJs("/plugins/bt/sales/assets/js/dataTables.responsive.min.js", "1.0.0");
        // $this->addJs("/plugins/bt/sales/assets/js/responsive.bootstrap5.min.js", "1.0.0");

        $this->addCss("/plugins/bt/plcommon/assets/css/customform.css", "1.0.2");
    }

    public function onSaveCTItem()
    {
        $name = Input::get('name');
        $citemid = SrnModel::find(Input::get('citemid'));
        $citemid->$name = Input::get('value');
        $citemid->save();
        \Flash::success("Updated");
    }
}
