<?php namespace Bt\QC\Models;

use Model;
use BackendAuth;
use Bt\Production\Models\Push as PushModel;
use Bt\Production\Models\Pipe as PipeModel;

/**
 * PipeReport Model
 */
class PipeReport extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_qc_pipe_reports';

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
        'date' => 'required',
        'quote' => 'required',
        'item_id' => 'required'
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
    public $hasOne = [
       'bacapproved' => ['Bt\QC\Models\Bacapprove','key'=>'material_id'],
    ];
    public $hasMany = [
       'release' =>['Bt\Inventory\Models\StockRelease','key'=>'raw_material_receivings_id'],
       'request' =>['Bt\Inventory\Models\RequestMaterial','key'=>'raw_material_receivings_id'],
       'used' =>['Bt\Production\Models\MaterialUsed','key'=>'raw_material_receivings_id'],
       'datapack'=>['Bt\QC\Models\Datapack','key'=>'pipereport_id'],
    ];
    public $belongsTo = [
        'pipedesc' => ['Bt\Sales\Models\Quoteitems','key'=>'pipedescrip_id'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'item' => ['Bt\Sales\Models\Quoteitems','key'=>'item_id'],
        'datapack' =>['Bt\QC\Models\Datapack','key'=>'datapack_id'],
        'purchase' =>['Bt\Inventory\Models\Purchase','key'=>'purchase_id'],
        'productname' =>['Bt\Inventory\Models\PartNames','key'=>'part_name_id','orderby'=>'name'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'supplier_batch' => ['Bt\Inventory\Models\RawMaterialReceiving']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [

      'coa_file' => 'System\Models\File',
    ];
    public $attachMany = [

       'mfifiles' => 'System\Models\File',
        'mfi_image' => 'System\Models\File',
        'files' => 'System\Models\File',

        'hydro_image' => 'System\Models\File',
        'hydro_file' => 'System\Models\File',

        'hydro_image_2' => 'System\Models\File',
        'hydro_file_2' => 'System\Models\File',

        'hydro_image_3' => 'System\Models\File',
        'hydro_file_3' => 'System\Models\File',



        'elongation_image' => 'System\Models\File',
        'elongation_file' => 'System\Models\File',

        'thermal_image' => 'System\Models\File',
        'thermal_file' => 'System\Models\File',

        'iot_image' => 'System\Models\File',
        'iot_file' => 'System\Models\File',

        'iotfiles_post' => 'System\Models\File',
        'iot_image_post' => 'System\Models\File',

        'coc_file' => 'System\Models\File',

        'mfi_image_post' => 'System\Models\File',
        'mfifiles_post' => 'System\Models\File',

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

     public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
     public function getItemIdOptions(){
        $arrayName = array();

        $quote_id = $this->quote_id;

        if($quote_id > 0){
            $i =  PushModel::where("quote_id",$quote_id)->first();
            if(!empty($i->pipes)){
                foreach ($i->pipes as $key => $pipe) {
                    if(isset($pipe->quoteitems->id)){
                        $arrayName[$pipe->quoteitems->id] = " #ITEM ".$pipe->quoteitems->id." : DESC #".$pipe->quoteitems->description;
                    }
                }
            }

            $i =  PushModel::where("quote_id",$quote_id)->first();
            if(!empty($i->quote->pipesdeliver)){
                foreach ($i->quote->pipesdeliver as $key => $pipe) {
                    if(isset($pipe->quoteitems->id)){
                        $arrayName[$pipe->quoteitems->id] = " ASSOCIATED #ITEM ".$pipe->quoteitems->id." : DESC #".$pipe->quoteitems->description;
                    }
                }
            }
        }
        return $arrayName;
    }

    public function getSupplierBatchOptions(){
        $mat_batch = array();
        $pipe = PipeModel::where('quoteitem_id', $this->item_id)->get();
        foreach($pipe as $p){
            if($p->schedules->sum('total_units_passed_qc') > 0 ){
                foreach ($p->schedules as $schedule){
                    foreach ($schedule->usedmaterials as $mat){
                        $mat_batch[$mat->receiving->id] = $mat->receiving->supplier_batch;
                    }
                }
            }
        }
        return $mat_batch;
    }
}
