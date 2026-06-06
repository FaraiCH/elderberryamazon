<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;

/**
 * PartNames Model
 */
class PartNames extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_part_names';

     use \October\Rain\Database\Traits\Validation;

    public $rules = [];

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
        'supplier' =>['Bt\Inventory\Models\Supplier','key'=>'supplier_id'],
        'category' =>['Bt\Inventory\Models\MaterialCat','key'=>'cat_id'],
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
        if ($user = BackendAuth::getUser()) {
            $this->created_by = $user->id;
        }
    }
    public function beforeUpdate()
    {
        if ($user = BackendAuth::getUser()) {
            $this->updated_by = $user->id;
        }
    }
}
