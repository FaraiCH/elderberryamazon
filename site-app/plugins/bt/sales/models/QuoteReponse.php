<?php namespace Bt\Sales\Models;

use Model;
use Bt\Sales\Models\Newquote as ModelNewquote;
use Bt\Sales\Models\QuoteEmail as ModelQuoteEmail;
use Bt\Sales\Models\ActionToGroup;
use Bt\Sales\Models\QuoteStatus;
use RainLab\User\Models\UserGroup;
use RainLab\User\Models\User;
use Bt\Production\Models\Push;
use Bt\Sales\Models\Invoice;
use Mail;

/**
 * QuoteReponse Model
 */
class QuoteReponse extends Model
{
    use \October\Rain\Database\Traits\Nullable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_quote_reponses';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Nullable attributes
     */
    public $nullable = ['amountpaid', 'amountdiscount', 'additionalamount', 'poamount'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
     public $belongsTo = [
         'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'status' => ['Bt\Sales\Models\QuoteStatus','key'=>'quote_status_id'],
         'user' => 'RainLab\User\Models\User'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = ['file' => 'System\Models\File'];
    public $attachMany = [];

     public function beforeDelete()
    {

        if(!$this->status->candelete)
        throw new \Exception("You cannot delete me!");

    }



    public function subQuoteReponse($data){

        $quote = ModelNewquote::find($data['quote_id']);

        if(empty($quote)){
            return null;
        }else{
            $q = new QuoteReponse();
            $q->user_id = $data['user_id'];
            $q->quote_id = $data['quote_id'];
            $q->quote_status_id = $data['quote_status_id'];

            if(isset($data['notes']))
                $q->response = $data['notes'];

            if($q->quote_status_id == 4 && isset($data['deliveryamount']) && $data['deliveryamount'] > 0){
                 $q->additionalamount = $data['deliveryamount'];
            }

             if($q->quote_status_id == 6 && isset($data['amountdiscount_perc']) && $data['amountdiscount_perc'] > 0){
                 $q->amountdiscount = $quote->totalincvat * ($data['amountdiscount_perc']/100);
            }

            if(isset($data['amountpaid']) && $data['amountpaid'] > 0)
                $q->amountpaid = $data['amountpaid'];


            if(isset($data['file']))
                $q->file = $data['file'];

            $q->save();

            if($q->id > 0){
                $quote->quote_status_id = $q->quote_status_id;
                $quote->save();

                ##SEND EMAIL
                $url = env('APP_URL') .'/quote/item/'.$quote->id;

                $link = "
                * View Quote: $url";


                if($q->quote_status_id == 3){

                    $objgroup = QuoteStatus::where("id",3)->first();
                    $groupid = $objgroup->email_groups_id;

                     $groupusers = UserGroup::where('id', $groupid)->first();

                    foreach ($groupusers->users as $key => $value) {
                        #REQUEST DISCOUNT
                         $data = [
                            'email' => 'BT.sales.response.requestdelivery',
                            'to_name' => $value->name,
                            'to_email' =>  $value->email,
                            'sales_name' => $q->user->name,
                            'billing_name' => $quote->billing_name,
                            'company_name' => $quote->company_name,
                            'quote_total' => $quote->totalincvat,
                            'notes' =>  $q->response,
                            'response_details' =>  $link,
                            'ref' => "#BT-".$quote->id
                        ];
                        $this->sendmail($data);
                    }

                }

                if($q->quote_status_id == 5){

                     $objgroup = QuoteStatus::where("id",5)->first();
                    $groupid = $objgroup->email_groups_id;

                    $groupusers = UserGroup::where('id', $groupid)->first();

                    foreach ($groupusers->users as $key => $value) {

                        #REQUEST DISCOUNT
                         $data = [
                            'email' => 'BT.sales.response.discount',
                            'to_name' => $value->name,
                            'to_email' =>  $value->email,
                            'sales_name' => $q->user->name,
                            'billing_name' => $quote->billing_name,
                            'company_name' => $quote->company_name,
                            'quote_total' => $quote->totalincvat,
                            'notes' =>  $q->response,
                            'response_details' =>  $link,
                            'ref' => "#BT-".$quote->id
                        ];
                        $this->sendmail($data);
                    }
                }

                if($q->quote_status_id == 6){
                    #send email

                     $data = [
                        'email' => 'BT.sales.response.discountresponse',
                        'to_name' => $quote->user->name,
                        'to_email' =>  $quote->user->email,
                        'disc_perc' => $data['amountdiscount_perc']."%",
                        'company_name' => $quote->company_name,
                        'notes' =>  $q->response,
                        'response_details' =>  $link,
                        'ref' => "#BT-".$quote->id
                    ];
                    $this->sendmail($data);

                }

                if($q->quote_status_id == 11){
                    $push = new Invoice();
                    $push->user_id = $data['user_id'];
                    $push->quote_id = $data['quote_id'];

                    $push->save();
                    $push->name = "BT-INV-".$push->id;
                    $push->save();
                    $q->response = "BT-INV-".$push->id;
                    $q->save();
                }


                if($q->quote_status_id == 14){
                    $push = new Push();
                    $push->user_id = $data['user_id'];
                    $push->quote_id = $data['quote_id'];
                    $push->status = 1;
                    $push->save();

                     $objgroup = QuoteStatus::where("id",14)->first();
                    $groupid = $objgroup->email_groups_id;

                     $url = env('APP_URL') .'/production/'.$push->id;

                $link = "
                * View Quote: $url";

                    $groupusers = UserGroup::where('id', $groupid)->first();

                    foreach ($groupusers->users as $key => $value) {

                        #REQUEST DISCOUNT
                         $data = [
                            'email' => 'BT.sales.response.productionnotify',
                            'to_name' => $value->name,
                            'to_email' =>  $value->email,
                            'sales_name' => $q->user->name,
                            'billing_name' => $quote->billing_name,
                            'company_name' => $quote->company_name,
                            'quote_total' => $quote->totalincvat,
                            'notes' =>  $q->response,
                            'response_details' =>  $link,
                            'ref' => "#BT-".$quote->id
                        ];
                        $this->sendmail($data);
                    }



                }

                if($q->quote_status_id == 19){
                    #send email
                    $url = env('APP_URL') .'/admin/bt/sales/newquote/update/'.$quote->id;
                    $link = "
                    * View Quote: $url";

                    $objgroup = QuoteStatus::where("id",19)->first();
                    $groupid = $objgroup->email_groups_id;

                    $groupusers = UserGroup::where('id', $groupid)->first();

                    foreach ($groupusers->users as $key => $value) {

                        #REQUEST DISCOUNT
                         $data = [
                            'email' => 'BT.sales.response.notifyinvoice',
                            'to_name' => $value->name,
                            'to_email' =>  $value->email,
                            'sales_name' => $q->user->name,
                            'billing_name' => $quote->billing_name,
                            'company_name' => $quote->company_name,
                            'quote_total' => $quote->totalincvat,
                            'notes' =>  $q->response,
                            'response_details' =>  $link,
                            'ref' => "#BT-".$quote->id,

                        ];
                        $this->sendmail($data);
                    }

                }

                if($q->quote_status_id == 20){

                    $push = Push::where('quote_id',$data['quote_id'])->first();

                    #send email
                    $url = env('APP_URL') .'/admin/bt/sales/newquote/update/'.$quote->id;
                    $link = "
                    * View Quote: $url";

                    $objgroup = QuoteStatus::where("id",20)->first();
                    $groupid = $objgroup->email_groups_id;

                    $groupusers = UserGroup::where('id', $groupid)->first();

                    foreach ($groupusers->users as $key => $value) {

                        #REQUEST DISCOUNT
                         $data = [
                            'push' => $push,
                            'email' => 'bt.notify.production.productioncanceled',
                            'to_name' => $value->name,
                            'to_email' =>  $value->email,
                            'sales_name' => $q->user->name,
                            'billing_name' => $quote->billing_name,
                            'company_name' => $quote->company_name,
                            'quote_total' => $quote->totalincvat,
                            'notes' =>  $q->response,
                            'response_details' =>  $link,
                            'ref' => "#BT-".$quote->id,

                        ];
                        $this->sendmail($data);
                    }

                }

                return $q;
            }else{
                return null;
            }
        }
    }

     private function sendmail($data){
        // Mail::send($data['email'], $data, function($message) use ($data) {
        //     $message->to($data['to_email'], $data['to_name']);
        // });
    }
}
