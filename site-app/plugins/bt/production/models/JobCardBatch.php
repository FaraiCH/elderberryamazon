<?php namespace Bt\Production\Models;

use Model;
use BackendAuth;

/**
 * JobCardBatch Model
 */
class JobCardBatch extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_job_card_batches';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['jobcard_id',  'id'];

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

    public function beforeDelete()
    {
        $control = ControlSheet::where('batch_id', $this->id)->first();
        if (empty($control)) {
            return true;
        } else {
            \Flash::error('Cannot Delete Batch attached to a controlsheet!');
            return false;
        }
    }
}
