<?php namespace Bt\Production\Models;

use Model;
use BackendAuth;
use Bt\Production\Models\Pipe as PipeModel;

/**
 * jobcard Model
 */
class Jobcard extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_jobcards';
     use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'opendate' => 'required',
        'pipe_id' => 'required',

        'product_description' => 'required',
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['status_id'];

    /**
     * @var array Relations
     */
    public $hasOne = [
        // 'jobcardapprove' => ['Bt\Production\Models\Jobcardapprove','key'=>'jobcard_id'],
    ];
    public $hasMany = [
        'materials' => ['Bt\Production\Models\JobcardMaterial','key'=>'jobcard_id'],
        'controlsheets' => ['Bt\Production\Models\ControlSheet','key'=>'jobcard_id'],
        'batch' => ['Bt\Production\Models\JobCardBatch','key'=>'jobcard_id'],
    ];
    public $belongsTo = [
        'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'assignedto' => ['Bt\Maintenance\Models\Staff','key'=>'assignedto_id'],
        'btline' => ['Bt\Production\Models\Line','key'=>'line_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [ 'file' => 'System\Models\File'];
    public $attachMany = [
        'shiftfiles' => 'System\Models\File'
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

    public function listPipeItem($fieldName, $value, $formData)
    {
        $i =  PipeModel::active()->where("id", '>', 0)->get();

        $arrayName = array();
        foreach ($i as $key_ => $value_) {
            if (!empty($value_->quoteitems)) {
                if ($value_->quoteitems) {
                    $arrayName[$value_->id] = "PID".$value_->id." - ".$value_->created_at." ".$value_->qpush->quote->company_name." - Quote-".$value_->qpush->quote->id." - ".$value_->quoteitems->description;
                }
            }
        }

        return $arrayName;
    }

    public function listPipeUpdateItem($fieldName, $value, $formData)
    {

        $i =  PipeModel::where('id', $this->pipe_id)->get();

        $arrayName = array();
        foreach ($i as $key_ => $value_) {
            if (!empty($value_->quoteitems)) {
                if ($value_->quoteitems) {
                    $arrayName[$value_->id] = $value_->qpush->quote->company_name." - Quote-".$value_->qpush->quote->id." - ".$value_->quoteitems->description;
                }
            }
        }

        return $arrayName;
    }
}
