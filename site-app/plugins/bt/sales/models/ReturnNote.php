<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;
use Input;
use Bt\Sales\Models\Srn;
use Bt\Sales\Models\SrnItem;


/**
 * ReturnNote Model
 */
class ReturnNote extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_return_notes';

      use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
        'note'                  => 'required',
        'units' => 'required',
        'return_date' => 'required',
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
        'srn' => ['Bt\Sales\Models\Srn','key'=>'srn_id'],
        'items' => ['Bt\Sales\Models\SrnItem','key'=>'item_id'],
        'itemscat' => ['Bt\Sales\Models\SrnCatalogue','key'=>'cat_id'],
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

     public function listSrnitems($fieldName, $value, $formData)
    {

        $arrayName = array();
        if(!empty(Input::get('Srn')['id'])){
                $i =  Srn::where("id",Input::get('Srn')['id'])->first();
                if(!empty($i->items)){
                    foreach ($i->items as $key => $pipe) {
                        $total_return = 0;
                        $return_items = ReturnNote::where("item_id",$pipe->id)->get();
                        if(!empty($return_items) && $return_items->sum("units") > 0)
                          $total_return = $return_items->sum("units");

                        $arrayName[$pipe->id] =  $pipe->id.": ".$pipe->pipe->quoteitems->description.", Units: ".$pipe->units.", Max :".($pipe->units-$total_return); 
                    }
                }
        }
        return $arrayName;
    }

    public function getUnitsOptions()
    {
        
        $item = SrnItem::find($this->item_id);
        $return_items = ReturnNote::where("item_id",$this->item_id)->get();
        $total_return = 0;
        if(!empty($return_items) && $return_items->sum("units") > 0)
          $total_return = $return_items->sum("units");

        $arrayName = array();
        if(!empty($item)){
          
          for ($i=1; $i <= ($item->units - $total_return); $i++) { 
               $arrayName[$i] = $i." Unit"; 
          }

          if(empty($arrayName)){
            return ['' => '-- max units ('.$total_return.') returned --'];
          }else{
            return $arrayName;    
          }

        }else{
          return $arrayName;
        }

        
        

    }

     public function listSrnitemsDep()
    {
        $arrayName = array();
       
        $i =  Srn::where("id",$this->srn->id)->first();

        if(!empty($i->items)){
            foreach ($i->items as $key => $pipe) {
                       $arrayName[$pipe->id] = $pipe->pipe->quoteitems->description.", qty: ".$pipe->units; 
            }
        }
        
        return $arrayName;
    }

}

