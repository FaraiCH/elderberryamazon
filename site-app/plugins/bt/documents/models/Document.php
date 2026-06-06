<?php namespace Bt\Documents\Models;

use Model;
use BackendAuth;
use Bt\Documents\Models\Sub as SubFolderModel;
/**
 * Document Model
 */
class Document extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_documents_documents';
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'mainfolder'                  => 'required',
        'subfolder'                  => 'required',
        'name'                  => 'required'
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
        'mainfolder' =>['Bt\Documents\Models\Category','key'=>'category_id'],
        'subfolder' =>['Bt\Documents\Models\Sub','key'=>'sub_id'],
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
    public $morphedByMany = [
        'back_users'  => ['Backend\Models\User',
            'table'=>'tbl_user_association',
            'name' => 'tbl_association',
            'key'=>'association__id',
            'otherKey'=>'tbl_association__id',
            'pivot' => ['user_rights'],
        ],

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

    public function checkMe(){
        $user = BackendAuth::getUser();
        if (!$user) return;
        return $user->id;
    }


}
