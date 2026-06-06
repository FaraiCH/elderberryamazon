<?php namespace Bt\Reporting\Models;

use Bt\Production\Models\ControlSheet;
use Bt\Sales\Models\Diameter;
use Bt\Sales\Models\Newquote;
use Bt\Sales\Models\Pickslip;
use Bt\Sales\Models\PNRating;
use Model;
/**
 * ViewStickerData Model
 */
class ViewStickerData extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'new_view_stickerdata';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = ['id', 'pickslip_id', 'dispatch_date'];

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
        'controlsheet' => ['Bt\Production\Models\ControlSheet', 'key' => 'controlsheet_id'],
        'quote' => ['Bt\Sales\Models\Newquote', 'key' => 'quote_no'],
        'pickslip' => ['Bt\Sales\Models\Pickslip', 'key' => 'pickslip_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getControlsheets(){
        return ControlSheet::orderBy('id', 'desc')->lists('id', 'id');
    }

    public function getQuotes(){
        return Newquote::orderBy('id', 'desc')->lists('id', 'id');
    }
    public function getPickslip(){
        return Pickslip::orderBy('id', 'desc')->lists('id', 'id');
    }

    public function getQCStatus(){
        return [1 => 'Pass', 2 => 'Fail', 3 => 'On Hold', 4 => 'Scrap'];
    }
    public function getProductionScrap(){
        return [0=>'No', 1=>'Yes'];
    }

    public function getPipeSize(){
        $pipesizeObj = array();
        $diameters = Diameter::all();
        foreach ($diameters as $diameter){
            $pipesizeObj[$diameter->name . 'mm'] = $diameter->name . 'mm';
        }
        return $pipesizeObj;
    }

    public function getPNRating(){
        $pnObj = array();
        $pn_ratings = PNRating::all();
        foreach ($pn_ratings as $pn_rating){
            $pnObj[$pn_rating->name] = $pn_rating->name;
        }
        return $pnObj;
    }
}
