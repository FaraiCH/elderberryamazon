<?php namespace Bt\Sales\Models;

use Bt\Sales\Models\QuoteItemCatalogue as QuoteItemCatalogue;
use Model;
use Input;
use BackendAuth;
/**
 * PickslipCatalogue Model
 */
class PickslipCatalogue extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_pickslip_catalogues';

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
        'pickslip' => ['Bt\Sales\Models\Pickslip'],
        'qoutecat' => ['Bt\Sales\Models\QuoteItemCatalogue','key'=>'quotecat_id'],

        // 'product' => ['Bt\Sales\Models\Product','key'=>'product_id'],
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


    public function listCatalogueitems($fieldName, $value, $formData)
    {
        $arrayName = array();
        $catalogue = \Request::segment(6);
        if($catalogue > 0){
            $srn = Pickslip::find($catalogue);
            $quote_id = $srn->quote_id;
            $inv =  Newquote::find($quote_id);
            if(!empty($inv->itemscat)){
                foreach ($inv->itemscat as $key => $itemscat) {
                    $qc = $itemscat->units;
                    $dlv = $itemscat->getTotalDelivered();
                    $good = $qc - $dlv;

                    if($good > 0){
                        $arrayName[$itemscat->id] = "#QUOTE ".$quote_id." #ITEM ".$itemscat->id." : DESC #".$itemscat->catalogue->name." : ORDERS UNITS #".$qc." : DELIVERED #".$dlv." : TO DELIVER#".$good;
                    }else{

                    }
                }
            }else{
            }

        }


        return $arrayName;
    }

    public function getUnitsOptions()
    {
        $arrayName = array();
        if($this->quotecat_id){
            $pipe = QuoteItemCatalogue::find($this->quotecat_id);
            if(!empty($pipe)){
                $qc = $pipe->units;
                $dlv = $pipe->getTotalDelivered();

                $good = $qc - $dlv;

                if($good > 0){
                    for ($i=1; $i <= $good; $i++) {
                        $arrayName[$i] = $i." Item" ;
                    }
                }
            }
        }
        return $arrayName;
    }
}
