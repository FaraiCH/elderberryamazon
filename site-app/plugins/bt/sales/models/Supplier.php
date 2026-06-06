<?php namespace Bt\Sales\Models;

use Model;

/**
 * Supplier Model
 */
class Supplier extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_suppliers';

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
     'products' =>['Bt\Sales\Models\SupplierStock','key'=>'supplier_id']
    ];
    public $belongsTo = [
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
