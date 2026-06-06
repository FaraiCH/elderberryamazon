<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\Stock as ModelStock;
use Bt\Inventory\Models\StockOut as ModelStockOut;
use Bt\Inventory\Models\CageMaterial as ModelCageMaterial;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceiving;

use Auth;
use Flash;
use Input;
Use Validator;
use Redirect;
use ValidationException;
use GuzzleHttp\Client;
use Http;
use Mail;
use Config;
use Renatio\DynamicPDF\Classes\PDF;
use DB;
use Carbon\Carbon;

class StockGraphs extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'StockGraphs Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onrun(){
        //dd($this->loadInStock());
    }

    public function defineProperties()
    {
        return [];
    }
	// public function loadInStock(){
 //        return ModelStock::select(DB::raw("count(bt_inventory_stocks.part_name_id) as y"),"bt_inventory_part_names.name")

 //        ->join('bt_inventory_part_names', 'bt_inventory_part_names.id', '=', 'bt_inventory_stocks.part_name_id')

 //        ->where('bt_inventory_stocks.instock',1)
 //        ->groupBy("bt_inventory_stocks.part_name_id")
 //        ->get()->toJson();

 //    }

     public function loadOutStock(){
        $list =  ModelStock::select(DB::raw("count(bt_inventory_stock_outs.stockout_date) as y"),DB::raw("DATE(bt_inventory_stock_outs.stockout_date) as outdate"),"bt_inventory_part_names.name")

        ->join('bt_inventory_stock_outs', 'bt_inventory_stock_outs.id', '=', 'bt_inventory_stocks.stock_out_id')
        ->join('bt_inventory_part_names', 'bt_inventory_part_names.id', '=', 'bt_inventory_stocks.part_name_id')

        ->where('bt_inventory_stocks.instock',0)
        ->groupBy("outdate","bt_inventory_stocks.part_name_id")
        ->get();

        $list2 =  ModelStock::select(DB::raw("count(bt_inventory_stock_outs.stockout_date) as y"),DB::raw("DATE(bt_inventory_stock_outs.stockout_date) as outdate"))

        ->join('bt_inventory_stock_outs', 'bt_inventory_stock_outs.id', '=', 'bt_inventory_stocks.stock_out_id')


        ->where('bt_inventory_stocks.instock',0)
        ->groupBy("outdate")
        ->get();

        $tempArray =  array();

        foreach ($list2 as $key => $value) {

        $dates = strtotime(date('Y-m-d H:00',strtotime($value->outdate)))*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
            $tempArray["TOTAL"]['data'][] = array($dates,$value->y);
            $tempArray["TOTAL"]['name'] = "TOTAL";
        }

        foreach ($list as $key => $value) {

        $dates = strtotime(date('Y-m-d H:00',strtotime($value->outdate)))*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
            $tempArray[$value->name]['data'][] = array($dates,$value->y);
            $tempArray[$value->name]['name'] = $value->name;
        }

        $monster  =  array();
        foreach ($tempArray as $key => $value) {
            $monster[] =  array('name' => $key, 'data'=> $value['data'] );
        }


        return json_encode($monster);

    }

    public function loadStockInCage(){
        $list =  ModelCageMaterial::select(DB::raw("bt_inventory_cage_materials.kg as y"),DB::raw("bt_inventory_cage_materials.datecaptured as outdate"),"bt_inventory_part_names.name")
        ->join('bt_inventory_part_names', 'bt_inventory_part_names.id', '=', 'bt_inventory_cage_materials.part_name_id')
         ->orderby("bt_inventory_cage_materials.datecaptured")
        ->get();



        $tempArray =  array();

        foreach ($list as $key => $value) {

        $dates = strtotime(date('Y-m-d H:00',strtotime($value->outdate)))*1000 + 2*3600*1000;# + 2*3600*1000; 60*60 = 3600sec = 1 hour
            $tempArray[$value->name]['data'][] = array($dates,(int)$value->y);
            $tempArray[$value->name]['name'] = $value->name;
        }

        $monster  =  array();
        foreach ($tempArray as $key => $value) {
            $monster[] =  array('name' => $key, 'data'=> $value['data'] );
        }


        return json_encode($monster);

    }

    // public function loadInStock(){
    //     $getdate =  ModelCageMaterial::orderby("datecaptured","DESC")->first();
    //     $date = new Carbon($getdate->datecaptured);
    //     return ModelCageMaterial::select(DB::raw("floor(bt_inventory_cage_materials.kg) as y"),"bt_inventory_part_names.name")
    //     ->join('bt_inventory_part_names', 'bt_inventory_part_names.id', '=', 'bt_inventory_cage_materials.part_name_id')
    //     ->where('bt_inventory_cage_materials.datecaptured','>', $date->subHours(3)->toDateTimeString())
    //     ->orderby("bt_inventory_cage_materials.datecaptured")
    //     ->get()->toJson();

    // }

    public function loadInStock(){
        return [];

        //$getdate =  ModelCageMaterial::orderby("datecaptured","DESC")->first();
        //$date = new Carbon($getdate->datecaptured);
        return RawMaterialReceiving::select(DB::raw("floor(bt_inventory_raw_material_receivings.weight - sum(bt_inventory_stock_releases.kg)) as y"),DB::raw("concat(bt_inventory_part_names.name,' - ',bt_inventory_raw_material_receivings.supplier_batch) as name "))
        ->join('bt_inventory_part_names', 'bt_inventory_part_names.id', '=', 'bt_inventory_raw_material_receivings.part_name_id')
        ->join('bt_inventory_stock_releases', 'bt_inventory_stock_releases.raw_material_receivings_id', '=', 'bt_inventory_raw_material_receivings.id')
        ->where('bt_inventory_raw_material_receivings.active',1)
        ->groupby("bt_inventory_raw_material_receivings.id")
        ->get()->toJson();

    }

    public function loadInStockraw(){
        $getdate =  ModelCageMaterial::orderby("datecaptured","DESC")->first();
        $date = new Carbon($getdate->datecaptured);
        return ModelCageMaterial::select("bt_inventory_cage_materials.datecaptured",DB::raw("floor(bt_inventory_cage_materials.kg) as y"),"bt_inventory_part_names.name")
        ->join('bt_inventory_part_names', 'bt_inventory_part_names.id', '=', 'bt_inventory_cage_materials.part_name_id')
        ->where('bt_inventory_cage_materials.datecaptured','>', $date->subHours(3)->toDateTimeString())
        ->orderby("bt_inventory_cage_materials.datecaptured")
        ->get();

    }

    public function StockReceiveSummary(){
        return RawMaterialReceiving::where('date_of_receipt','>', "2024-01-01 00:00:00")->orderBy("supplier_batch")->get();
    }


}
