<?php namespace Bt\CRM\Models;

use Model;
use BackendAuth;
/**
 * ExportForm Model
 */
class ExportForm extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_crm_export_forms';
    protected $jsonable = ['listgoods']; 

     use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
        
        'form_date' => 'required',
        
        'customsno' => 'required',
          
        'toname' => 'required',
          
        'towhom' => 'required',
          
        'declaration' => 'required',
          
        'listgoods' => 'required',
          
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
