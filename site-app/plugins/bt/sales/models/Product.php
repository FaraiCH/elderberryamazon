<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;
/**
 * Product Model
 */
class Product extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_products';

     use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'PNRating'                  => 'required',
        'Diameter'                  => 'required',
        'value'                  => 'required'
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
        'quoteitem' => ['Bt\Sales\Models\Quoteitems','key'=>'product_id'],
    ];
    public $belongsTo = [
        'PNRating' => ['Bt\Sales\Models\PNRating','key'=>'pn_ratings_id'],
        'Diameter'    => ['Bt\Sales\Models\Diameter'],
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
        //$user = BackendAuth::getUser();
        if (!$user) return;
        //$this->updated_by = $user->id;
    }
    // public function getWtAveAttribute(){
    //     $num = round(($this->wt_max + $this->wt_min)/2, 2);
    //     return $num;
    // }
}
