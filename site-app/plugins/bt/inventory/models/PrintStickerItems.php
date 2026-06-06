<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceivingModel; 
/**
 * PrintStickerItems Model
 */
class PrintStickerItems extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_print_sticker_items';
     use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
       // 'schedule_date' => 'required',
        'material' => 'required',
        
        'units' => 'required',
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
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
    'material' => ['Bt\Inventory\Models\RawMaterialReceiving','key'=>'material_id'],
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

    public function listPipesitems($fieldName, $value, $formData)
    {
        
        $i =  RawMaterialReceivingModel::active()->get();
        $arrayName = array();

        foreach ($i as $key_ => $value_) {
           
            $arrayName[$value_->id] = $value_->productname->name.". Batch: ".$value_->supplier_batch.". Date received: ".$value_->date_of_receipt;
        }
        
        return $arrayName;
    }
    
}
