<?php namespace Bt\Sales\Models;

use Bt\Production\Models\Pipe as PipeModel;
use Model;
use Input;
/**
 * PickslipItem Model
 */
class PickslipItem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_pickslip_items';

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
    public $rules = [];

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
        'pickslip' => ['Bt\Sales\Models\Pickslip'],
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'quoteitem' => ['Bt\Sales\Models\Quoteitems','key'=>'quoteitem_id'],
        // 'product' => ['Bt\Sales\Models\Product','key'=>'product_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function listQuoteitems($fieldName, $value, $formData)
    {
        $arrayName = array();
        $srnURL = \Request::segment(6);
        $pickslipitem = Pickslip::find($srnURL);

        $quote_id = $pickslipitem->quote_id;
            if($srnURL > 0){

                $pipes = PipeModel::whereHas('quoteitems', function ($query)use($quote_id){
                    $query->whereHas('quote', function ($que)use($quote_id){
                        $que->where('id',$quote_id);
                    });
                })->get();

                if(!empty($pipes)){
                    foreach ($pipes as $key => $pipe) {
                        $qc = $pipe->getTotalProduced();
                        $dlv = $pipe->getTotalDelivered();

                        $good = $qc - $dlv;
                        foreach ($pipe->jobcard as $job){
                            foreach($job->batch as $batch){
                                if($good > 0){
                                    $arrayName[$pipe->id] = " BATCH: ". $job->id . "-" . $batch->id . " : ". $pipe->quoteitems->description . ": QTY : " . $good;

                                }else{
                                    $arrayName[$pipe->id] = " BATCH: ". $job->id ."-" . $batch->id . " : " . $pipe->quoteitems->description . ": QTY : ". $good;
                                }
                            }

                        }

                    }
                }
            }

            if(isset($quote_id)){
                $q = Newquote::find($quote_id);

                foreach ($q->pipesdeliver as $key => $pipe) {

                    $qc = $pipe->getTotalProduced();
                    $dlv = $pipe->getTotalDelivered();
                    $good = $qc - $dlv;
                    foreach ($pipe->jobcard as $job) {
                        foreach ($job->batch as $batch)
                            $arrayName[$pipe->id] = "BATCH: ". $job->id . "-". $batch->id. " : " . $pipe->quoteitems->description . ": QTY : ". $good;
                    }

                }

            }

            $pipes =  PipeModel::where("push_id",41)->where('created_at',">","2023-01-01 00:00:00")->get();

            if(!empty($pipes)){
                foreach ($pipes as $key => $pipe) {
                    $qc = $pipe->getTotalProduced();
                    $dlv = $pipe->getTotalDelivered();
                    $good = $qc - $dlv;
                    $arrayName[$pipe->id] = "BT ACCOUNT: ". $pipe->quoteitems->description . ": QTY:" . $good;
                }

        }
        return $arrayName;
    }

    public function getUnitsOptions()
    {
        $quote_id = Pickslip::find(\Request::segment(6));
        $arrayName = array();
        if($this->pipe_id){
            $pipe = PipeModel::find($this->pipe_id);
            if(!empty($pipe)){

                $qc = $pipe->getTotalProduced();
                $dlv = $pipe->getTotalDelivered();

                $good = $qc - $dlv;

                if($good > 0){
                    for ($i=1; $i <= $good; $i++) {
                        $arrayName[$i] = $i." Pipes" ;
                    }
                }
            }
        }
        return $arrayName;
    }

    public function getPickId(){

        if(!empty(Input::get('Pickslip'))){
            if(!empty(Input::get('Pickslip')["id"])){
                return Input::get('Pickslip')["id"];
            }
        }else{
            return $this->pickslip_id;
        }

    }

}
