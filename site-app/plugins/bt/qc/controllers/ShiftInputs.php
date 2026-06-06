<?php namespace Bt\QC\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\ControlSheetQcItem;
use Bt\Production\Models\ControlSheetitemMaterial;
use Bt\Production\Models\ControlSheet as ModelControlSheet;
use Input;
use Carbon\Carbon;
use Flash;
use Redirect;
use Illuminate\Support\Facades\Session;
/**
 * Shift Inputs Back-end Controller
 */
class ShiftInputs extends Controller
{
     public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = '$/bt/production/controllers/controlsheet/config_relation.yaml';


    public function __construct()
    {
        parent::__construct();
        $this->addJs("https://code.jquery.com/ui/1.13.2/jquery-ui.js", "1.0.1");
        $this->addCss("/plugins/bt/production/assets/css/additional.css", "1.0.4");
        $this->addJs("/plugins/bt/production/assets/js/popthis.js", "1.0.1");
        $this->addJs("/plugins/bt/production/assets/js/scheduleqcinput.js", "1.0.4");
         $this->addCss("//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css", "1.0.4");
        BackendMenu::setContext('Bt.QC', 'qc', 'shiftinputs');
        //Initialize Partial on Load with the controller construct
        $mine = ModelControlSheet::find(\Request::segment('6'));
        $this->vars['control'] = $mine;
        $this->vars['today'] = Carbon::now()->format('Y-m-d');

    }

 public function onSaveCQCTItem(){

        $name = Input::get('name');
        if($name == "new_kg_unit"){

            $cqcitemid = ControlSheetitemMaterial::where('control_sheet_qc_item_id',Input::get('cqcitem'))->where('material_id',Input::get('mat_id'))->first();
            if(empty($cqcitemid)){
                $cqcitemid = new ControlSheetitemMaterial();
                $cqcitemid->material_id = Input::get('mat_id');
                $cqcitemid->control_sheet_qc_item_id = Input::get('cqcitem');

                 \Flash::success( "Created");
            }else{
                 \Flash::success( "Updated");
            }
            $cqcitemid->kg_unit = Input::get('value');
            $cqcitemid->save();
        }else{

            $cqcitemid = ControlSheetQcItem::find(Input::get('cqcitem'));

            if(isset($cqcitemid)){
                $cqcitemid->$name = Input::get('value');
                if(is_numeric($cqcitemid->wall_thikness_n) & is_numeric($cqcitemid->max_wall_ne) & is_numeric($cqcitemid->max_wall_e) & is_numeric($cqcitemid->max_wall_se)
                    & is_numeric($cqcitemid->max_wall_s) & is_numeric($cqcitemid->max_wall_sw) & is_numeric($cqcitemid->min_wall_nw) & is_numeric($cqcitemid->min_wall_w))
                    $cqcitemid->avr_wall = ($cqcitemid->wall_thikness_n + $cqcitemid->max_wall_ne + $cqcitemid->max_wall_e + $cqcitemid->max_wall_se + $cqcitemid->max_wall_s + $cqcitemid->max_wall_sw + $cqcitemid->min_wall_nw + $cqcitemid->min_wall_w)/8;
                $cqcitemid->save();
            }else{

            }

            \Flash::success( "Updated ");
            //Start New Partial to Override Initial Partial on Update
            $this->vars['control'] = ModelControlSheet::find(\Request::segment('6'));
            return [
                '#AVG' => $this->makePartial('avg')
            ];
        }
    }

    public function onCreateCSQCItem(){
        $ci = ModelControlSheet::find(Input::get('cqcid'));
        $time = 6;
        if( $ci->shift == "NIGHT"){
            $time = 18;
        }

        $time = Input::get('time')+$time;
        $t = Carbon::parse($ci->opendate)->setTime($time, 00, 00);
        $cqcitemid = new ControlSheetQcItem();

        $cqcitemid->timeofreading = $t;
        $cqcitemid->controlsheet_id = Input::get('cqcid');

        $cqcitemid->save();
        $_SESSION['cqcitem'] = $cqcitemid->id;
        Flash::success("You are ready to for ".$t->toDateTimeString());
        return Redirect::refresh();
    }

    public function onUpdateCSQCItem(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['cqcitem'] = Input::get('cqcitem');
        $ci = ModelControlSheet::find(Input::get('cqcid'));
          $t = Carbon::parse($ci->opendate);
          Flash::success("You are ready to for ".$t->toDateTimeString());
        return Redirect::refresh();
    }

    public function onSetup(){
        $ci = ModelControlSheet::find(\Request::segment('6'));
        $ci->opendate = Input::get('control_date');
        $ci->shift = Input::get('shift');
        $ci->save();
        $this->vars['formModel'] = $ci;
        Flash::success('Control Sheet input created successfully. You are running ' . Input::get('shift') . ' shift.');
        return \Redirect::refresh();
    }

    public function onSetupEasy(){
        $ci = ModelControlSheet::find(\Request::segment('6'));
        $ci->opendate = Input::get('control_easy_date');
        $ci->shift = Input::get('shift_easy');
        $ci->save();
        $this->vars['formModel'] = $ci;
        Flash::success('Control Sheet input created successfully. You are running ' . Input::get('shift_easy') . ' shift.');
        return \Redirect::refresh();
    }

}
