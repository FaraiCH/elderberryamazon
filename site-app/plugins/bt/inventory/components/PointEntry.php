<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\PointEntry as ModelPointEntry;
use Bt\Inventory\Models\InventoryType;
use Bt\Inventory\Models\EntryType;
use Bt\Inventory\Models\RecievedType;
use Bt\Inventory\Models\PartNames;

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

class PointEntry extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'PointEntry Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function loadPartNames(){
        return PartNames::all();
    }

    public function loadInventoryType(){
        return InventoryType::all();
    }
    
    public function loadEntryType(){
        return EntryType::all();
    }
    
    public function loadRecievedType(){
        return RecievedType::all();
    }

    public function onSave(){
        $user = Auth::getUser();
        $validator = null;
        
        $validator = Validator::make(
            [
                'inventory_type' =>  Input::get('inventory_type'),
                'point_of_entry' =>  Input::get('point_of_entry'),
                'date_of_receipt' => Input::get('date_of_receipt')
            ],
            [
                'inventory_type' => 'required',
                'point_of_entry' => 'required',
                'date_of_receipt' => 'required'
            ]
        );
        

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }


        $q = new ModelPointEntry;
        $q->user_id = $user->id; 
        $q->inventory_type = Input::get('inventory_type');
        $q->point_of_entry = Input::get('point_of_entry');
        $q->truck_number_plate = Input::get('truck_number_plate');
        $q->container_number = Input::get('container_number');
        $q->date_of_receipt = Input::get('date_of_receipt');
       // $q->received_in = Input::get('received_in');
        $q->notes = Input::get('notes');
        $q->save();
      
        if($q->id > 0){
         
            Flash::success("New quote created succesfully...");
            $url = $this->controller->pageUrl('inventory/entryitem',[':item'=>$q->id]);
            return Redirect::to($url);


        }else{
          Flash::error("Error: Could not save qoute...");
          return;   
        }
    }


}
