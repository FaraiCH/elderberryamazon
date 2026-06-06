<?php namespace Bt\Operator\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\ControlSheetItem;
use Bt\Production\Models\ControlSheetItemMaterial;
use Bt\Production\Models\ControlSheet as ModelControlSheet;
use Input;
use Carbon\Carbon;
use Flash;
use Redirect;
use Illuminate\Support\Facades\Session;
use System\Models\File;

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
        $this->addCss('https://cdn.syncfusion.com/ej2/23.2.4/ej2-base/styles/material.css', "1.0.0");
        $this->addCss('https://cdn.syncfusion.com/ej2/23.2.4/ej2-inputs/styles/material.css', "1.0.0");
        $this->addJs("/plugins/bt/production/assets/js/popthis.js", "1.0.1");
        $this->addJs("/plugins/bt/production/assets/js/scheduleinput.js", "1.0.3");
         $this->addCss("//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css", "1.0.4");
        $this->addJs('https://cdn.syncfusion.com/ej2/23.2.4/dist/ej2.min.js', "1.0.0");
        $this->addJs('https://cdn.syncfusion.com/ej2/syncfusion-helper.js', "1.0.0");
        $this->addJs("/plugins/bt/production/assets/js/signature.js", "1.0.0");
        BackendMenu::setContext('Bt.Operator', 'operator', 'shiftinputs');
        //Initialize Partial on Load with the controller construct
        $mine = ModelControlSheet::find(\Request::segment('6'));
        $this->vars['control'] = $mine;
        $this->vars['today'] = Carbon::now()->format('Y-m-d');

    }

 public function onSaveCTItem(){
        $name = Input::get('name');

        if($name == "new_kg_unit"){

            $citemid = ControlSheetItemMaterial::where('control_sheet_item_id',Input::get('citemid'))->where('material_id',Input::get('mat_id'))->first();
            if(empty($citemid)){
                $citemid = new ControlSheetItemMaterial();
                $citemid->material_id = Input::get('mat_id');
                $citemid->control_sheet_item_id = Input::get('citemid');

                 \Flash::success( "Created");
            }else{
                 \Flash::success( "Updated");
            }
            $citemid->kg_unit = Input::get('value');
            $citemid->save();
        }else{
            $citemid = ControlSheetItem::find(Input::get('citemid'));
            if(isset($citemid)){
                $citemid->$name = Input::get('value');
                if(is_numeric($citemid->wall_thikness_n) & is_numeric($citemid->max_wall_ne) & is_numeric($citemid->max_wall_e) & is_numeric($citemid->max_wall_se)
                    & is_numeric($citemid->max_wall_s) & is_numeric($citemid->max_wall_sw) & is_numeric($citemid->min_wall_nw) & is_numeric($citemid->min_wall_w))
                    $citemid->avr_wall = ($citemid->wall_thikness_n + $citemid->max_wall_ne + $citemid->max_wall_e + $citemid->max_wall_se + $citemid->max_wall_s + $citemid->max_wall_sw + $citemid->min_wall_nw + $citemid->min_wall_w)/8;
                $citemid->save();
            }

            \Flash::success( "Updated");
            //Start New Partial to Override Initial Partial on Update
            $this->vars['control'] = ModelControlSheet::find(\Request::segment('6'));
            return [
                '#AVG' => $this->makePartial('avg')
            ];
        }
    }

    public function onCreateCSItem(){
        $ci = ModelControlSheet::find(Input::get('cid'));
        $time = 6;
        if( $ci->shift == "NIGHT"){
            $time = 18;
        }

        $time = Input::get('time')+$time;
        $t = Carbon::parse($ci->opendate)->setTime($time, 00, 00);
        $citemid = new ControlSheetItem();

        $citemid->timeofreading = $t;
        $citemid->controlsheet_id = Input::get('cid');

        $citemid->save();
        $_SESSION['citem'] = $citemid->id;
        Flash::success("You are ready to for ".$t->toDateTimeString());
        return Redirect::refresh();
    }

    public function onUpdateCSItem(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['citem'] = Input::get('citem');
        $ci = ModelControlSheet::find(Input::get('cid'));
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

    public function onOpSigned(){
        // we assume you post `base64` string in `img`
        $img = Input::get('value');
        if(empty($img)){
            Flash::error("You have not sighed as the Operator ");
        }else{
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $imageData = base64_decode($img);

            // we got raw data of file now we can convert this row data to file in dist and add that to `File` model
            $file = (new File())->fromData($imageData, 'operator_signature.png');

            // attach that $file to Model
            $ci = ModelControlSheet::find(\Request::segment('6'));
            $ci->operator_sign = $file;
            $ci->save();

            Flash::success("Thank you for signing!");
        }


    }

    public function onQCSigned(){
        // we assume you post `base64` string in `img`
        $img = Input::get('value');
        if(empty($img)) {
            Flash::error("You have not sighed as QC");
        }else{
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $imageData = base64_decode($img);

            // we got raw data of file now we can convert this row data to file in dist and add that to `File` model
            $file = (new File())->fromData($imageData, 'qc_signature.png');

            // attach that $file to Model
            $ci = ModelControlSheet::find(\Request::segment('6'));
            $ci->qc_sign = $file;
            $ci->save();
            Flash::success("Thank you for signing!");
        }



    }

    public function onSuoerSigned(){
        // we assume you post `base64` string in `img`
        $img = Input::get('value');
        // we assume you post `base64` string in `img`
        $img = Input::get('value');
        if(empty($img)) {
            Flash::error("You have not sighed as the Supervisor");
        }else{
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $imageData = base64_decode($img);

            // we got raw data of file now we can convert this row data to file in dist and add that to `File` model
            $file = (new File())->fromData($imageData, 'supervisor_signature.png');

            // attach that $file to Model
            $ci = ModelControlSheet::find(\Request::segment('6'));
            $ci->super_sign = $file;
            $ci->save();

            Flash::success("Thank you for signing!");
        }

    }

}
