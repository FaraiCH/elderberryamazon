<?php namespace Bt\Production\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Inventory\Models\PartNames;
use Bt\Production\Models\Materials;
use Bt\Production\Models\Line as LineModel;
use Bt\Production\Models\Schedule as ScheduleModel;
use Carbon\Carbon;

use Auth;
use Flash;
use Input;
Use Validator;
use Redirect;
use ValidationException;
use Http;
use Config;

/**
 * Pipe Back-end Controller
 */
class Pipe extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Production', 'production', 'pipe');
    }

     public function onCreateSchedule(){

        $pipe = PipeModel::find(Input::get('id'));

        #loop start date to end date
        if($pipe->start_date){
            $totalmass = $pipe->quoteitems->units * $pipe->pipe_target_weight;

            $effective_production_rate =  (($pipe->production_rate*($pipe->target_availability/100)*(1-($pipe->target_scrap_rate/100))));

            $productiondays = 1;
            $dailproduction = $effective_production_rate * 24;
            $count = 0;
            for ($i=0; $i < $productiondays ; $i++) {
                $sc = new ScheduleModel();
                $date = new Carbon($pipe->start_date);
                $sc->user_id = 1;
                $sc->pipe_id = $pipe->id;
                $sc->production_days = $i+1;
                $sc->production_date = $date->addDay($i);
                $sc->target_kg_processed = $dailproduction;
                if($pipe->pipe_target_weight > 0){
                    $sc->target_units_produced = $dailproduction/$pipe->pipe_target_weight;
                }else{
                    $sc->target_units_produced = 1;
                }

                $sc->save();
                $count++;
            }

            if($count > 0){
                Flash::success("Your post was updated succesfully..");
                  return Redirect::refresh();
            }else{
                Flash::error("2. Schedule could not be created...");
            }

        }else{
            Flash::error("no start date".$pipe->start_date);
        }

    }
}
