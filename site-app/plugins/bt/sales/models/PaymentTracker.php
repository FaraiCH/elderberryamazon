<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;

/**
 * PaymentTracker Model
 */
class PaymentTracker extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_payment_trackers';


    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
        'payment_date'                  => 'required',
        'amount' => 'required',
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
     'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = ['files' => 'System\Models\File'];

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
