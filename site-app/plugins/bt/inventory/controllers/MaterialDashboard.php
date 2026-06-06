<?php namespace Bt\Inventory\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Material Dashboard Backend Controller
 */
class MaterialDashboard extends Controller
{

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.Inventory', 'inventory', 'materialdashboard');
    }

    public function index()
    {
        // set page title from controller
        $this->pageTitle = "Material Dashboard";

    }
}
