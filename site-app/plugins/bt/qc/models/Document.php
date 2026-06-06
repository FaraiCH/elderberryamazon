<?php namespace Bt\QC\Models;

use Model;
use BackendAuth;
use Bt\QC\Models\Sub as SubFolderModel;
/**
 * Document Model
 */
class Document extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_qc_documents';

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
        'mainfolder' =>['Bt\QC\Models\Category','key'=>'category_id'],
        'subfolder' =>['Bt\QC\Models\Sub','key'=>'sub_id'],
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
