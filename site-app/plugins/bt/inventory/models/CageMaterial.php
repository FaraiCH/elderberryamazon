<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;
use Bt\Inventory\Models\RawMaterialReceiving as ModelReceiving;

/**
 * CageMaterial Model
 */
class CageMaterial extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_cage_materials';

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
        'materialreceiving' =>['Bt\Inventory\Models\RawMaterialReceiving','key'=>'raw_material_receivings_id'],
        'dailymaterial' =>['Bt\Inventory\Models\DailyMaterial','key'=>'dailmaterial_id'],
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
        if($this->dailmaterial_id > 0){
           $this->datecaptured =  $this->dailymaterial->datecaptured;
        }
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

    public function getMaterialreceivingOptions()
    {
        $Obj = array();
        $mat = ModelReceiving::with('productname')->get();

        foreach ($mat as $key => $value) {
            if (isset($value->productname) && isset($value->productname->name)) {
                $Obj[$value->id] =$value->supplier_batch   .
                    " - " . $value->productname->name;
            }
        }
        return $Obj;
    }





}
