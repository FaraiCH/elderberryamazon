<?php namespace Bt\Finance\Models;

use Model;
use BackendAuth;
use RainLab\User\Models\UserGroup;
/**
 * PettyCash Model
 */
class PettyCash extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_finance_petty_cashes';

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
    public $rules = [
         'subject'    => 'required',
         'date'    => 'required',
         'amount'    => 'required',
         'paymenttype'    => 'required',
         'message'    => 'required',
    ];

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

    public $hasOne = [
      'pettycashapprove' => ['Bt\Finance\Models\PettyCashApprove','key'=>'pettycash_id'],
        'lineapprove' => ['Bt\Finance\Models\PettyLineApprove', 'key', 'pettycash_id']
    ];
    public $hasMany = [
      'cardrecords'=>['Bt\Finance\Models\CardRecords','key'=>'pettycash_id'],
    ];
    public $belongsTo = [
       'requestby' =>['Backend\Models\User','key'=>'requestedby_id','other'=>'id'],
       'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
       'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
       'approvedby' => ['RainLab\User\Models\User','key'=>'approvedby_id','other'=>'id'],
       'linemanager' => ['RainLab\User\Models\User','key'=>'linemanager_id','other'=>'id'],
       'requestedtomanager' => ['RainLab\User\Models\User','key'=>'requested_to','other'=>'id'],
       'paymenttype' =>['Bt\Finance\Models\PaymentType','key'=>'paymenttype_id'],
       'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
       'isactive' => ['Bt\Maintenance\Models\YesNo','key'=>'active'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
      'slips' => 'System\Models\File',
    ];
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }

    public function PickMe()
    {
        //Farai Chakarisa
        //Fix noneobject error
        $users = array();
        //Take the user group (Rainlab)
          $groupusers = UserGroup::where('id', 27)->first();

        //Make sure that the user group exists
        if (isset($groupusers)) {
            //Loop through all the users in the group
            foreach ($groupusers->users as $key => $value) {
                $users[$value->id] = $value->name. ' '. $value->surname;
            }
        }

        return $users;
    }

    public function filterFields($fields, $context = null)
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        if ($this->pettycashapprove && $this->pettycashapprove->status_id == 1) {
               $fields->subject->disabled = true;
               $fields->date->disabled = true;
               $fields->amount->disabled = true;
               $fields->paymenttype->disabled = true;
               $fields->requested_to->disabled = true;
               $fields->message->disabled = true;
               $fields->isactive->disabled = true;
        }

        if(isset($this->createdby->id)){
            if($user->id != $this->createdby->id){
                $fields->cancel->disabled = true;
            }else{
                $fields->cancel->disabled = false;
            }
        }
    }
}
