<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;

/**
 * Purchase Model
 */
class Purchase extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_purchases';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'supplier' => 'required',
        'date_of_puchase' => 'required',
        'expected_date_of_receipt' => 'required',
        'weight' => 'required',
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [
    'approved' => ['Bt\Inventory\Models\Purchaseapprove','key'=>'purchase_id'],
    
    ];
    public $hasMany = [
        'receiving' =>['Bt\Inventory\Models\RawMaterialReceiving','key'=>'purchase_id'],
        'poitems' =>['Bt\Inventory\Models\Purchaseitems','key'=>'purchase_id'],
        'batchPrefixes' => ['Bt\Inventory\Models\BatchPrefix','key'=>'purchase_id'],
    ];
     public $belongsTo = [
        'supplier' =>['Bt\Inventory\Models\Supplier','key'=>'supplier_id'],
        'productname' =>['Bt\Inventory\Models\PartNames','key'=>'part_name_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'mfifiles' => 'System\Models\File',
        'pricefiles' => 'System\Models\File'
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
        
        $price_vat = 0;
        $this->price_excl =  $this->weight * $this->pricekg; 
        $price_vat = $this->price_excl * 0.15;
        $this->price =   $this->price_excl + $price_vat;
        $this->vat = $this->price - $this->price_excl;          
    }
    public function getPriceAttribute()
    {
        $price_vat = $this->price_excl * 0.15;
        return round( $this->price_excl + $price_vat, 2);
    }

    public function getPriceExclAttribute()
    {
        return round($this->weight * $this->pricekg, 2);
    }

    public function getVatAttribute()
    {
        return round($this->price - $this->price_excl, 2);
    }

}
