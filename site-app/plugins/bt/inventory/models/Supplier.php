<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;

/**
 * Supplier Model
 */
class Supplier extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_suppliers';
     use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'category' => 'required',

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
        'category' =>['Bt\Inventory\Models\MaterialCat','key'=>'cat_id'],
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
}
