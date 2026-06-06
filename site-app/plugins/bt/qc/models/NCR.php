<?php namespace Bt\QC\Models;

use Model;
use BackendAuth;
/**
 * NCR Model
 */
class NCR extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_qc_n_c_r_s';

     use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
        'customer_name' => 'required',
        'department' => 'required',

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
    public $hasOne = [
        'ncrapprove' => ['Bt\QC\Models\Ncrappprove','key'=>'ncr_id'],
        'ncrpreppare' => ['Bt\QC\Models\Ncrpreppare','key'=>'ncr_id'],
    ];
    public $hasMany = [];
    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'department' =>['Bt\HR\Models\Department','key'=>'department_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'type' =>['Bt\QC\Models\Ncrtype','key'=>'type_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
    'files' => 'System\Models\File',
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
