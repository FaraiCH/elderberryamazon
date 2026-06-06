<?php namespace Bt\Sales\Models;

use Model;
use Bt\Sales\Models\Srn;

/**
 * SrnPayment Model
 */
class SrnPayment extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_srn_payments';

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
       'srn' => ['Bt\Sales\Models\Srn','key'=>'srn_id','order'=>'id desc'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function filterFields($fields, $context = null)
    {
        if (isset($fields->srn->value)) {
            $srnPayment = Srn::find($fields->srn->value);
            if (isset($srnPayment)) {
                $clientName = $srnPayment->client->company_name;
                $clientAddress = $srnPayment->delivery_address;
                $deliveryPrice = $srnPayment->deliveryprice;
                $logisticsCompany = $srnPayment->logistics_company;

                    $fields->bt_customer_name->value = $clientName;
                    $fields->area->value = $clientAddress;
                    $fields->bt_delivery_charged->value = $deliveryPrice;
                    $fields->logistic_company_name->value = $logisticsCompany;

            }
        }
    }
}
