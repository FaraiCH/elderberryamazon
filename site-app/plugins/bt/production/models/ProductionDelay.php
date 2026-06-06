<?php namespace Bt\Production\Models;

use Bt\Sales\Models\Quoteitems;
use Model;
use BackendAuth;

/**
 * ProductionDelay Model
 */
class ProductionDelay extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_production_delays';

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
    public $rules = [];

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
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'delayreason' => ['Bt\Production\Models\DelayReason','key'=>'delayreason_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    public function getPipeOptions()
    {
        $pushArry = array();
        $urlArra = explode("/", $_SERVER['REQUEST_URI']);
        $pushUrl = $urlArra[count($urlArra)-1];
        if ($pushUrl == 0) {
            if ($this->quote_id) {
                $pushUrl = $this->quote_id;
            } elseif (isset(Input::get('Push')["id"])) {
                $pushUrl = Input::get('Push')["id"];
            }
        }
        if ($pushUrl > 0) {
            $obj = Pipe::where("push_id", '=', $pushUrl)->get();
            
            foreach ($obj as $value) {
                $pushArry[$value->id] = $value->quoteitems->description;
            }
        }
         return $pushArry;
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
}
