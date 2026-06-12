<?php namespace Bt\Boardroom\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Carbon\Carbon;
use BackendAuth;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Bt\Boardroom\Models\Visitor as VisitorModel;

/**
 * Visitor Backend Controller
 */
class Visitor extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->addJs('/plugins/bt/plcommon/assets/ej/ej2/dist/ej2.min.js', "1.0.0");
        $this->addCss('/plugins/bt/plcommon/assets/ej/ej2/bootstrap5.css', "1.0.0");
        if (\Input::has('enddate')) {
            $enddate = \Input::get('enddate');
        } else {
            $enddate = date('Y-m-d');
        }
        if (\Input::has('startdate')) {
            $startdate = \Input::get('startdate');
        } else {
            $startdate = date('Y-m-d', strtotime(date('Y-m-d') . ' - ' . 1 . ' days'));
        }
        $this->vars['startdate'] = $startdate;
        $this->vars['enddate'] = $enddate;

        BackendMenu::setContext('Bt.Boardroom', 'boardroom', 'visitor');
    }
    public function onVisitorExport()
    {
        $_SESSION['starter'] = \Input::get('startdate');
        $_SESSION['ender'] = \Input::get('enddate');
        Flash::success("Dates are saved. You can now export");
    }

    public function onSendInvitation($id = null)
    {
        //Create array to hold email details
        $data = [];

        //get visitors
        $myvisitor = VisitorModel::find($id);
        if (!isset($myvisitor->invited)) {
            $myvisitor->invited = 1;
            $myvisitor->save();
        }
        //Get the app url (This helps when you test locally)
        $url = Config::get('app.url') . '/visitors/induction/' . $myvisitor->id. "/" . $myvisitor->key_pass;
        if (!empty($myvisitor->email)) {
            $data['to_email'] = $myvisitor->email;
            $data['name'] = $myvisitor->visitorname;
            $data['host'] = $myvisitor->hostname;
            $data['url'] = $url;
            //Send Email with data
            \Mail::send('BT.boardroom.invitation.send', $data, function ($message) use ($data) {
                $message->subject("Invitation To BT Industrial Group");
                $message->to($data['to_email'], $data['name']);
            });
            \Flash::success("Your invitation was sent");
            return Redirect::refresh();
        } else {
            \Flash::error("Please make sure you fill in the required fields");
        }
    }

    public function onAccept($id = null)
    {
        $myVisitor = VisitorModel::find($id);
        $myVisitor->accept_date = Carbon::now();
        $myVisitor->save();
        return Redirect::refresh();
    }
}
