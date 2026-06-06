<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;
use Bt\Production\Models\Push as PushModel;
use Bt\Production\Models\Pipe as PipeModel;

/**
 * GoodsReturn Model
 */
class GoodsReturn extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_goods_returns';

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
    protected $jsonable = ['items'];

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
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'client' => ['Bt\Sales\Models\Client','key'=>'client_id','order'=>'company_name'],
        'item' => ['Bt\Sales\Models\Quoteitems','key'=>'item_id'],
        'reasonforreturn' => ['Bt\Sales\Models\ReasonForReturn','key'=>'reasonforreturn_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
       'files' => 'System\Models\File',
    ];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->createdby = $user->id;
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updatedby = $user->id;
    }

    public function listPipeItem($fieldName, $value, $formData)
    {
        $i =  PipeModel::all();

        $arrayName = array();
        foreach ($i as $key_ => $value_) {
            if(!empty($value_->quoteitems)){
                 if($value_->quoteitems){
                     $arrayName[$value_->id] = $value_->quoteitems->description;
                 }
            }
        }

        return $arrayName;
    }
}
