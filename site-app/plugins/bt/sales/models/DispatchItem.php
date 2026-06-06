<?php namespace Bt\Sales\Models;

use Bt\Logistics\Models\Vehicle;
use Model;

use BackendAuth;

/**
 * DispatchItem Model
 */
class DispatchItem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_sales_dispatch_items';

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
        'quote' => ['Bt\Sales\Models\Newquote', 'key' => 'quote_id'],
        'destination' => ['Bt\Sales\Models\TransportRatesDestination',  'key' => 'destination_id'],
        'vehicle' => ['Bt\Sales\Models\TransportType', 'key' => 'vehicle_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
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
        if(!empty($user) && isset($user->id)) {
            $this->created_by = $user->id;
        }
    }

    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        if(!empty($user) && isset($user->id)) {
            $this->updated_by = $user->id;
        }
    }

    public function getDestinationOptions(){

        return TransportRatesDestination::orderBy('name')
            ->whereHas('transportfee', function ($query){
                $query->where('active', 1);
            })
            ->lists('name', 'id');
    }

    public function getVehicleOptions(){
        return TransportType::orderBy('name')->lists('name', 'id');
    }

    // Automate Totalweight Calculation
    public function getVihicleLoadWeightAttribute(){
        // Create value for total weight
        $totalweight = 0;

        //Check if quote has any pipe items
        if ($this->quote->items->count() > 0) {
            // Get the sum of the weight for the pipe items
            $totalweight = $this->quote->items->sum('totalweight');
            return $totalweight;
        }
        //Return 0 if pipes are not found
        return $totalweight;
    }

    public function getUnitPriceAttribute(){
        $totalCost = 0.00;
        $discount_perc = $this->discount/ 100;
        if(!empty($this->destination_id) && !empty($this->vehicle)){
            $transportfees = TransportFee::where('transportratesdestination_id', $this->destination_id)->where('active', 1)->first();
            if(!empty($transportfees)){
                $transporType = TransportType::find($this->vehicle_id);
                if($this->vehicle_type == "bt"){
                    // Use BT Truck Rates Instead
                    $column = $this->vehicle_type  ."_".$transporType->to_column;
                }else{
                    $column = $transporType->to_column;
                }
                if($discount_perc > 0){
                    $discount_price = ($transportfees->$column) * $discount_perc;
                    return ($transportfees->$column) - $discount_price;
                }
                return $transportfees->$column;
            }
        }
        return $totalCost;
    }
    // Autp Total Cost According to Destination and Vehicle
    public function getTotalAttribute(){
        $totalCost = 0.00;
        $discount_perc = $this->discount/ 100;
        if(!empty($this->destination_id) && !empty($this->vehicle)){
            $transportfees = TransportFee::where('transportratesdestination_id', $this->destination_id)->where('active', 1)->first();
            if(!empty($transportfees)){
                $transporType = TransportType::find($this->vehicle_id);
                if($this->vehicle_type == "bt"){
                    // Use BT Truck Rates Instead
                    $column = $this->vehicle_type  ."_".$transporType->to_column;
                }else{
                    $column = $transporType->to_column;
                }
                if($discount_perc > 0){
                    $discount_price = ($transportfees->$column * $this->qty) * $discount_perc;
                    return ($transportfees->$column * $this->qty) - $discount_price;
                }
                return $transportfees->$column * $this->qty;
            }
        }
        return $totalCost;
    }

    public function getRatePerTransportAttribute(){
        // Rate Per Transport = Total Transport Cost/ Total Weight
        $totalCost = 0.00;
        $discount_perc = $this->discount/ 100;
        if(isset($this->total)){
            if($this->vihicle_load_weight > 0){
                if($discount_perc > 0 ){
                    return ($this->total/ $this->vihicle_load_weight);
                }
                return ($this->total/ $this->vihicle_load_weight);
            }
        }
        return $totalCost;
    }

}
