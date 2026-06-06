<?php namespace Bt\Sheq\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Driver Back-end Controller
 */
class Driver extends Controller
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

        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'driver');
    }

    public function formAfterSave($model)
    {
        if (isset($model->expiry))
        {
            $model->status = 1;
            $model->save();
        }
    }
    public function stats(){

        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales');
        $this->addJs("/plugins/bt/sheq/assets/js/backend_formfilter.js", "1.0.0");
        $this->addCss("//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "1.0.1");

        $this->pageTitle = "Driver License Status";
        BackendMenu::setContext('Bt.SHEQ', 'sheq', 'driverstats');


        $driver = \Bt\Sheq\Models\Driver::all();
        $data = array();
        $issue = 0;
        $expiry = 0;
        $pending = 0;
        $expire = 0;
        foreach ($driver as $skey => $p) {

            if (!empty($p->issue))
            {
                if(empty($p->expiry))
                {
                    $issue++;
                    $line = "Active";
                    $data[$line] = $issue;
                }

            }
            if (!empty($p->expiry))
            {
                $expiry++;
                $line = "Expired";
                $data[$line] = $expiry;
            }

        }

        $stats = array();
        foreach ($data as $name => $arrdata) {
            $content = array();
            $content[] = array($arrdata);
            $stats[] = array('name' =>  $name , 'data' => $content);

        }

        $this->vars['schedules'] = $driver;
        $this->vars['stats'] = $stats;
    }
}
