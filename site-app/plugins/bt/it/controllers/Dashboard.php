<?php namespace Bt\It\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bt\IT\Models\TicketStage;

/**
 * Dashboard Backend Controller
 */
class Dashboard extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bt.IT', 'it', 'dashboard');
    }

    public function index()
    {
        // load css file from controller method
        $this->addCss("/plugins/bt/it/assets/css/ticket.css", "1.0.0");

        // load js file from controller method
        $this->addJs("/plugins/bt/it/assets/js/ticket.js", "1.0.0");

        // set page title from controller
        $this->pageTitle = "Dashboard";

        // query model and eager load relation data
        $this->vars['ticketStages'] = TicketStage::with([
                                        'jobs',
                                        'jobs.responder',
                                        'jobs.toemployee',
                                        'jobs.project',
                                        'jobs.type',
                                        'jobs.status',
                                        'jobs.department',
                                        'jobs.createdby',
                                        'jobs.updatedby',
                                        'jobs.ticketstage',
                                        'jobs.assignedto'
                                    ])->get()->toArray();
    }
}
