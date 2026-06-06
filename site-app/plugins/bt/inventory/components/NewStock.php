<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\PartNames;
use Bt\Inventory\Models\Stock;
use Bt\Inventory\Models\EntryType;
use Bt\Inventory\Models\RecievedType;
use Bt\Inventory\Models\StockRoomBlock;

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

class NewStock extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'NewStock Component',
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

     public function loadAssets()
    {
        $this->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js', 'Bt.Sales'); 
        $this->addJs('assets/js/selectfloor.js', 'Bt.Inventory');

    }
 public function loadEntryType(){
        return EntryType::all();
    }
     public function loadPartNames(){
        return PartNames::all();
    }

     public function loadRecievedType(){
        return RecievedType::all();
    }

     public function loadStockRoomBlock(){
        return StockRoomBlock::all();
    }

    public function onSave(){
        $user = Auth::getUser();
        $validator = null;
        $validator = Validator::make(
            [
                'supplier_batch' =>  Input::get('supplier_batch'),
                'date_of_receipt' => Input::get('date_of_receipt'),
                'received_in' =>  Input::get('received_in'),
                'part_name_id' =>  Input::get('part_name_id')
            ],
            [
                'supplier_batch' => 'required',
                'date_of_receipt' => 'required',
                'received_in' => 'required',
                'part_name_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        
        $pallets = Input::get('no_pallets');
        $count = 0;
        for ($i=0; $i < $pallets; $i++) { 
            $q = new Stock;
            $q->user_id = $user->id;
           
            $q->truck_number_plate = Input::get('truck_number_plate');
            $q->container_number = Input::get('container_number');
            $q->date_of_receipt = Input::get('date_of_receipt');
            $q->part_name_id = Input::get('part_name_id');
            $q->received_in = Input::get('received_in');
            $q->supplier_batch = Input::get('supplier_batch');
            if(Input::has('bagsother') && Input::get('bagsother') > 0)
                $q->bagsother = Input::get('bagsother');

            if(Input::has('notes'))
                $q->notes = Input::get('notes');

            if(Input::has('notes'))
                $q->notes = Input::get('notes');            

            if(Input::has('weight_pallets'))
                $q->weight_pallets = Input::get('weight_pallets'); 

            $q->save();
          
            if($q->id > 0){
                $count++;
            }   
        }
        if($count > 0){
            Flash::success("$count items were created succesfully...");
            return Redirect::refresh();   
        }else{
            Flash::error("Error: Could not add stock...");
            return; 
        }
    }
       
}
