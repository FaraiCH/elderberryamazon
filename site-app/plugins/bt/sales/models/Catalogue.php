<?php namespace Bt\Sales\Models;

use Model;
use BackendAuth;
/**
 * Catalogue Model
 */
class Catalogue extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_sales_catalogues';
    use \October\Rain\Database\Traits\Validation;


    public $rules = [
//        'name' => 'required',
//        'supplier' => 'required',
//        'category' => 'required',
//        'price' => 'required',
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    /**
     * @var array Fillable fields
     */
    protected $fillable = ['bt_product_id','bt_unitlength','category_id','product_id','supplier_id','name','product_code','description','price','supplierprice','gp','active','size','qty','next_price_date','imageurl'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        ];
    public $belongsTo = [
        'category' => ['Bt\Sales\Models\Category', 'key' => 'category_id'],
        'supplier' => ['Bt\Sales\Models\Supplier', 'key' => 'supplier_id'],
        'parentproduct' => ['Bt\Sales\Models\Category', 'key' => 'product_id'],
        'btproduct' => ['Bt\Sales\Models\Product','key'=>'bt_product_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [
        'supplierproducts' => ['Bt\Sales\Models\SupplierStock','table'=>'bt_sales_catalougue_to_stock','key'=>'catalogue_id','otherKey'=>'supplierstock_id'],
    ];
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

        $fulldescription = null;

        if(isset($this->original['name']))
        {
            if(empty($fulldescription))
            {
                if(isset($this->category->category_name))
                {
                    $fulldescription = $this->category->category_name;
                }
                if(isset($this->btproduct->name))
                {
                    $fulldescription .= " " .$this->btproduct->name;
                }
                if(isset($this->suffix))
                {
                    $fulldescription .= " " .$this->suffix;
                }
            }
            if(isset($this->category->category_name))
            {
                if($fulldescription == $this->category->category_name)
                {
                    return $this->original['name'];
                }
                else
                {
                    return $fulldescription;
                }
            }else
            {
                $this->name = $this->original['name'];
            }
        }else
        {
            if(empty($fulldescription))
            {
                if(isset($this->category->category_name))
                {
                    $fulldescription = $this->category->category_name;
                }
                if(isset($this->btproduct->name))
                {
                    $fulldescription .= " " .$this->btproduct->name;
                }
                if(isset($this->suffix))
                {
                    $fulldescription .= " " .$this->suffix;
                }
            }

            $this->name = $fulldescription;
        }
    }
    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
        $fulldescription = null;


        if(isset($this->original['name']))
        {

            if(empty($fulldescription))
            {
                if(isset($this->category->category_name))
                {
                    $fulldescription = $this->category->category_name;
                }
                if(isset($this->btproduct->name))
                {
                    $fulldescription .= " " .$this->btproduct->name;
                }
                if(isset($this->suffix))
                {
                    $fulldescription .= " " .$this->suffix;
                }
            }
            if(isset($this->category->category_name))
            {
                if($fulldescription == $this->category->category_name)
                {
                    $this->name = $this->original['name'];
                }
                else
                {
                    $this->name = $fulldescription;
                }
            }else
            {
                $this->name = $this->original['name'];
            }

            if($this->original['name'] !=  $fulldescription)
            {
                $this->name = $fulldescription;
            }

        }else
        {

            if(empty($fulldescription))
            {
                if(isset($this->category->category_name))
                {
                    $fulldescription = $this->category->category_name;
                }
                if(isset($this->btproduct->name))
                {
                    $fulldescription .= " " .$this->btproduct->name;
                }
                if(isset($this->suffix))
                {
                    $fulldescription .= " " .$this->suffix;
                }
            }

            $this->name = $fulldescription;
        }
    }
    public function getGpOptions()
    {
        $obj = [];
        for ($i=0; $i <= 100 ; $i++) {
             $obj[$i] = "$i%";
        }
        return $obj;
    }

    public function formBeforeSave($model)
    {
        $model->validate();
    }

    public function beforeValidate()
    {
        if ($this->production_required == 1) {
             if (empty($this->btproduct))
                throw new \ValidationException(['btproduct' => 'BT pipe required']);

        }
    }

    public function getNameAttribute()
    {
        $fulldescription = null;
        if(isset($this->original['name']))
        {
            if(empty($fulldescription))
            {
                if(isset($this->category->category_name))
                {
                    $fulldescription = $this->category->category_name;
                }
                if(isset($this->btproduct->name))
                {
                    $fulldescription .= " " .$this->btproduct->name;
                }
                if(isset($this->suffix))
                {
                    $fulldescription .= " " .$this->suffix;
                }
            }
            if(isset($this->category->category_name))
            {
                if($fulldescription == $this->category->category_name)
                {
                    return $this->original['name'];
                }
                else
                {
                    return $fulldescription;
                }
            }else
            {
                return $this->original['name'];
            }
        }else
        {
            if(empty($fulldescription))
            {
                if(isset($this->category->category_name))
                {
                    $fulldescription = $this->category->category_name;
                }
                if(isset($this->btproduct->name))
                {
                    $fulldescription .= " " .$this->btproduct->name;
                }
                if(isset($this->suffix))
                {
                    $fulldescription .= " " .$this->suffix;
                }
            }

            return $fulldescription;
        }

    }


}
