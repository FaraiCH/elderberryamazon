<?php namespace Bt\Production\Models;

use Model;
use Bt\Inventory\Models\RawMaterialReceiving;
use BackendAuth;

/**
 * JobcardMaterial Model
 */
class JobcardMaterial extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_jobcard_materials';

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
        'recieve' =>['Bt\Inventory\Models\RawMaterialReceiving','key'=>'raw_material_receivings_id'],
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
    public function getRawMaterialReceivingsIdOptions()
    {
        $obj = RawMaterialReceiving::where("purchase_id", '>', 0)->active()->get();
        $listarray = array();
        foreach ($obj as $key => $value) {
            $listarray[$value->id] =  $value->productname->name." -> Date Recieved: ".\Carbon\Carbon::parse($value->date_of_receipt)->format('d/m/Y').", Batch: ".$value->supplier_batch.", Weight: ".$value->weight." kg, MFI: ".$value->mfi;
        }
       
        return $listarray;
    }
}
