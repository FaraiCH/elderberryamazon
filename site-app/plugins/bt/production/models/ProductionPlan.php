<?php namespace Bt\Production\Models;

use Bt\Sales\Models\SrnItem;
use Model;
use BackendAuth;
/**
 * ProductionPlan Model
 */
class ProductionPlan extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_production_plans';

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
        'startdate' => 'required',
        'enddate' => 'required',
        'btline' => 'required',
        'size' => 'required',
        'changeover_hours' => 'required',
        'status' => 'required',
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
    public $hasMany = [
         'planitems' => ['Bt\Production\Models\ProductionPlanItem','key'=>'plan_id'],
         'planitemscat' => ['Bt\Production\Models\ProductionPlanItemCat','key'=>'plan_id'],

    ];
    public $belongsTo = [
        'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
        'btline' => ['Bt\Production\Models\Line','key'=>'line_id'],
        'delivered' => ['Bt\Sales\Models\SrnItem','key'=>'pipe_id'],
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
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }

    public function getQuotesAttribute()
    {
        $planItemsQuotes = $this->planitems->map(function ($item) {
            return $item->quote;
        });
        $planItemscatQuotes = $this->planitemscat->map(function ($item) {
            return $item->quote;
        });
        $allQuotes = $planItemsQuotes->merge($planItemscatQuotes)->filter()->unique('id');

        return $allQuotes;
    }
}
