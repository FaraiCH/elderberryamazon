<?php namespace Bt\Production\Models;

use Model;
use BackendAuth;
use Bt\Production\Models\Pipe as PipeModel;

/**
 * PrintStickerItems Model
 */
class PrintStickerItems extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_print_sticker_items';
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
        'schedule_date' => 'required',
        'pipe_id' => 'required',
        
        'units' => 'required',
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
    'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
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

    public function listPipesitems($fieldName, $value, $formData)
    {
        
        $i =  PipeModel::all();
        $arrayName = array();

        foreach ($i as $key_ => $value_) {
            $inv = "Quote ".$value_->qpush->quote->id;
            $sum = 0;
            if (!empty($value_->schedules)) {
                $sum = $value_->schedules->sum("total_units_produced");
            }
            $arrayName[$value_->id] = $value_->qpush->quote->company_name." ($inv) :".(isset($value_->quoteitems->description)?$value_->quoteitems->description:"***Item removed from Quote/Production")." (Units Produced $sum)";
        }
        
        return $arrayName;
    }
}
