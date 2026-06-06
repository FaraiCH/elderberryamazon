<?php namespace Bt\Sales\Models;

use Bt\Sales\Controllers\Srn as SrnController;
use Model;
use BackendAuth;
use Carbon\Carbon;
/**
 * Fabrication Model
 */
class Fabrication extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_fabrications';

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
        'quote' => 'required',
        'schedule_date' => 'required',
        'pickslip' => 'required'
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
        'fabapprove' => ['Bt\Sales\Models\Fabapprove']
    ];
    public $hasMany = [
        'items' => ['Bt\Sales\Models\FabricationItem','key'=>'fabrication_id'],
    ];
    public $belongsTo = [
        'srn' => ['Bt\Sales\Models\Srn','key'=>'srn_id'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'type' => ['Bt\Sales\Models\DeliveryType','key'=>'type_id'],
        'schedule' => ['Bt\Sales\Models\DeliveryPlan','key'=>'linkschedule_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'client' => ['Bt\Sales\Models\Client','key'=>'client_id'],
        'pickslip' => ['Bt\Sales\Models\Pickslip','key' => 'pickslip_id'],
        'vehicle' =>   ['Bt\Maintenance\Models\Vehicle']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'files_delivery' => 'System\Models\File',
        'files_coming' => 'System\Models\File',
        'images_delivery' => 'System\Models\File',
        'images_coming' => 'System\Models\File',
    ];

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

    public function getQuoteOptions(){

        $arrayName = Newquote::where('created_at','>=','2023-01-01')
            ->wherehas('itemscat')
            ->wherenotnull('ponumber')
            ->orderByDesc('id')
            ->pluck('company_name', 'id')
            ->map(function ($name, $id) {
                return "$id: $name";
            })
            ->all();
        return $arrayName;
    }

    public function getPickslipOptions()
    {
        $allpick = [];
        if (!empty($this->quote->pickslip)) {
            $pickslips = $this->quote->pickslip->pluck('id', 'quote_id');
            $quotes = $this->quote->pluck('company_name', 'id');
            foreach ($pickslips as $id => $quote_id) {
                if (isset($quotes[$quote_id])) {
                    $allpick[$quote_id] = $id . " > " . $quote_id . " " . $quotes[$id];
                }
            }
        }
        return $allpick;
    }
    public function getSrnOptions(){
        $srnObj = array();
        if(!empty($this->quote->srn)){
            $srnObj = $this->quote->srn->pluck('id')->toArray();
        }
        return $srnObj;
    }
}
