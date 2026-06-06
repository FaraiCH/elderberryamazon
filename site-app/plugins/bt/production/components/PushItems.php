<?php namespace Bt\Production\Components;

use Cms\Classes\ComponentBase;
use Bt\Production\Models\Push as PushModel;
use Bt\Production\Models\Status as StatusModel;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Sales\Models\QuoteReponse as QuoteReponseModel;
use Carbon\Carbon;


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

class PushItems extends ComponentBase
{
     public $pushitem;
    public function componentDetails()
    {
        return [
            'name'        => 'PushItems Component',
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
            $this->pushitem = PushModel::find($this->property('item'));

        }
        //$this->loadAssets();
       
    }

     public function loadStatus(){
        

        return StatusModel::all();
    }

    
    public function onUpdateStatus(){
         

        $user = Auth::getUser();
            $validator = Validator::make(
                [
                    'status_id' =>  Input::get('status_id')
                ],
                [
                    'status_id' => 'required'
                ]
            );
        

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

              
       
        if($user->id > 0){
            $pushitem = PushModel::find($this->property('item'));
            if(!empty($pushitem) && Input::get('status_id')  == 2){                
                $count = 0;
                foreach ($pushitem->quote->items as $value) {
                    $check = PipeModel::find($value->id);
                    if(empty($check)){
                        $pipe = new PipeModel();
                        $pipe->quoteitem_id = $value->id;
                        $pipe->push_id = $pushitem->id;
                        $pipe->line_id = 1;              
                        $pipe->pipe_target_weight = $value->weight;
                        $pipe->production_rate =  700;
                        $pipe->target_scrap_rate = 3;
                        $pipe->target_availability = 98;
                        $pipe->changeover_days = 0;
                        $pipe->save(); 
                        if($pipe->id){
                            $count++;
                        } 
                    }
                   
                }
                
                if($count > 0){
                    $pushitem->date_of_accepted = Carbon::now();;
                    $pushitem->status_id = 2;
                    $pushitem->save();
                    $this->qresponse($pushitem->quote_id,16,'Date accepted ('.$pushitem->date_of_accepted.") with $count pipes");
                    Flash::success("Production accepted...");
                }
            }

            if(Input::get('status_id')  == 3){
                $pushitem->date_of_completed = Carbon::now();;
                $pushitem->status_id = 3;
                $pushitem->save();
                $this->qresponse($pushitem->quote_id,17,'Date completed  ('.$pushitem->date_of_completed.")");
                Flash::success("Production completed...");
            }

            if(Input::get('status_id')  == 4){
                $pushitem->status_id = 4;
                $pushitem->save();
                Flash::success("Production put on hold...");
                $this->qresponse($pushitem->quote_id,18);
            }

          return Redirect::refresh();
            
           
        }else{
              Flash::error("Use need ...");
              return; 
        }
    }

    private function qresponse($quote_id,$status,$note = null){
        $user = Auth::getUser();
        $qr = new QuoteReponseModel();
        $data['user_id'] = $user->id;
        $data['quote_id'] = $quote_id;
        $data['quote_status_id'] =  $status;
        $data['notes'] = $note;
        $q = $qr->subQuoteReponse($data);
    }
}
