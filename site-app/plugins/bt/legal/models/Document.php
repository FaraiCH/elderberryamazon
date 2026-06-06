<?php namespace Bt\Legal\Models;

use Backend\Facades\BackendAuth;
use Bt\Legal\Models\Sub as SubFolderModel;
use Model;

/**
 * document Model
 */
class Document extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_legal_documents';
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'mainfolder'                  => 'required',
        'subfolder'                  => 'required',
        'name'                  => 'required'
    ];
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */


    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

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
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'mainfolder' =>['Bt\Legal\Models\Category','key'=>'category_id'],
        'subfolder' =>['Bt\Legal\Models\Sub','key'=>'sub_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'files' => 'System\Models\File',
        'images' => 'System\Models\File'
    ];

    public function getSubfolderOptions()
    {

        if(isset($this->mainfolder->id)){
            $obj = SubFolderModel::where("category_id",$this->mainfolder->id)->get();
            if(!empty($obj)){
                $myarray = array();
                foreach ($obj as $key => $value) {
                    $myarray[$value->id] = $value->name;
                }
                return $myarray;
            }else{
                return [];
            }
        } else{
            return [];
        }

    }


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
