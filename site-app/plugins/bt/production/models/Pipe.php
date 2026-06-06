<?php namespace Bt\Production\Models;

use Bt\Sales\Models\Srn;
use Model;

/**
 * Pipe Model
 */
class Pipe extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_pipes';

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
        'quoteitems' => ['Bt\Sales\Models\Quoteitems','key'=>'id','otherKey'=>'quoteitem_id'],

    ];
    public $hasMany = [
        'materials' => ['Bt\Production\Models\Materials','key'=>'pipe_id'],
        'schedules' => ['Bt\Production\Models\Schedule','key'=>'pipe_id', 'order'=>'production_date'],
        'delivered' => ['Bt\Sales\Models\SrnItem','key'=>'pipe_id'],
        'fabrication' => ['Bt\Sales\Models\FabricationItem','key'=>'pipe_id'],
        'jobcard' => ['Bt\Production\Models\Jobcard','key'=>'pipe_id'],
    ];
    public $belongsTo = [
        'btline' => ['Bt\Production\Models\Line','key'=>'line_id'],
        'qpush' => ['Bt\Production\Models\Push','key'=>'push_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public $morphedByMany = [
        'quotes'  => ['Bt\Sales\Models\Newquote',
                'table'=>'tbl_association',
                'name' => 'tbl_association',
                'key'=>'association__id',
                'otherKey'=>'tbl_association__id'
        ],

    ];

    public $appends = ['produced', 'batch'];
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getProducedAttribute()
    {
        $total = 0;

            return $total;
    }

    public function getTotalProduced()
    {

        $total = 0;
        foreach ($this->schedules as $s => $schedules) {
            $total += $schedules->total_units_passed_qc;
        }
        return $total;
    }

    public function getTotalExtras()
    {
        $total = 0;
        foreach ($this->schedules as $s => $schedules) {
            $total += $schedules->btaccount->where('unitlength', $this->quoteitems->unitlength)->sum('units');
        }
        return $total;
    }

    public function getTotalDelivered()
    {
        $total = 0;
        foreach ($this->delivered as $s => $delivered) {
            $total += $delivered->units;
        }

        //Get the fabrication pipes delievered
        foreach ($this->fabrication as $f => $fabricated) {
            $total += $fabricated->units;
        }
        return $total;
    }

    public function getDeliveredByQuote($quote)
    {
        $total = 0;
        foreach ($this->delivered as $s => $delivered) {
            if ($delivered->srn->quote_id == $quote) {
                $total += $delivered->units;
            }
        }
        return $total;
    }

    public function getDeliveredByDescription($item, $btitem)
    {
        $total = 0;
        foreach ($this->delivered as $s => $delivered) {
            if ($delivered->srn->quote_id == $item) {
                $total += $delivered->units;
            }
        }
        return $total;
    }

    public function getBatchAttribute()
    {
        $jobcard = Jobcard::where('pipe_id', $this->id)->first();
        if (isset($jobcard->id)) {
            $control = ControlSheet::where("jobcard_id", $jobcard->id)->first();
            if (isset($control->id)) {
                return $control->jobcard_id . " - " . $control->batch_id;
            }
        }

        return [];
    }

    public function getTotalKgProcessedAttribute(): int
    {
        return $this->schedules->sum('total_kg_processed');
    }

    public function getTotalPipeUnitsAttribute(): int
    {
        return $this->schedules->sum('total_units_passed_qc');
    }
}
