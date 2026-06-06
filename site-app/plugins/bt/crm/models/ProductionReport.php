<?php namespace Bt\CRM\Models;

use Model;
use BackendAuth;
/**
 * ProductionReport Model
 */
class ProductionReport extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_crm_production_reports';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
        'quote'  => 'required',
        'report_date' => 'required',
        'client' => 'required',
        'keypass' => 'required',
        'signature' => 'required',
        
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
        'signature' =>['Bt\HR\Models\Employee','key'=>'signature_id'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'client' => ['Bt\Sales\Models\Client','key'=>'client_id'],
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
}
