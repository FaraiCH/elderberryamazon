<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;
use Bt\Sales\Models\Invoice;
use Bt\Production\Models\Push as PushModel;
use Illuminate\Support\Facades\DB;

/**
 * DeliveryPlan Model
 */
class DeliveryPlan extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_delivery_plans';


    use \October\Rain\Database\Traits\Validation;

    public $rules = [

        'quote_id' => 'required',
        'schedule_date' => 'required',
        'client' => 'required',
        'type' => 'required',
        'load_date' => 'required',
        'notes' => 'required',
//        'city' => 'required',
        'transporter_name' => 'required',
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
    public $hasOne = [
    ];
    public $hasMany = [
        'items' => ['Bt\Sales\Models\DeliveryItem','key'=>'plan_id'],
        'itemscat' => ['Bt\Sales\Models\Deliverycatalogue','key'=>'plan_id'],
    ];

    public $belongsTo = [
        'client' => ['Bt\Sales\Models\Client','key'=>'client_id','order'=>'company_name'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id',],
        'invoice' => ['Bt\Sales\Models\Invoice','key'=>'invoice_id'],
        'type' => ['Bt\Sales\Models\DeliveryType','key'=>'type_id'],
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
    ];
    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
        $this->makeaddress();

    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
        $this->makeaddress();

    }
    public function makeaddress()
    {
        $arrayName = array();
        $arrayName[] = isset($this->unit_complexname_number)?$this->unit_complexname_number:"";
        $arrayName[] = isset($this->street_number)?$this->street_number:"";
        $arrayName[] = isset($this->street_name)?$this->street_name:"";
        $arrayName[] = isset($this->city)?$this->city:"";
        $arrayName[] = isset($this->suburb)?$this->suburb:"";
        $arrayName[] = isset($this->postal_code)?$this->postal_code:"";
        $this->address =  implode(', ', array_filter($arrayName));
    }

     public function listInvoiceitems($fieldName, $value, $formData)
    {
        $i =  PushModel::all();

        $arrayName = array();
        foreach ($i as $value_) {
            if (!empty($value_->quote) && $value_->quote->invoice) {
                $invoiceName = $value_->quote->invoice->name;
                $companyName = $value_->quote->company_name;
                $arrayName[$value_->quote->invoice->id] = $invoiceName." - ".$companyName;

            }
        }

        return $arrayName;
    }

    public function getQuoteIdOptions()
    {

        $arrayName = array();
        $status = null;
        if (isset($this->client->id)) {
            $allarrays = Newquote::where('client_id', $this->client->id)->orderBy('id', 'desc')->get();
            foreach ($allarrays as $value) {
                if ($value->deliveryrequest > 0) {
                    $status = 'Yes';
                } else {
                    $status = 'No';
                }
                $arrayName[$value->id] = "QT #".$value->id.' : '.$value->client->company_name.' : '.
                    'Delivery Requested Quote: ' .$status;
            }
        }

        return $arrayName;

    }

    public function filterFields($fields, $context = null)
    {
        $this->deliveryDetails($fields);

        $quoteOptions = $this->getQuoteIdOptions();

        // Check if the current quote ID exists in the options array
        if (isset($quoteOptions[$this->quote_id])) {
            $quote = $this->quote_id;
            $link = '<a href="/admin/bt/sales/newquote/update/' . $quote . '" target="_blank">' . $quote . '</a>';

            // If the option has "Yes" in its value, set the comment as "Delivery Requested: Yes"
            if (strpos($quoteOptions[$this->quote_id], 'Yes') !== false) {
                $amount = $this->quote->deliveryamount;
                $amounthidden = $this->quote->deliveryamounthidden;

                $sumAmount = $amount + $amounthidden;
                $amountDisplay = ($sumAmount == 0) ? "0" : "R" . $sumAmount;

                $fields->type->comment = "Delivery requested: Yes, the quote  $link
                is eligible for delivery.". "<br>Delivery amount:  " . $amountDisplay;
                if ($this->type_id == 1) {
                    $requiredText = "All delivery details bellow are required. Please fill In.";
                    $styleText = 'color:whitesmoke;background:red;padding:4px 10px;border-radius:4px;display:block';
                    $fields->section4->label = "Delivery Details (Required)";
                    $fields->section4->comment = "<span style='{$styleText}'><b>{$requiredText}</b></span>";
                }
            } else {
                // Otherwise, set the comment as "Delivery Requested: No"
                $fields->type->comment = "Delivery requested: No, the quote . $link . is eligible for collection";
            }
        } else {
            // If the current quote ID is not found in the options array, set the comment to an empty string
            $fields->type->comment = " ";
        }

    }

    public function deliveryDetails($fields)
    {
        $arrayName = array();
        $arrayName[] = isset($fields->unit_complexname_number->value)?$fields->unit_complexname_number->value:"";
        $arrayName[] = isset($fields->street_number->value)?$fields->street_number->value:"";
        $arrayName[] = isset($fields->street_name->value)?$fields->street_name->value:"";
        $arrayName[] = isset($fields->city->value)?$fields->city->value:"";
        $arrayName[] = isset($fields->suburb->value)?$fields->suburb->value:"";
        $arrayName[] = isset($fields->postal_code->value)?$fields->postal_code->value:"";
        $fields->address->value =  implode(', ', array_filter($arrayName));
    }



}
