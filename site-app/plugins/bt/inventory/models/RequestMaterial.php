<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;
use Flash;
use Bt\Inventory\Models\RawMaterialReceiving as RawMaterialReceivingModel;
use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;
use Http;
use Mail;
use Config;

/**
 * RequestMaterial Model
 */
class RequestMaterial extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_request_materials';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'requesteddate' => 'required',
        'kg' => 'required',
        'reason' => 'required',
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
        'reason' =>['Bt\Inventory\Models\ReleaseReason','key'=>'release_reason_id'],
        'receiving' =>['Bt\Inventory\Models\RawMaterialReceiving','key'=>'raw_material_receivings_id'],        
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function afterSave(){
        ##SEND EMAIL TO raw-material-notification
        
        ##LOOP THROUGH USERS THAT ARE GROUP 9  
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;

        $groupid = 9;
        // $users = User::with(['groups' => function ($query) use ($groupid) {
        //     $query->where('id', $groupid);
        // }])->get();

        $groupusers = UserGroup::where('id', $groupid)->first();

        $url = env('APP_URL') .'/admin/bt/inventory/rawmaterialreceiving/update/'.$this->receiving->id;
        $link = " 
                * View Quote: $url";

        foreach ($groupusers->users as $key => $value) {
                    
            #REQUEST DISCOUNT
             $data = [
                'email' => 'BT.sales.material.requestrelease',
                'to_name' => $value->name,
                'to_email' =>  $value->email,
                'sales_name' => $user->first_name.' '.$user->last_name,
                'kg' => $this->kg,
                'reason' => $this->reason->name,
                'requesteddate' => $this->requesteddate,
                'supplier_batch' =>  $this->receiving->supplier_batch,
                'product_name' => $this->receiving->productname->name,
                'ref' => "#".$this->receiving->productname->name." Batch #".$this->receiving->supplier_batch,
                'response_details' => $link
            ];
            $this->sendmail($data);
        }


    }
   
    public function beforeCreate()
    {        
        if($this->checkkg($this->kg,$this->raw_material_receivings_id)){
           $user = BackendAuth::getUser();
        if (!$user) return;
            $this->created_by = $user->id; 
        }else{
            return false;
        }        
    }
    public function beforeUpdate()
    {
       
        if($this->checkkg($this->kg,$this->raw_material_receivings_id)){
            $user = BackendAuth::getUser();
        if (!$user) return;
            $this->updated_by = $user->id;
        }else{
            return false;
        }
    }

    private function checkkg($kg,$mre){
        $obj = RawMaterialReceivingModel::find($mre); 
        $countweight = 0;

        foreach ($obj->release as $key => $value) {
            $countweight += $value->kg;
        }
        $total = $countweight;
        $countweight += $kg;

        
        if($kg > 0 && $obj->weight >= $countweight){
            return true;
        }else{
            Flash::error("Invalid weight $kg kg (Max ".($obj->weight - $total)." kg)");
            return false;
        }
    }

    private function sendmail($data){
        Mail::send($data['email'], $data, function($message) use ($data) {
            $message->to($data['to_email'], $data['to_name']);
        });
    }

}
