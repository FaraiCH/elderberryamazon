<?php namespace Bt\QC\Models;

use Model;
use BackendAuth;
/**
 * LabResults Model
 */
class LabResults extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_raw_material_receivings';

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
        'bacapproved' => ['Bt\QC\Models\Bacapprove','key'=>'material_id'],
    ];
    public $hasMany = [
        'release' =>['Bt\Inventory\Models\StockRelease','key'=>'raw_material_receivings_id'],
        'request' =>['Bt\Inventory\Models\RequestMaterial','key'=>'raw_material_receivings_id'],
        'used' =>['Bt\Production\Models\MaterialUsed','key'=>'raw_material_receivings_id'],
        'incage' =>['Bt\Inventory\Models\CageMaterial','key'=>'raw_material_receivings_id'],
    ];
    public $belongsTo = [
        'datapack' =>['Bt\QC\Models\Datapack','key'=>'datapack_id'],
        'purchase' =>['Bt\Inventory\Models\Purchase','key'=>'purchase_id'],
        'productname' =>['Bt\Inventory\Models\PartNames','key'=>'part_name_id','orderby'=>'name'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        
        'coa_file' => 'System\Models\File',

    ];
    public $attachMany = [
        'mfifiles' => 'System\Models\File',
        'mfi_image' => 'System\Models\File',
        'files' => 'System\Models\File',

        'hydro_image' => 'System\Models\File',
        'hydro_file' => 'System\Models\File',

        'hydro_image_2' => 'System\Models\File',
        'hydro_file_2' => 'System\Models\File',

        'hydro_image_3' => 'System\Models\File',
        'hydro_file_3' => 'System\Models\File',



        'elongation_image' => 'System\Models\File',
        'elongation_file' => 'System\Models\File',

        'thermal_image' => 'System\Models\File',
        'thermal_file' => 'System\Models\File',

        'iot_image' => 'System\Models\File',
        'iot_file' => 'System\Models\File',

        'coc_file' => 'System\Models\File',

        'mfi_image_post' => 'System\Models\File',
        'mfifiles_post' => 'System\Models\File',
        
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

     public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
     public function scopeNotregrind($query)
    {
        return $query->where('part_name_id',"!=", 5);
    }
    public function scopeRegrind($query)
    {
        return $query->where('part_name_id',"=", 5);
    }
}