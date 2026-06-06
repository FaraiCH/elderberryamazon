<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;
/**
 * Srnapprove Model
 */
class Srnapprove extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_srnapproves';

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
        'srn' => ['Bt\Sales\Models\Srn','key'=>'srn_id'],
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

     public function afterUpdate()
    {  
       
        if(!empty($this->srn->requestunapprove) && count($this->srn->requestunapprove) > 0)
            foreach ($this->srn->requestunapprove as $key => $value) {
                if($value->is_used != 1){
                    $value->is_used = 1;
                    $value->save();
                }
                // code...
            }

    }
}
