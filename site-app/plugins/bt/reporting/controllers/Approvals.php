<?php namespace Bt\Reporting\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\Production\Models\Push as PushModel;
use Bt\Sales\Models\Srn as SrnModel;


class Approvals extends Controller
{
    

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bt.Reporting', 'reporting', 'batchsearch');
    }

    public function list()
    {

        BackendMenu::setContext('Bt.Reporting', 'reporting', 'list');
        $this->pageTitle = "Approvals";

        $this->vars['batches'] = PushModel::whereHas('approved', function ($query) {
   				$query->where('status_id', '>=',0);
			})->orderBy('id', 'DESC')->get()->take(30);

        $this->vars['srnapprov'] = SrnModel::whereHas('srnapprove', function ($query) {
   				$query->where('status_id', '>=',0);
			})->orderBy('id', 'DESC')->get()->take(30);

      
    }
}
