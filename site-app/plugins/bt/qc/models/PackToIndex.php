<?php namespace Bt\QC\Models;

use Model;
use BackendAuth;
/**
 * PackToIndex Model
 */
class PackToIndex extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_qc_pack_to_indices';

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
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [
        'indexs' =>['Bt\QC\Models\DataPackIndex','key'=>'data_id','other'=>'index_id'],  
    ];
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
