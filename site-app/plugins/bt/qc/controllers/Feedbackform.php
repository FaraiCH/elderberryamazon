<?php namespace Bt\QC\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend\Facades\BackendAuth;
use Backend\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Flash;
use janvince\smallcontactform\Models\Message as clientReview;

/**
 * Feedbackform Back-end Controller
 */
class Feedbackform extends Controller
{

    public $pageTitle = "Feedback Form";

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bt.QC', 'qc', 'feedbackform');
    }

    public function index() // folder of the views has to have same name as this class in order to work
    {
        $this->vars['messages'] = clientReview::all();
    }
}