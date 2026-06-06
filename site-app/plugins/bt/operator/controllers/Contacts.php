<?php namespace  Bt\Operator\Controllers;


use Backend\Classes\Controller;
use Backend\Facades\BackendAuth;
use Backend\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Bt\HR\Models\Employee as EmployeeModel;

use BackendMenu;
use Flash;


class Contacts extends Controller
{
    public $pageTitle = "Operator";

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bt.Operator', 'operator','contacts'); // has to be uppercase plugin name always
    }

    public function index() // folder of the views has to have same name as this class in order to work
    {
        $this->vars['employees'] = EmployeeModel::where("is_emergency",'=',1)->get();
    }

   
}