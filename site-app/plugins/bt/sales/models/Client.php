<?php namespace Bt\Sales\Models;

use Model;
use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;

/**
 * Client Model
 */
class Client extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_clients';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [

        'company_name'                  => 'required',
        'contact_name'                  => 'required',
        'contact_email'                  => 'required',
    ];
    protected $jsonable = ['additional_contacts'];
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ["is_cod","is_blocked","company_name","coreg","vatno","label","vendorno","buyer_code","limit","date_granted","terms_of_payment","contact_name","contact_email","contact_number","physical_address","postal_address","utilization"];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
     'accounts' => ['Bt\Sales\Models\ClientAccount','key'=>'client_id'],
     'quotes' => ['Bt\Sales\Models\Newquote','key'=>'client_id'],
    'client_finance' => ['Bt\Sales\Models\ClientFinance','key'=>'client_id'],
    ];
    public $belongsTo = [
        'client_category' => 'Bt\Sales\Models\ClientCategory',

    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'proof_address' => 'System\Models\File',
        'identification' => 'System\Models\File',
        'certification' => 'System\Models\File',
        'businessfiles' => 'System\Models\File',
        'other' => 'System\Models\File',
        'contract' => 'System\Models\File',
    ];

    public function getUserIdOptions()
    {
        $groupusers = UserGroup::where('id', 3)->first();
        $userarray = array();

        if ($groupusers && $groupusers->users) {
            foreach ($groupusers->users as $key => $value) {
                $userarray[$value->id] = $value->name. ' '. $value->surname;
            }
        }

        return $userarray;
    }

    public function getUserIdAttribute()
    {
        $value = array_get($this->attributes, 'user_id');
        if(isset($value))
        {
            return array_get($this->getUserIdOptions(), $value);
        }
        else
        {
            return null;
        }

    }
}
