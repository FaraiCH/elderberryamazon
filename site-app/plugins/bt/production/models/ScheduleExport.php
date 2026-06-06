<?php

namespace  Bt\Production\Models;

use Backend\Models\ExportModel;
use Carbon\Carbon;
use Session;

class ScheduleExport extends ExportModel
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_schedules';


    public $hasOne = [
        'btaccount' => ['Bt\Production\Models\BtAccount','key'=>'fromschedule_id'],
    ];
    public $hasMany = [
        'usedmaterials' => ['Bt\Production\Models\MaterialUsed','key'=>'schedule_id'],
    ];
    public $belongsTo = [
        'assignedto' => ['Bt\Maintenance\Models\Staff','key'=>'assignedto_id'],
        'controlsheet' => ['Bt\Production\Models\ControlSheet','key'=>'controlsheet_id'],
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];

    protected $appends = [
        'client_name',
        'quote_name',
        'product',
        'projectname',
        'costproduced',
        'materialused',
    ];

    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        if (Session::has('schstart') && Session::get('schstart') > 0) {
            return $query->whereBetween('production_date', [Session::get('schstart'), Session::get('schend')])->orderBy('id', 'desc')->get()->toArray();
        } else {
            $starter = Carbon::now()->subDays(30);
            $ender = Carbon::now();
            return $query->whereBetween('production_date', [$starter, $ender])->orderBy('id', 'desc')->get()->toArray();
        }
    }

    public function getQuoteNameAttribute()
    {
        if (isset($this->pipe->quoteitems->quote_id)) {
            return $this->pipe->quoteitems->quote_id;
        }
        return null;
    }
    public function getClientNameAttribute()
    {
        if (isset($this->pipe->quoteitems->quote->company_name)) {
            return $this->pipe->quoteitems->quote->company_name;
        }
        return null;
    }
    public function getProductAttribute()
    {
        if (isset($this->pipe->quoteitems->description)) {
            $str =  str_replace("HDPE PE 100", "", $this->pipe->quoteitems->description);
            return str_replace("length", "", $str);
        }
        return null;
    }

    public function getProjectnameAttribute()
    {
        if (isset($this->pipe->quoteitems->productname->name)) {
            return $this->pipe->quoteitems->productname->name;
        }
        return null;
    }

    public function getCostproducedAttribute()
    {
        if (isset($this->priceperpipe)) {
            return "R " . number_format($this->priceperpipe, 2, '.', ',');
        }
    }

    public function getMaterialusedAttribute()
    {
        if (!empty($this->usedmaterials)) {
            return $this->usedmaterials->sum('kg');
        }
    }
}
