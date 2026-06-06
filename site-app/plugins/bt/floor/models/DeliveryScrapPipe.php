<?php namespace Bt\Floor\Models;

use Model;
use BackendAuth;
use Bt\Production\Models\Schedule as ScheduleModule;
use Bt\Floor\Models\DeliveryScrapPipe as DeliveryScrapPipeModule;
use Flash;

/**
 * DeliveryScrapPipe Model
 */
class DeliveryScrapPipe extends Model
{
    /**
     * @var string The database table used by the model.
     */

    public $table = 'bt_floor_delivery_scrap_pipes';

      use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
        'schedule_date' => 'required',
        'company' => 'required',
        'weight_kg' => 'required',

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
       
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [ 'weightbridge' => 'System\Models\File','file' => 'System\Models\File'];

    public $attachMany = [];

      public function beforeCreate()
    {  

        $obj = ScheduleModule::active()->get();
        $del_obj = DeliveryScrapPipeModule::all();
        $sum = $obj->sum('weight_scrap_kg') - $del_obj->sum('weight_kg');

        // if($sum > 0 && $this->weight_kg  <= $sum){
        //     $user = BackendAuth::getUser();
        if (!$user) return;
        //     if($user->id){
        //         $this->created_by = $user->id;    
        //     }else{
        //         $this->created_by = 1; 
        //     }
        // }else{
        //     Flash::error("Invalid weight ".$this->weight_kg." kg (Max ".($sum)." kg)");
        //     return false;
        // }
         $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
        $this->floor_kg = $sum;
        
        
    }
    public function beforeUpdate()
    {  
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;       
    }
}
