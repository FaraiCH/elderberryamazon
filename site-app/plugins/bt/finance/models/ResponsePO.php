<?php namespace Bt\Finance\Models;

use Model;
use Carbon\Carbon;
use BackendAuth;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;
use Bt\Finance\Models\RequestPO as ModelRequest;
use RainLab\User\Models\UserGroup;
use Backend\Models\User as UserModel;

/**
 * ResponsePO Model
 */
class ResponsePO extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_finance_response_p_os';

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
      "po_number" => "required",
       "po_file" => "required",
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
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
     'requestpo' => 'Bt\Finance\Models\RequestPO',
     'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
     'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public $belongsToMany = [

    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
       'po_file' => 'System\Models\File',
    ];
    public $attachMany = [];

    public function afterCreate()
    {

        $username = BackendAuth::getUser();
        $name = $username->first_name . ' ' . $username->last_name;

        ##SEND EMAIL
        // $this->ModelRequest->load('requestpo');
        $Id = $this->requestpo->id;
        $url = Config::get('app.url') . '/backend/bt/finance/requestpo/update/' . $Id;
        $link = "* View Request PO: $url";


        $x = 0;

        $user = UserModel::find($this->requestpo->createdby->id);



        $x++;
        $data = [];
        $data['name'] = $user->last_name;
        $data['to_email'] = $user->email;
        $data['username'] = $name;
        $data['ponumber'] = $this->po_number;
        $data['date'] = $this->date_created;
        $data['response_details'] =  $link;

            Mail::send('BT.finance.requisition.po.response', $data, function($message) use ($data) {

                $message->to($data['to_email'], $data['name']);

            });
        \Flash::success( "Thank you, you request have been sent to $x users");
    }
}
