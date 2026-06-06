<?php

namespace Bt\Sales\Models;

use Model;
use BackendAuth;
use Input;
use Bt\Sales\Models\Invoice;
use Bt\Sales\Models\Newquote;
use Bt\Production\Models\Push as PushModel;
use Bt\Sales\Models\QuoteItemCatalogue as QuoteItemCatalogue;

/**
 * SrnCatalogue Model
 */
class SrnCatalogue extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_srn_catalogues';


    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'quotecat_id'                  => 'required',
        'units'                  => 'required'
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
        'srn' => ['Bt\Sales\Models\Srn','key'=>'srn_id'],
        //'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'qoutecat' => ['Bt\Sales\Models\QuoteItemCatalogue','key'=>'quotecat_id'],

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


    public function listCatalogueitems($fieldName, $value, $formData)
    {
        $srnId = \Request::segment(6);
        $arrayName = array();
        if (!empty($srnId)) {
            $srn = Srn::find($srnId);
            $quoteId = $srn->quote_id;
            $inv =  Newquote::find($quoteId);

            if (!empty($inv->itemscat)) {
                foreach ($inv->itemscat as $itemscat) {
                    $qc = $itemscat->units;
                    $dlv = $itemscat->getTotalDelivered();
                    $good = $qc - $dlv;

                    if ($good > 0) {
                        $quoteName = "#QUOTE ".$quoteId." #ITEM ";
                        $itemName = $itemscat->id." : DESC #".$itemscat->description;
                        $quantities = " : ORDERS UNITS #".$qc." : DELIVERED #".$dlv." : TO DELIVER#".$good;
                        $arrayName[$itemscat->id] = $quoteName . $itemName . $quantities;
                    }
                }
            }
        }

        return $arrayName;
    }

    public function getUnitsOptions()
    {
        $arrayName = array();
        if ($this->quotecat_id) {
            $pipe = QuoteItemCatalogue::find($this->quotecat_id);
            if (!empty($pipe)) {
                $qc = $pipe->units;
                $dlv = $pipe->getTotalDelivered();

                $good = $qc - $dlv;

                if ($good > 0) {
                    for ($i=1; $i <= $good; $i++) {
                        $arrayName[$i] = $i." Item" ;
                    }
                }
            }
        }
        return $arrayName;
    }
}
