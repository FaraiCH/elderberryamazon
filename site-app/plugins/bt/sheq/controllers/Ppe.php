<?php namespace Bt\Sheq\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\HR\Models\Department;
use Bt\Sheq\Models\PpeImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use October\Rain\Support\Facades\Flash;

/**
 * Ppe Back-end Controller
 */
class Ppe extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ImportExportController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'ppe');
    }

    public function onImport()
    {
        $path = Input::file('importfile');
        if(isset($path))
        {
            Excel::import(new PpeImport, $path);
            return Flash::success('Succes');
        }

    }
    public function importType()
    {

    }
    public function stats(){
        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'ppestats');

        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");

        $this->pageTitle = "PPE Status";

        $data = array();
        if(\Input::has('department') && \Input::get('department') > 0){
            $dep_id = \Input::get('department');
            $ppe = \Bt\Sheq\Models\Ppe::whereHas('employee', function($query) use($dep_id){
                $query->where('department_id', $dep_id);
            })->get();
            $safety_shoes = 0;
            $safety_glasses  = 0;
            $overall  = 0;
            $gloves  = 0;
            $ear_plugs  = 0;
            $protective_vest  = 0;
            $hard_hat  = 0;
            $tshirt  = 0;
            if(!empty($ppe)){
                foreach ($ppe as $skey => $p) {
                    if ($p->overall == 'Yes')
                    {
                        $overall++;
                        $line = "Overalls";
                        $data[$line] = $overall;
                    }
                    if ($p->safety_shoes == 'Yes')
                    {
                        $safety_shoes++;
                        $line = "Safety Shoes";
                        $data[$line] = $safety_shoes;
                    }
                    if ($p->gloves == 'Yes')
                    {
                        $gloves++;
                        $line = "Hand Gloves";
                        $data[$line] = $gloves;
                    }
                    if ($p->ear_plugs == 'Yes')
                    {
                        $ear_plugs++;
                        $line = "Ear Plugs";
                        $data[$line] = $ear_plugs;
                    }
                    if ($p->protective_vest == 'Yes')
                    {
                        $protective_vest++;
                        $line = "Reflective Vest";
                        $data[$line] = $protective_vest;
                    }

                    if ($p->hard_hat == 'Yes')
                    {
                        $hard_hat++;
                        $line = "Hard Hat";
                        $data[$line] = $hard_hat;
                    }
                    if ($p->safety_glasses == 'Yes')
                    {
                        $safety_glasses++;
                        $line = "Safety Glasses";
                        $data[$line] = $safety_glasses;

                    }
                    if ($p->tshirt == 'Yes')
                    {
                        $tshirt++;
                        $line = "T-Shirt";
                        $data[$line] = $tshirt;
                    }

                }
            }
            $this->vars['xvalue'] = 'PPE Types';
            $this->vars['yvalue'] = 'No of Items';
            $this->vars['title'] = 'PPE Total of Employees';

        }else{
            $ppe = \Bt\Sheq\Models\Ppe::all();
            if(!empty($ppe)){
                foreach ($ppe as $p) {
                    if(isset($p->employee->department->name)){
                        $line = $p->employee->department->name;
                        $data[$line] = isset($data[$line]) ? $data[$line] + 1 : 1;
                    }
                }
            }
            $this->vars['xvalue'] = 'Department';
            $this->vars['yvalue'] = 'No of Employees';
            $this->vars['title'] = 'Employees in Department';
        }


        $stats = array();
        foreach ($data as $name => $arrdata) {
            $content = array();

            $content[] = array($arrdata);
            $stats[] = array('name' =>  $name , 'data' => $content);

        }
        $this->vars['departments'] = Department::all();
        $this->vars['schedules'] = $ppe;
        $this->vars['stats'] = $stats;
        $this->vars['avaragestatus'] = 0;
        $this->vars['scale'] = 0;
    }

}
