<?php


namespace Bt\Production\Models;

use Backend\Models\ExportModel;
use Carbon\Carbon;

class ProductionPlanExport extends ExportModel
{

    public $table = 'bt_production_production_plans';
    public $hasOne = [];
    public $hasMany = [
        'planitems' => ['Bt\Production\Models\ProductionPlanItem','key'=>'plan_id'],

    ];
    public $belongsTo = [
        'status' => ['Bt\Maintenance\Models\Status','key'=>'status_id'],
        'btline' => ['Bt\Production\Models\Line','key'=>'line_id'],
        'delivered' => ['Bt\Sales\Models\SrnItem','key'=>'pipe_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    protected $appends = [

        'total_weight',
        'items',
        'btline_no',
    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make()->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        return $query->get()->toArray();
    }
    public function getTotalWeightAttribute()
    {
        $count = 0;
        if (!empty($this->planitems)) {
            foreach ($this->planitems as $key => $value) {
                $count = $count + ($value->item->weight  * $value->qty);
            }
        }
        return $count." kg";
    }

    public function getBtlineNoAttribute()
    {
        if (!empty($this->btline->name)) {
            return $this->btline->name;
        }
    }

    public function getItemsAttribute()
    {
        $name =  array();
        if (isset($this->planitems)) {
            foreach ($this->planitems as $key => $value) {
                $name[$value->id] = $value->item->description . " Qty : (" . $value->qty . ")";
            }
        }

        return implode(", ", $name);
    }
}
