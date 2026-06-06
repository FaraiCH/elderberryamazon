<?php namespace Bt\Sales\Models;

use Model;
use Bt\Sales\Models\Srn;
use Bt\Production\Models\Pipestickeritem as PipeSticker;
/**
 * Pickslip Model
 */
class Pickslip extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'bt_qc_pickslips';

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
          'quote' => 'required',
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
    protected $appends = [
        'srn_values'
    ];

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
        'srn' => ['Bt\Sales\Models\Srn', 'key' => 'pickslip_id']
    ];
    public $hasMany = [
        'items' => ['Bt\Sales\Models\PickslipItem', 'key' => 'pickslip_id'],
        'stickeritems' => ['Bt\Production\Models\Pipestickeritem', 'key' => 'pickslip_id'],
        'itemscat' => ['Bt\Sales\Models\PickslipCatalogue'],
    ];
    public $belongsTo = [
        'quote' => 'Bt\Sales\Models\Newquote',
        'vehicle' =>   ['Bt\Sales\Models\TransportType'],
        'schedule' => ['Bt\Sales\Models\DeliveryPlan','key'=>'linkschedule_id'],
        'type' => ['Bt\Sales\Models\DeliveryType','key'=>'type_id'],
    ];

    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'pickslip' => 'System\Models\File',
    ];
      public $attachMany = [

        'images_truck_arrival' => 'System\Models\File',
        'images_truck_load' => 'System\Models\File',
        'images_truck_finish' => 'System\Models\File',
          'weight_bridge_photo' => 'System\Models\File'

    ];

    public function getQuoteIdOptions(){
        $quoteObj = Newquote::select('id',\Db::raw("concat(id, ' > ', company_name) as full_name"))->
            where('ponumber',"<>","")->orderBy('id', 'desc')->lists('full_name','id');

        return $quoteObj;
    }


    public function getMonster(){
        $monster = [];

        foreach ($this->stickeritems as $key => $sticker) {
            $name = "";
            $diamenter = 0;
            $pn = "";

            if(!empty($sticker->product)){
                $name = $sticker->product_id;
                $diamenter = $sticker->product->Diameter->name;
                $pn =  $sticker->product->PNRating->name;
            }else{
                $name = $sticker->controlsheets->jobcard->pipe->quoteitems->product_id;
                $diamenter = $sticker->controlsheets->jobcard->pipe->quoteitems->product->Diameter->name;
                $pn =   $sticker->controlsheets->jobcard->pipe->quoteitems->product->PNRating->name;
            }

            $length = ($sticker->unit_length??0);
            if($length == 0){
                $length = $sticker->controlsheets->jobcard->pipe->quoteitems->unitlength;
            }
            $name .= "_". (int)$length;

            $monster[$name]['length'] = (int)$length;
            $monster[$name]['diamenter'] = $diamenter;
            $monster[$name]['description'] = $sticker->controlsheets->jobcard->pipe->quoteitems->description;
            $monster[$name]['pn'] = $pn;
            $monster[$name]['stickers'][] = $sticker;
            $monster[$name]['inquote'] = 0;
            $monster[$name]['orderedunits'] = 0;
            $monster[$name]['delivered'] = 0;

            $quoteitems = $sticker->controlsheets->jobcard->pipe->qpush->quote->items;
            if(!empty($quoteitems)){
                foreach ($quoteitems as $item){

                    if($item->product_id == $sticker->product_id && (int)$length == (int)$item->unitlength){
                        $monster[$name]['inquote'] = 1;
                        $monster[$name]['orderedunits'] = (int)$item->units;

                        $srns = Srn::where("quote_id",$this->quote_id)->pluck('id');

                        $sitems = PipeSticker::whereIn('srn_id',$srns)->where("unit_length",$length)->where("product_id", $sticker->product_id)->get();

                        $monster[$name]['delivered'] = count($sitems);




                        // #Check if max pickslip
                        // #Make sure that even if Sales add the same pipe again in the quote, it is still counted
                        // $pipisticker = Pipestickeritem::where('pickslip_id', Input::get('pickslip'))->where('product_id', $sticker->product_id)->get();
                        // $quoteitemcount = Quoteitems::where('product_id', $sticker->product_id)->where("quote_id", $sticker->controlsheets->jobcard->pipe->qpush->quote_id)->get();
                        // if($pipisticker->count() < $quoteitemcount->sum('units')){
                        //     $sticker->pickslip_id = Input::get('pickslip');
                        //     $save = 1;
                        //     \Flash::success("Sticker Units ". $pipisticker->sum('units') . "Q Units ". $quoteitemcount->sum('units'));
                        // }else{
                        //     \Flash::error("Units are full");
                        // }

                    }
                }
            }
        }
        //trace_log($monster);
        return $monster;
    }

    public function getScheduleOptions(){
        $arrayName = array();


        $obj =DeliveryPlan::where('quote_id', $this->quote_id)->orderBy('quote_id', 'DESC')->get();
        foreach ($obj as $key => $value) {
            $arrayName[$value->id] = $value->id.' # '.$value->client->company_name.' # '.$value->schedule_date." By ".$value->createdby->first_name.' '.$value->createdby->last_name;
        }


        return $arrayName;
    }
}
