<?php namespace Bt\Inventory\Models;

use Model;
use BackendAuth;
use Carbon\Carbon;
use Config;
use Flash;
use App;
use Redirect;
use Backend;
use Str;
use Mail;
use Twilio\Rest\Client;

/**
 * RawMaterialReceiving Model
 */
class RawMaterialReceiving extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_inventory_raw_material_receivings';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'date_of_receipt' => 'required',
        'weight' => 'required',
        'supplier_batch' => 'required',
        'bags' => 'required',
        'pallet_number' => 'required',

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

    public $hasMany = [
        'release' =>['Bt\Inventory\Models\StockRelease','key'=>'raw_material_receivings_id'],
        'request' =>['Bt\Inventory\Models\RequestMaterial','key'=>'raw_material_receivings_id'],
        'used' =>['Bt\Production\Models\MaterialUsed','key'=>'raw_material_receivings_id'],
        'incage' =>['Bt\Inventory\Models\CageMaterial','key'=>'raw_material_receivings_id'],
        'bagBatches' => ['Bt\Inventory\Models\BagBatch', 'key' => 'raw_material_receiving_id']
    ];
    public $belongsTo = [
        'purchase' =>['Bt\Inventory\Models\Purchase','key'=>'purchase_id'],
        'productname' =>['Bt\Inventory\Models\PartNames','key'=>'part_name_id','orderby'=>'name'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'hydro_image' => 'System\Models\File',
        'hydro_file' => 'System\Models\File',

    ];
    public $attachMany = [
        'mfifiles' => 'System\Models\File',
        'files' => 'System\Models\File',

    ];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
    }

    public function afterCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;

        $name = $user->first_name . ' ' . $user->last_name;


        $x = 0;
        $x++;
        $data = [];
        $data['name'] = $name;
        $data['to_email'] = $this->purchase->supplier->contact_email;
        $data['company'] = $this->purchase->supplier->name;
        $data['ponumber'] = $this->purchase->po_number;
        $data['bags_palletes'] = $this->bags;
        $data['to_kg'] = $this->weight;
        $data['date'] = $this->date_of_receipt;

            Mail::send('BT.inventory.rawmaterialreceiving.confirm', $data, function($message) use ($data) {

                $message->to($data['to_email'], $data['company']);

            });
        \Flash::success( "Thank you, you request have been sent to $x users");
    }

    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }

    // public function sendWhatsAppNotification()
    // {
    //     $account_sid = 'AC4ecdb7aac276d97c3a7bb021e55337c5';
    //     $auth_token = '14f2d48a91b98c87a3c521e0dd3c4dc1';
    //     $twilio_number = 'whatsapp:+14155238886';
    //     $bt_group_numbers = ['whatsapp:+27730637156','whatsapp:+27678934587'];

    //     $supplierName = $this->purchase->supplier->name;
    //     $Weight = $this->weight;
    //     $bags = $this->bags;
    //     $materialType = $this->productname->name;
    //     $batchNumber = $this->supplier_batch;

    //     $message = "Delivery Confirmation:\nSupplier: $supplierName\nMaterial Type: $materialType\nBatch Number: $batchNumber\nWeight Received: $Weight KG\nBags: $bags";

    //     $client = new Client($account_sid, $auth_token);

    //     foreach ($bt_group_numbers as $bt_group_number) {
    //         $client->messages->create(
    //             $bt_group_number,
    //             [
    //                 'from' => $twilio_number,
    //                 'body' => $message
    //             ]
    //         );
    //     }
    // }

    public function checkAndSendEmail()
    {
         
        $allWeightsSet = $this->bagBatches()->where('actual_weight', '<=', 0)->count() == 0;

        if ($allWeightsSet) {
            // $user = BackendAuth::getUser();
        if (!$user) return;
            // $name = $user->first_name . ' ' . $user->last_name;

            if ($this->purchase && $this->purchase->supplier) {
                $data = [
                    // 'name' => $name,
                    'to_email' => $this->purchase->supplier->contact_email,
                    'company' => $this->purchase->supplier->name,
                    'ponumber' => $this->purchase->po_number,
                    'date' => $this->date_of_receipt
                ];

                $totalWeight = 0;
                $totalActualWeight = 0;

                $bags = [];
                foreach ($this->bagBatches as $bag) {
                    $bags[] = [
                        'bag_number' => $bag->bags,
                        'weight' => $bag->weight,
                        'actual_weight' => $bag->actual_weight
                    ];
                    $totalWeight += $bag->weight;
                    $totalActualWeight += $bag->actual_weight;
                }

                $data['bags'] = $bags;
                $data['totalWeight'] = $totalWeight;
                $data['totalActualWeight'] = $totalActualWeight;

                Mail::send('BT.inventory.rawmaterialreceiving.confirmed', $data, function($message) use ($data) {
                    $message->to($data['to_email'])->subject('Raw Material Receiving Confirmed');
                });

                \Flash::success("Thank you, your request has been sent.");
                 // $this->sendWhatsAppNotification();
            } else {
                \Flash::error("Unable to send email. Purchase or Supplier details are missing.");
            }
        }
    }


     public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
     public function scopeNotregrind($query)
    {
        return $query->where('part_name_id',"!=", 5);
    }
    public function scopeRegrind($query)
    {
        return $query->where('part_name_id',"=", 5);
    }
}
