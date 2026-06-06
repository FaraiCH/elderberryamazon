<?php namespace Bt\Boardroom\Models;

use Model;
use BackendAuth;
use Hash;

/**
 * Visitor Model
 */
class Visitor extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_boardroom_visitors';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'date'    => 'required',
        'visitorname'    => 'required',
        'hostname' => 'required',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
     'files' => 'System\Models\File',
    ];

    public function beforeCreate()
    {
        $initial = Hash::make($this->id . ''.$this->visitorname);
        $pattern = '/\//';
        $pattern2 = '/\$/';
        $replacement = '';
        $removedash = preg_replace($pattern, $replacement, $initial);
        $removedoller = preg_replace($pattern2, '', $removedash);
        $this->key_pass = $removedoller;
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }
    public function beforeUpdate()
    {
        $initial = Hash::make($this->id . ''.$this->visitorname);
        $pattern = '/\//';
        $pattern2 = '/\$/';
        $replacement = '';
        $removedash = preg_replace($pattern, $replacement, $initial);
        $removedoller = preg_replace($pattern2, '', $removedash);
        if (!isset($this->key_pass)) {
            $this->key_pass = $removedoller;
        }
        $user = BackendAuth::getUser();
        if (!$user) return;
        if (isset($user->id)) {
            $this->created_by = $user->id;
        }
    }

    public function getLocationOptions()
    {
        return ['Boardroom','KL Office', 'KM Office', 'FC Office', 'MG Office', 'BM Office', 'GC Office', 'PTM Office', 'SMP Office', 'NSI Office'];
    }
}
