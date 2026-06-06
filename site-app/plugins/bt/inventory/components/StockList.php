<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\Stock as ModelStock;
use Bt\Inventory\Models\StockOut as ModelStockOut;

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

class StockList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'StockList Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->loadAssets();
    }

    public function loadStockList(){
        return ModelStock::where("instock",1)->get();
    }

     public function loadAssets()
    {
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales'); 
        $this->addJs('assets/js/stockout.js', 'Bt.Inventory');

    }
    public function onStockOut(){
        $user = Auth::getUser();
        
        $q = new ModelStockOut;
        $q->user_id = $user->id; 
        $q->ids = Input::get('updatehole');
        $q->notes = Input::get('notes');
        $q->stockout_date = Input::get('stockout_date');
        
         $q->file  = Input::file('file_input');

        $q->save();
      
        if($q->id > 0){

              $pieces = explode(",",Input::get('updatehole'));
                
                foreach ($pieces as $key => $value) {
                    if($value>0){
                        $c = ModelStock::find($value);
                        if($c && $c->id > 0){
                            $c->instock = 0;
                            $c->stock_out_id = $q->id;
                            $c->save();
                        }    
                    }
                }
         
            Flash::success("Stock taken out succesfully ...");
            //$url = $this->controller->pageUrl('inventory/entryitem',[':item'=>$q->id]);
            return Redirect::refresh();


        }else{
          Flash::error("Error: Could not save qoute...");
          return;   
        }
    }

    
}
