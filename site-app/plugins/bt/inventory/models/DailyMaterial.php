<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;
use Exception;
use Carbon\Carbon;
use Bt\Inventory\Models\DailyMaterial as ModelMaterial;

/**
 * DailyMaterial Model
 */
class DailyMaterial extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_inventory_daily_materials';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [

        'datecaptured',
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [

        'datecaptured' => 'required|unique:bt_inventory_daily_materials,datecaptured',
//        'datecaptured' => 'unique:datecaptured',

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
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'datecaptured'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [
        'dailyincage' =>['Bt\Inventory\Models\CageMaterial','key'=>'dailmaterial_id'],
    ];
    public $belongsTo = [
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

        // Retrieve DailyMaterial based on the captured date
        $material = DailyMaterial::whereDate('datecaptured', $this->datecaptured->toDateString())->first();

        // Check if a DailyMaterial with the specified date already exists
        if (!empty($material)) {
            // Throw an exception if the date already exists
            throw new Exception("Date already exists: DailyMaterial with the specified date is already captured.");
        }
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }



}
