<?php

use Illuminate\Http\Request;
use Bt\Sales\Models\Srn as ModelSrn;
use Bt\Production\Models\Push as PushModel;
use Bt\Sales\Models\Invoice as InvoiceModel;
use Bt\Inventory\Models\RawMaterialReceiving as MaterialModel;
use Bt\Production\Models\Schedule as ScheduleModel;
use Bt\Logistics\Models\Schedule as DeliverySchedule;
use Bt\Production\Models\Jobcard as JobCardModel;
use Bt\Production\Models\ControlSheet as Control;
use Bt\Production\Models\ControlSheetItem as ControlItem;
use Bt\Sales\Models\Newquote as Quote;
use Bt\Sales\Models\Quoteitems as QItems;
use Bt\Maintenance\Models\Electricity as Electricity;
use Bt\Production\Models\Breakdown;
use RainLab\User\Models\User;
use Bt\It\Models\TicketStage;
use Renatio\DynamicPDF\Classes\PDF;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::any('/api/v1/get/srns', function () {
	return response()->json(ModelSrn::where('created_at', '>', '2019-12-31 23:59:00')->get());
});


Route::any('/api/v1/get/production', function () {
	return response()->json(PushModel::where('created_at', '>', '2019-12-31 23:59:00')->get());
});


Route::any('/api/v1/get/invoice', function () {
	return response()->json(InvoiceModel::where('created_at', '>', '2019-12-31 23:59:00')->with("srn")->with('quote')->get());
});

Route::any('/api/v1/get/invoice/{id}', function ($id) {
    return response()->json(InvoiceModel::with("srn")->with('quote')->find($id));
});

Route::any('/api/v1/get/quote/{id}', function ($id) {
    return response()->json(Quote::with("srn")->with('items')->with('invoice')->with('client')->find($id));
});

Route::any('/api/v1/get/srn/{id}', function ($id) {
    return response()->json(ModelSrn::with("quote")->with('srninvoice')->with('items')->with('itemscat')->with('client')->find($id));
});


Route::any('/api/v1/get/material_released', function () {
    return response()->json(MaterialModel::where('created_at', '>', '2019-12-31 23:59:00')->get());
});

Route::any('/api/v1/get/schedule', function () {
    return response()->json(ScheduleModel::where('created_at', '>', '2019-12-31 23:59:00')->get());
});

Route::any('/api/v1/get/delivery_schedule', function () {
    return response()->json(DeliverySchedule::where('created_at', '>', '2019-12-31 23:59:00')->get());
});

Route::any('/api/v1/get/production_jobcard', function () {
    return response()->json(JobCardModel::where('created_at', '>', '2019-12-31 23:59:00')->get());
});


Route::any('/api/v1/get/controlsheet', function () {
    return response()->json(Control::where('created_at', '>', '2019-12-31 23:59:00')->get());
});

Route::any('/api/v1/get/controlsheet_item', function () {
    return response()->json(ControlItem::where('created_at', '>', '2019-12-31 23:59:00')->get());
});

Route::any('/api/v1/get/quote', function () {
    return response()->json(Quote::where('created_at', '>', '2019-12-31 23:59:00')->get());
});

Route::any('/api/v1/get/quote_item', function () {
    return response()->json(QItems::where('created_at', '>', '2019-12-31 23:59:00')->get());
});

Route::any('/api/v1/get/electricity', function () {
    return response()->json(Electricity::where('created_at', '>', '2019-12-31 23:59:00')->with('meter')->get());
});

Route::any('/api/v1/get/baila/breakdown', function () {
    return response()->json(Breakdown::where('created_at', '>', '2019-12-31 23:59:00')->with(['mainjobcard', 'btline', 'breakdown', 'controlsheets'])->get());
});
// // Route::middleware('jwt.auth')->get('/user', function (Request $request) {
// // 	return $request->user();
// //        });
// // Route::middleware('jwt.auth')->get('/test', function (Request $request) {
// // 	return ['Test' => "Test New"];
// //        });

// Route::post('/login', 'ApiLoginController@login');


// Route::middleware('jwt.auth')->resource('/campaign/calendar', 'CalMainController');

// Route::middleware('jwt.auth')->get('/pull/events', 'ApiCampaignController@pullEvents');
// Route::middleware('jwt.auth')->get('/pull/calendars', 'ApiCampaignController@pullCalender');
// Route::middleware('jwt.auth')->get('/pull/questions', 'ApiCampaignController@pullQuestions');
// Route::middleware('jwt.auth')->get('/pull/questioncategory', 'ApiCampaignController@pullQuestionCategory');
// Route::middleware('jwt.auth')->get('/pull/questionsession', 'ApiCampaignController@pullQuestionSession');
// Route::middleware('jwt.auth')->get('/pull/questiontype', 'ApiCampaignController@pullQuestionType');
// Route::middleware('jwt.auth')->get('/pull/staffrole', 'ApiCampaignController@pullStaffrole');
// Route::middleware('jwt.auth')->get('/pull/venues', 'ApiCampaignController@pullVenues');
// Route::middleware('jwt.auth')->get('/pull/idno', 'ApiCampaignController@pullIDNo');
// Route::middleware('jwt.auth')->get('/pull/myanswers', 'ApiCampaignController@pullMyAnswers');
// Route::middleware('jwt.auth')->post('/push/answers', 'ApiCampaignController@pushAnswers');
// Route::middleware('jwt.auth')->post('/push/image', 'ApiCampaignController@pushAnswerImage');

Route::any('/backend/bt/it/job/task/download/{id}', function ($id) {
    $user = User::find($id);
    $stages = TicketStage::all();
    $pdf = PDF::loadView('bt.it::pdfTasks',array('user'=>$user, 'stages' => $stages));
    return $pdf->setPaper('a2', 'landscape')->stream();
});
