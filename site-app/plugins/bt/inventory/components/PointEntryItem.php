<?php namespace Bt\Inventory\Components;

use Cms\Classes\ComponentBase;
use Bt\Inventory\Models\PointEntry as ModelPointEntry;
use Bt\Inventory\Models\PointEntryItem as ModelPointEntryItem;
use Bt\Inventory\Models\RecievedType;
use Bt\Inventory\Models\PartNames;
use Bt\Inventory\Models\Stock as ModelStock;
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

class PointEntryItem extends ComponentBase
{
     public $mpe;
    public function componentDetails()
    {
        return [
            'name'        => 'PointEntryItem Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'item' => [
                'title'       => 'Business Item',
                'description' => 'Slug for business item',
                'default'     => '{{ :item }}',
                'type'        => 'string'
            ]

        ];
    }

    public function onRun(){
        if($this->property('item') > 0 ){
            $this->mpe = ModelPointEntry::find($this->property('item'));
        }
         $this->loadAssets();
    }

     public function loadAssets()
    {
        $this->addJs('assets/js/selectfloor.js', 'Bt.Inventory');

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

        if(!Input::get('floorblock')){
            Flash::error("Error: Please select floor...");
            return; 
        }

        $validator = null;
        
        $validator = Validator::make(
            [
                'received_in' =>  Input::get('received_in'),
                'floorblock' =>  Input::get('floorblock'),
                
                'part_name_id' =>  Input::get('part_name_id')
            ],
            [
                'floorblock' => 'required',
                'received_in' => 'required',
                'part_name_id' => 'required'
            ]
        );
        

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $this->mpe = ModelPointEntry::find($this->property('item'));
        $floorblock = StockRoomBlock::find(Input::get('floorblock'));
        
        if(empty($floorblock)){
            Flash::error("Error: Could not find floor item...");
            return; 
        }

        if($floorblock->used == 3 ){
            Flash::error("Error: Floor is not empty...");
            return; 
        }

        if(!empty($this->mpe)){
            $q = new ModelPointEntryItem;
            $q->user_id = $user->id; 
            $q->point_entry_id =$this->mpe->id;
            $q->received_in = Input::get('received_in');
            $rec = RecievedType::find(Input::get('received_in'));
            if($rec->bags == 0){
                if(Input::has('bagsother') && Input::get('bagsother') > 0){
                     $q->bagsother = Input::get('bagsother');
                }else{
                  Flash::error("Error: Please supply number of bags...");
                  return;   
                }
            }
            
            $q->part_name_id = Input::get('part_name_id');
            $q->supplier_batch = Input::get('supplier_batch');
            $q->stock_room_blocks_id =  Input::get('floorblock');
            $q->flooruse = 1 + $floorblock->used;

            
            $q->save();

            $floorblock->used = 1 + $floorblock->used;
            $floorblock->save();
          
            if($q->id > 0){
             
                Flash::success("New item created succesfully...");
               $url = $this->controller->pageUrl('inventory/entryitem',[':item'=>$this->mpe->id]);
            return Redirect::to($url);


            }else{
              Flash::error("Error: Could not save qoute...");
              return;   
            }   
        }else{
            Flash::error("Error: Could not find entry...");
            return; 
        }

       }

    public function onProcess(){
        $user = Auth::getUser();
        $this->mpe = ModelPointEntry::find($this->property('item'));
        if(!empty($this->mpe)){
            if($this->mpe->processed == 0){
                $this->mpe->processed = 1;
                $this->mpe->save();

                $count = 0;
                $list = ModelPointEntryItem::where("point_entry_id",$this->mpe->id)->get();
                ##LOOP THROUGH THE ITEMS AND GET NUMBER OF BAGS
                foreach ($list  as $key => $value) {
                    
                    $bags = 0;
                    $rec = RecievedType::find($value->received_in);
                    if($rec->bags == 0){
                         $bags = $value->bagsother;
                    }else{
                        $bags = $rec->bags;
                    }

                    for ($i=0; $i < $bags; $i++) { 
                        $q = new ModelStock;
                        $q->user_id = $user->id;
                        $q->point_entry_item_id = $value->id;
                        $q->part_name_id =  $value->part_name_id;
                        $q->supplier_batch =  $value->supplier_batch;
                    
                        $q->stock_room_blocks_id = $value->stock_room_blocks_id;
                        $q->flooruse = $value->flooruse;
                        $q->save();
                      
                        if($q->id > 0){
                            $count++;
                        }   
                    }
                }
               
                if($count > 0){                 
                    Flash::success("$count products created succesfully...");
                    $url = $this->controller->pageUrl('inventory/entryitem',[':item'=>$this->mpe->id]);
                    return Redirect::to($url);
                }else{
                  Flash::error("Error: Could not create products...");
                  return;   
                }  
            }else{
              Flash::error("Error: Inventory already processed...");
              return;   
            } 
        }else{
            Flash::error("Error: Could not find entry...");
            return; 
        }

        
    } 
    


}
