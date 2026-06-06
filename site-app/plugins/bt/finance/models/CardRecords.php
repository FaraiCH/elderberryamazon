<?php namespace Bt\Finance\Models;

use Model;
use BackendAuth;

/**
 * CardRecords Model
 */
class CardRecords extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_finance_card_records';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [

        'storename' => 'required',
        'purchase_date' => 'required',
        'amount' => 'required',
        'mainitem' => 'required',
        
        ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'project' => ['Bt\Finance\Models\Project','key'=>'project_id','other'=>'id'],
        'purchasedby' => ['RainLab\User\Models\User','key'=>'purchasedby_id','other'=>'id'],
        'approvedby' => ['RainLab\User\Models\User','key'=>'approvedby_id','other'=>'id'],
        'pettycash' =>['Bt\Finance\Models\pettycash', 'key'=>'pettycash_id','other'=>'id'],
        
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
      public $attachOne = [
        'signed_requisition' => 'System\Models\File',
      ];
      public $attachMany = [
        'slips' => 'System\Models\File',
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
}
