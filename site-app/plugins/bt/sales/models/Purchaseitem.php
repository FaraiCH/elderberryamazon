<?php namespace Bt\Sales\Models;

use Bt\Sales\Models\Catalogue;
use Bt\Sales\Models\Newquote;
use Illuminate\Support\Facades\Request;
use Model;

/**
 * Purchaseitem Model
 */
class Purchaseitem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_production_purchaseitems';

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
        'purchase' => 'Bt\Sales\Models\Purchase',

    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        $meh = $this->purchase->quote->itemscat;
        foreach($meh as $item)
        {
            if($this->item_id == $item->id)
            {
                return [
                    $this->description = $item->description,
                    $this->sell_price = $item->unitprice,
                    $this->buy_price = $item->unitprice,
                ];
            }

        }
    }
    public function beforeUpdate()
    {
        $meh = $this->purchase->quote->itemscat;
        foreach($meh as $item)
        {
            if($this->item_id == $item->id)
            {
                return [
                    $this->description = $item->description,
                ];
            }

        }
    }

    public function getItemIdOptions()
    {
        $purchase = Purchase::find(Request::segment(6));
        $purchaseItem = array();
        if(isset($purchase))
        {
            foreach ($purchase->quote->itemscat as $item)
            {
                $purchaseItem[$item->id] = $item->description . ' X '. $item->units . ' Units';
            }
            return $purchaseItem;
        }
        else
        {
            return null;
        }

    }


}
