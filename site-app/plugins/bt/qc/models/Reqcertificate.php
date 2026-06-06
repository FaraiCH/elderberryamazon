<?php namespace Bt\QC\Models;

use Bt\Production\Models\Push;
use Bt\Sales\Models\Quoteitems;
use Model;
use BackendAuth;
use System\Models\File;
/**
 * reqcertificate Model
 */
class Reqcertificate extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_qc_reqcertificates';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = ['items'];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'approvecoc' => ['Bt\QC\Models\Approvecoc','key'=>'reqcertificate_id'],
    ];
    public $hasMany = [
    ];
    public $belongsTo = [
        'item' => ['Bt\Sales\Models\Quoteitems','key'=>'item_id'],
        'quotes' => ['Bt\Sales\Models\Newquote','key'=>'quote_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'cocfile' => 'System\Models\File',
        'coafile' => 'System\Models\File',
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

    public function getDescriptionOptions(){
        $arrayName = array();
        $urlArra = explode("/",$_SERVER['REQUEST_URI']);
        $pushUrl = $urlArra[count($urlArra)-1];

        if($pushUrl == 0){
            if($this->quote_id){
                $pushUrl = $this->quote_id;
            }elseif(isset(Input::get('Newquote')["id"])){
                $pushUrl = Input::get('Newquote')["id"];
            }
        }
        if($pushUrl > 0){
            $qq = Quoteitems::where("quote_id",'=',$pushUrl)->lists('description', 'id');
           if(!empty($qq)){
               return Quoteitems::where("quote_id",'=',$pushUrl)->lists('description', 'id');
           }else{
               foreach ($this->items as $d){
                   return Quoteitems::find($d['description'])->lists('description', 'id');
               }
           }
        }
    }

    public function beforeSave()
    {
        foreach($this->coafile as $photo) {
            echo($photo->getPath());
        };
    }


}
