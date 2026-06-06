<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;
use Input;
use Backend;
use Bt\Sales\Models\Srn;
/**
 * Invoice Model
 */
class Invoice extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_invoices';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        
        'name'                  => 'required',
        'invoice_date' => 'required',
        'file' => 'required',
        'amount' => 'required',
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
        'srn' => ['Bt\Sales\Models\Srn','key'=>'srn_id','orderby'=>'id, desc'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = ['file' => 'System\Models\File'];
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

    public function getSrnIdOptions(){
        $arrayName = array();
        $urlArra = explode("/",$_SERVER['REQUEST_URI']);
        $q = 0;
        $q = $urlArra[count($urlArra)-1];
        
        if($q == 0){
            if($this->quote_id){
                $q = $this->quote_id;
            }elseif(isset(Input::get('Newquote')["id"])){
                $q = Input::get('Newquote')["id"];
            }
        }

        if($q > 0){
            $obj =Srn::where("quote_id",$q)->get();
            foreach ($obj as $key => $value) {
               $arrayName[$value->id] = $value->id.' # '.$value->schedule_date;
            }
        
        }

        return $arrayName;
    }

}
