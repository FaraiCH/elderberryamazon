<?php namespace Bt\Suppliers\Models;

use Model;

/**
 * Materialsupplier Model
 */
class Materialsupplier extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_suppliers_materialsuppliers';

    public $rules = [

        'name' => 'required',

    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    protected $jsonable = ['extra_contacts','audits'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'material' =>['Bt\Inventory\Models\PartNames','key'=>'supplier_id']
    ];
    public $belongsTo = [
        'category' => ['Bt\Suppliers\Models\Category'],
        'vendor' => ['Bt\Suppliers\Models\Vendor','key'=>'vendor_type_id'],
        'country' =>['RainLab\Location\Models\Country','key'=>'country_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'beefile' => 'System\Models\File',
    ];
    public $attachMany = [];

    public function beforeCreate()
    {
        $user = \BackendAuth::getUser();
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        $user = \BackendAuth::getUser();
        $this->updated_by = $user->id;
    }
}
