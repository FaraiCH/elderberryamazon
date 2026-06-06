<?php namespace Bt\Sales\Models;

use Bt\Production\Models\Push;
use Model;
use BackendAuth;
use RainLab\User\Models\UserGroup;
use Mail;
/**
 * QuoteApproval Model
 */
class QuoteApproval extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_quote_approvals';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote', 'key' => 'quote_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;

        $oldResponse = QuoteReponse::where('quote_status_id', 14)->where('quote_id', $this->quote_id)->count();
        if($oldResponse == 0){
            if($this->status_id == 1){
                $push = new Push();
                $push->user_id = $this->quote->user_id;
                $push->quote_id = $this->quote_id;
                $push->status = 1;
                $push->save();

                $response = new QuoteReponse();

                $response->quote_id = $this->quote_id;
                $response->quote_status_id = 14;
                $response->save();

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
                        'sales_name' => $this->quote->user->name,
                        'billing_name' => $this->quote->billing_name,
                        'company_name' => $this->quote->company_name,
                        'quote_total' => $this->quote->totalincvat,
//                    'notes' =>  $q->response,
                        'response_details' =>  $link,
                        'ref' => "#BT-".$this->quote_id
                    ];
                    $this->sendmail($data);
                }
            }
        }


    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;

        $oldResponse = QuoteReponse::where('quote_status_id', 14)->where('quote_id', $this->quote_id)->count();
        if($oldResponse == 0){
            if($this->status_id == 1){
                $push = new Push();
                $push->user_id = $this->quote->user_id;
                $push->quote_id = $this->quote_id;
                $push->status = 1;
                $push->save();

                $response = new QuoteReponse();

                $response->quote_id = $this->quote_id;
                $response->quote_status_id = 14;
                $response->save();

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
                        'sales_name' => $this->quote->user->name,
                        'billing_name' => $this->quote->billing_name,
                        'company_name' => $this->quote->company_name,
                        'quote_total' => $this->quote->totalincvat,
//                    'notes' =>  $q->response,
                        'response_details' =>  $link,
                        'ref' => "#BT-".$this->quote_id
                    ];
                    $this->sendmail($data);
                }
            }
        }
    }
    public function afterSave(){
        if($this->status_id == 0){
            if(isset($this->createdby->id) || isset($this->updateby->id)){
                $url = env('APP_URL') .'/sales/newquote/update/'. $this->quote->id;
                $link = "
                * View Quote: $url";
                $data = [
                    'email' => 'BT.sales.response.rejectedapproval',
                    'to_name' => $this->quote->user->name . " " . $this->quote->user->surname,
                    'to_email' =>   $this->quote->user->email,
                    'quote_id' => $this->quote_id,
                    'comment' => $this->note,
                    'quote_total' => $this->quote->totalincvat,
                    'response_details' =>  $link,
                    'ref' => "#BT-".$this->quote_id
                ];
                $this->sendmail($data);
            }
        }
    }

    private function sendmail($data){
        Mail::queue($data['email'], $data, function($message) use ($data) {
            $message->to($data['to_email'], $data['to_name']);
        });
    }

    public function filterFields($fields, $context = null)
    {
        $fields->status_section->comment = "<p style='text-align: center'><b>NOT APPROVED</b></p>";
        if($this->status_id == 0) {
            if (isset($this->createdby->id) || isset($this->updateby->id)) {
                $fields->status_section->comment = "<p style='text-align: center; color: red'><b>REJECTED</b></p>";
            }
        }
        elseif ($this->status_id > 0)
        {
            $fields->status_section->comment = "<p style='text-align: center; color: darkgreen'><b>APPROVED</b></p>";
        }
    }
}
