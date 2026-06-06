<?php namespace Bt\Production\Models;

use Model;
use BackendAuth;
use Bt\Inventory\Models\RawMaterialReceiving;
use Bt\Inventory\Models\PartNames;

/**
 * ControlSheetItem Model
 */
class ControlSheetItem extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_control_sheet_items';
    protected $jsonable = ['material'];

     use \October\Rain\Database\Traits\Validation;

    public $rules = [


        'timeofreading' => 'required',

        //     'wall_thikness_n' => 'required',

        // 'max_wall_ne' => 'required',

        // 'max_wall_e' => 'required',

        // 'max_wall_se' => 'required',

        // 'max_wall_s' => 'required',

        // 'max_wall_sw' => 'required',

        // 'min_wall_w' => 'required',

        // 'min_wall_nw' => 'required'

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
    public $hasMany = [
      'materials' => ['Bt\Production\Models\ControlSheetItemMaterial','key'=>'control_sheet_item_id'],

    ];
    public $belongsTo = [
        'reasonscrap' => ['Bt\Production\Models\ScrapCodes','key'=>'reasonscrap_id'],
        'delay' => ['Bt\Production\Models\DelayReason','key'=>'delay_id'],
        'controlsheet' => ['Bt\Production\Models\ControlSheet','key'=>'controlsheet_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
          'images' => 'System\Models\File',
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

    public function getsupliernameOptions($value, $formData)
    {
        //$obj = PartNames::all();
         $obj = RawMaterialReceiving::active()->where("purchase_id", '>', 0)->get();
        $listarray = array();
        foreach ($obj as $key => $value) {
            $listarray[$value->productname->name." : ".$value->supplier_batch] =  $value->productname->name." : ".$value->supplier_batch;
        }

        return $listarray;
    }
}
