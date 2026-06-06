<?php namespace Bt\JSEData\Models;

use Model;
use BackendAuth;
use Bt\JSEData\Models\Property as PropertyModel;

/**
 * DataMine Model
 */
class DataMine extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_jsedata_data_mines';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'company' => 'required',
        'property' => 'required',
        'datea' => 'required',
        'value' => 'required',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'company' =>['Bt\JSEData\Models\Company','key'=>'company_id'],
        'property' =>['Bt\JSEData\Models\Property','key'=>'property_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    public function beforeCreate()
    {  
        // $user = BackendAuth::getUser();
        if (!$user) return;
        // $this->created_by = $user->id;               
    }
    public function beforeUpdate()
    {  
        // $user = BackendAuth::getUser();
        if (!$user) return;
        // $this->updated_by = $user->id;       
    }

    public function getPropertyOptions()
    {
        $i = PropertyModel::where('parent_id','>',0)->orderby('parent_id','asc')->get();
        $arrayName = array();
        
        foreach ($i as $key_ => $value_) {
            $arrayName[$value_->id] = $value_->parent->name." > ".$value_->name;
        }
        
        return $arrayName;
    }
}
