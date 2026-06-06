<?php namespace Bt\QC\Models;

use Model;
use BackendAuth;
use Input;

/**
 * testingMatrix Model
 */
class TestingMatrix extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_qc_testing_matrices';

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
    public $rules = [
        'testtype'                  => 'required',
        'test_date'                  => 'required',
    ];

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
            'pipedesc' => ['Bt\Sales\Models\Quoteitems','key'=>'pipedescrip_id'],   
            'materialcat' => ['Bt\Inventory\Models\MaterialCat','key'=>'mfimaterial_id'],
            'testtype' => ['Bt\Qc\Models\Testtypes','key'=>'testtype_id'],  
            'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
            'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],

    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    public function getHydroTestOptions(){

            $name = array('20°C - Hydro 100 Hrs','80°C - Hydro 165 Hrs','80°C - Hydro 1 000 Hrs');
            return $name;
    }

    public function getCarbonBlackOptions(){

            $name = array('Content','Dispersion');
            return $name;
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
