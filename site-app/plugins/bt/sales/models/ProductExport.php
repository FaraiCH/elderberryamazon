<?php


namespace Bt\Sales\Models;


use Backend\Models\ExportModel;
use Backend\Models\User;

class ProductExport extends ExportModel
{

    /**
     * @var array Fillable fields
     */
    // protected $fillable = [];
    public $table = 'bt_sales_products';

    public $belongsTo = [
        'pnrating' => ['Bt\Sales\Models\PNRating','key'=>'pn_ratings_id'],
        'diameter'    => ['Bt\Sales\Models\Diameter'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];

    protected $appends = [
        'pnrating_name',
        'diameter_name',
        'created_by_name',
        'updated_by_name',

    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        return $query->get()->toArray();
    }

    public function getPnratingNameAttribute()
    {
        return $this->pnrating->name;
    }
    public function getDiameterNameAttribute()
    {
        return $this->diameter->name;
    }
    public function getCreatedByNameAttribute() {
        $user = User::find($this->created_by);

        if(!empty(isset($user)))
        {
            return $user->first_name . " " . $user->last_name;
        }
    }
    public function getUpdatedByNameAttribute() {
        $user = User::find($this->updated_by);

        if(!empty(isset($user)))
        {
            return $user->first_name . " " . $user->last_name;
        }
    }
}
