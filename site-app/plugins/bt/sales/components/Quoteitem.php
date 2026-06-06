<?php namespace Bt\Sales\Components;

use Cms\Classes\ComponentBase;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\QuoteItemCatalogue;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\QuoteEmail as ModelQuoteEmail;
use Bt\Sales\Models\QuoteStatus;
use Bt\Sales\Models\QuoteReponse as QuoteReponseModel;
use RainLab\User\Models\User;

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
use Bt\Sales\Models\ActionToGroup;


class Quoteitem extends ComponentBase
{
    public $quote;
    public $emails;
    public function componentDetails()
    {
        return [
            'name'        => 'quoteitem Component',
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
            $this->quote = ModelNewquote::find($this->property('item'));

        }
         $this->loadAssets();
       
    }

    public function loadStatus(){
         $user = Auth::getUser();
        $group_ids = $user->groups->pluck('id')->toArray();
        
        $ids = ActionToGroup::select("quote_statuses_id")->whereIn('user_groups_id', $group_ids)->groupBy("quote_statuses_id")->get()->toarray();

        return QuoteStatus::whereIn('id', $ids)->get();
    }

    public function onSendEmail(){
        $user = Auth::getUser();
        $validator = null;
        
            $validator = Validator::make(
                [
                    'email_to' =>  Input::get('email_to')
                 //   'email_cc' =>  Input::get('email_cc')
                ],
                [
                    'email_to' => 'required|email',
                //    'email_cc' => 'email'
                ]
            );
        

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }


       
        if($user->id > 0){
            $quote = ModelNewquote::find($this->property('item'));
            $q = new ModelQuoteEmail;
            $q->user_id = $user->id;
            $q->quote_id = $quote->id; 
           // $q->email_cc = Input::get('email_cc');
            $q->email_to = Input::get('email_to');
            $q->body = Input::get('notes');

            $q->save();
            if($q->id > 0){
                
                $i =  ModelNewquote::find($this->property('item'));
                 $this->page['emails'] = $i->emails;
                
                $data = [
                    'name' => $quote->billing_name,
                    'company_name' => $quote->company_name,
                    'response_quote' => $quote->user->email,
                    'email_to' => Input::get('email_to'),
                    'notes' =>  $q->body,
                    'ref' => "#BT-".$quote->id
                ];

                
                

                Mail::send('BT.sales.newquote', $data, function($message) use ($data,$quote) {
                    $message->to($data['email_to'], $data['response_quote']);
                    $message->subject("BT Industrial Quote: ".$data['ref']);
                    #$pdf = PDF::loadView('bt.sales::pdfitem',array('quote'=>$quote))->stream();
                    #$message->attach( $pdf->download($quote->id.'.pdf'), ['as' => 'newquote.jpg']);
                    $message->attach( Config::get('app.url')."/quote/item/download/".$quote->id.".pdf", ['as' => 'newquote.pdf']);

                });


                Flash::success("Updated successfully...");
                return;


            }else{
              Flash::error("Error: Could not save email...");
              return;   
            }

        }else{
              Flash::error("Use need ...");
              return; 
        }
    }

    
    public function onSaveResponse(){
         

        $user = Auth::getUser();
            $validator = Validator::make(
                [
                    'quote_status_id' =>  Input::get('quote_status_id')
                ],
                [
                    'quote_status_id' => 'required'
                ]
            );
        

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

              
       
        if($user->id > 0){
            $quote = ModelNewquote::find($this->property('item'));
         
            $qr = new QuoteReponseModel();
            $data['user_id'] = $user->id;
            $data['quote_id'] = $quote->id;
            $data['quote_status_id'] =  Input::get('quote_status_id');
            $data['notes'] = Input::get('notes');
            
            if(Input::has('amountdiscount_perc') && Input::get('amountdiscount_perc') > 0){
                $data['amountdiscount_perc'] = Input::get('amountdiscount_perc');
            }
           
            if(Input::has('amountpaid') && Input::get('amountpaid') > 0)
                $data['amountpaid'] = Input::get('amountpaid');

            if(Input::has('deliveryamount') && Input::get('deliveryamount') > 0)
                $data['deliveryamount'] = Input::get('deliveryamount');
           
            $data['file']  = Input::file('file_input');

            $q = $qr->subQuoteReponse($data);
            
            if(!empty($q) && $q->id > 0){
                $i =  ModelNewquote::find($this->property('item'));
                $this->page['response'] = $i->responses;
                Flash::success("Updated successfully...");
                return Redirect::refresh();
                //return;
            }else{
              Flash::error("Error: Could not save email...");
              return Redirect::refresh();
              //return;   
            }

        }else{
              Flash::error("Use need ...");
              return Redirect::refresh();
              //return; 
        }
    }

    public function loadAssets()
    {
        $this->addJs('assets/js/qouteitemform.js', 'Bt.Sales',"v1");

    }

    private function sendmail($data){
        Mail::send($data['email'], $data, function($message) use ($data) {
            $message->to($data['to_email'], $data['to_name']);
        });
    }

}
