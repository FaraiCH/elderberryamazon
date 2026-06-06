<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RainLab\User\Models\User;
use \Carbon\Carbon;
use \Bt\Production\Models\ProductionPlan;
use \Bt\Production\Models\ControlSheet;
Route::post('/api/v1/sticker/login', function (Request $request) {
    try {
        if ($request->has('login')) {
            $user = User::where('email', $request->input('login'))->first();
            if ($user && $request->has('password')) {
                if (Hash::check($request->input('password'), $user->password)) {
                    return response()->json(['user_id' => $user->id], 200);
                } else {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            } else {
                return response()->json(['error' => 'No Password Supplied'], 401);
            }
        } else {
            return response()->json(['error' => 'No Login Supplied'], 401);
        }
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 401);
    }
});

Route::get('/api/v1/sticker/baila-list', function (){
    return \Bt\Production\Models\Line::orderBy('sort_order')->get();
});

Route::post('/api/v1/sticker/control-list', function (Request $request) {
    try {
        if ($request->has('bailaLine')) {
            $bailaMachine = $request->input('bailaLine');
            return \Bt\Production\Models\ControlSheet::with(['btline', 'plan', 'planitem'])->whereHas('btline', function ($query) use ($bailaMachine){
                $query->where('name', $bailaMachine);
//            })->where('opendate', \Carbon\Carbon::today())->get();
            })->where('opendate','>', '2024-01-01')->get();
        } else {
            return response()->json(['error' => 'No Line Supplied'], 401);
        }
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 401);
    }
});
Route::get('/api/v1/sticker/control-sheet/{id}', function ($id) {
    try {
        if(isset($id)){
            return \Bt\Production\Models\ControlSheet::where('id',$id)->with(['btline', 'plan', 'planitem'])->get();
        } else {
            return response()->json(['error' => 'No Control Sheet Supplied'], 401);
        }
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 401);
    }
});

Route::get('/api/v1/sticker/plans', function () {
    try
    {
        return ControlSheet::whereHas('plan', function ($query){
            $query->where('startdate', '>=', Carbon::now()->subDay())->where('enddate', '<=', Carbon::now());
        })->with(array('plan' => function($query) {
            $query->with('planitems')->with('planitemscat');
        }))->orderBy('id', 'DESC')->get();
    }
    catch (Exception $e)
    {
        return response()->json(['error' => $e->getMessage()], 401);
    }
});
Route::post('/api/v1/sticker/production/save-request', function (Request $request){
    try
    {
        if($request->has('stickerNoOne') && $request->has('stickerNoTwo'))
        {
            if($request->has('controlsheet_no'))
            {
                if(!$request->has('weight'))
                {
                    return response()->json(['error' => 'No Weight'], 401);
                }

                if(!$request->has('weight'))
                {
                    return response()->json(['error' => 'No Length'], 401);
                }
                $pipesticker = \Bt\Production\Models\Pipestickeritem::where('sticker_id', $request->input('stickerNoOne'))->where('counter',  $request->input('stickerNoTwo'))->first();
                $pipesticker->sticker_id =  $request->input('stickerNoOne');
                $pipesticker->counter = $request->input('stickerNoTwo');
                $pipesticker->controlsheet_id = $request->input('controlsheet_no');
                $pipesticker->production_date = now();
                $pipesticker->save();
                return response()->json(['success' => 'Sticker Successfully Saved'], 200);
            }else
            {
                return response()->json(['error' => 'No control Sheet Provided'], 401);
            }
        }else
        {
            return response()->json(['error' => 'You are missing a sticker number'], 401);
        }
    }catch(Exception $ex){
        return response()->json(['error' => $ex->getMessage()], 401);
    }
});

Route::post('/api/v1/sticker/production/get-counter', function (Request $request){
    try
    {
        if($request->has('controlsheet_no'))
        {
            $sticker_counter = \Bt\Production\Models\Pipestickeritem::where('controlsheet_id',$request->input('controlsheet_no'))->where('production_date', '>', '2024-01-01')->count();
            return response()->json(['item_count' => $sticker_counter], 200);
        }else
        {
            return response()->json(['error' => 'No control Sheet Provided'], 401);
        }
    }catch(Exception $ex){
        return response()->json(['error' => $ex->getMessage()], 401);
    }
});

Route::post('/api/v1/sticker/controlsheet/activate', function (Request $request){
    if($request->has('controlsheet_id'))
    {
        $controlSheet = \Bt\Production\Models\ControlSheet::find($request->input('controlsheet_id'));
        $controlSheet->opendate = now();
        $controlSheet->save();
    }
});



Route::post('/api/v1/sticker/user-details', function (Request $request){
    if ($request->has('user_id')) {
       return \Backend\Models\User::where('id', $request->input('user_id'))->with(['role', 'groups'])->get();
    }
});
