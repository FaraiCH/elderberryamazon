<?php namespace Bt\Floor\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Schedule as ScheduleModule;
use Bt\Floor\Models\DeliveryScrapPipe as DeliveryScrapPipeModule;
use Bt\Floor\Models\Scrappipe as ScrapPipeModel;


/**
 * Delivery Scrap Pipe Back-end Controller
 */
class DeliveryScrapPipe extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Floor', 'floor', 'deliveryscrappipe');
    }

    public function formExtendFields($form)
    {
        $obj = ScheduleModule::active()->get();
        $del_obj = DeliveryScrapPipeModule::all();
        $manual_scrap = ScrapPipeModel::all();
        $sum = ($obj->sum('weight_scrap_kg')  + $manual_scrap->sum('weight_kg')) - $del_obj->sum('weight_kg');
          $form->addFields([
            'weight_kg' => [
                'label'   => 'Weight In KG',
                'type' => 'number',
                'span' => 'left',
                'min' => 0,
                'max' => $sum,
                'commentHtml' => true, 
                'comment' => 'Weight of scrap on the floor. Max crap is: <b style="color: red">'.$sum.'</b> kg',
            ],
        ]);
    }
}
