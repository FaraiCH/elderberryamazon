<?php namespace Bt\Production\Models;

use Bt\Sales\Models\QuoteItemCatalogue;
use Model;
use BackendAuth;
use Bt\Sales\Models\Product as ProductModel;
use Bt\Production\Models\Push as PushModel;
use Bt\Sales\Models\Quoteitems;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Production\Models\Schedule as ScheduleModel;
use Bt\Production\Models\Jobcard as JobcardModel;
use Bt\Production\Models\Jobcardapprove as JobcardapproveModel;
use Bt\Production\Models\JobCardBatch as JobCardBatchModel;
use Bt\Production\Models\ControlSheet as ControlSheetModel;
use Carbon\Carbon;

/**
 * BtAccount Model
 */
class BtAccount extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_bt_accounts';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [

        'schedule_date' => 'required',
        'push_id' => 'required',
        'priceperkg' => 'required',
        'product_id' => 'required',
        'units' => 'required',
        'unitlength' => 'required',
        'notes' => 'required',
        'fromschedule' => 'required',
        'quote' => 'required',
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

    public $hasMany = [];
    public $belongsTo = [
        'pipe' => ['Bt\Production\Models\Pipe','key'=>'pipe_id'],
        'fromschedule' => ['Bt\Production\Models\Schedule','key'=>'fromschedule_id'],
        'schedule' => ['Bt\Production\Models\Schedule','key'=>'schedule_id'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','orderBy'=>('id') ],
        'push' => ['Bt\Product\Models\Push','key'=>'push_id'],
        'product' => ['Bt\Sales\Models\Product','key'=>'product_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id'],
        'catalogueitem' =>['Bt\Sales\Models\QuoteItemCatalogue']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {

        ##Write this to qoute
        ##Get quotenumper from push
        $p =  PushModel::find($this->push_id);
       // dd($this->createjb);
        if (!empty($p)) {
            $qid = $p->quote->id;

            ###Add Item to qoute
            $i = new Quoteitems;
            $i->product_id = $this->product_id;
            $i->quote_id = $qid;

            $product = ProductModel::find($this->product_id);

            $unitlength = $this->unitlength;
            $units = $this->units;
            $weight = $product->value*$unitlength;
            $totalweight = $product->value*$unitlength*$units;

            $unitprice = $product->value*$this->priceperkg*$unitlength;
            $price = $unitprice * $units;
            $desc = "HDPE PE 100 ".$product->PNRating->name." ".$product->Diameter->name."mm ".$unitlength."m length ";
            $this->description = $desc;
            $i->description = $desc;
            $i->price = $price;
            $i->unitprice = $unitprice;
            $i->units = $units;
            $i->unitlength = $unitlength;
            $i->weight = $weight;
            $i->totalweight = $totalweight;
            $i->save();

            ##push as pipe
            $pipe = new PipeModel();
            $pipe->start_date = $this->schedule_date;
            $pipe->due_date = $this->schedule_date;
            $pipe->quoteitem_id = $i->id;
            $pipe->push_id = $p->id;
            $pipe->line_id = 1;
            $pipe->pipe_target_weight = $weight;
            $pipe->production_rate =  700;
            $pipe->target_scrap_rate = 3;
            $pipe->target_availability = 98;
            $pipe->changeover_days = 0;
            $pipe->save();
            $this->pipe_id = $pipe->id;
            ##create pipechedule

                $sc = new ScheduleModel();
                $sc->user_id = 1;
                $sc->pipe_id = $pipe->id;
                $sc->production_days = 1;
                $sc->production_date = $this->schedule_date;
                $sc->target_kg_processed = $totalweight;
                $sc->target_units_produced = $units;

                $sc->total_units_passed_qc = $units;
                $sc->total_units_produced = $units;
                $sc->total_kg_processed = $totalweight;
                $sc->save();

                $this->schedule_id = $sc->id;

                ##Create Jobcard
            if ($this->createjb) {
                $jbcard = new JobcardModel();
                $jbcard->pipe_id = $pipe->id;
                $jbcard->opendate =  $this->schedule_date;
                $jbcard->product_description =  $desc;
                $jbcard->save();

                 ##Approve Job
                $jbapp = new JobcardapproveModel();
                $jbapp->status_id = 1;
                $jbapp->jobcard_id = $jbcard->id;
                $jbapp->save();


                #create batch
                $jbbatch = new JobCardBatch();
                $jbbatch->jobcard_id = $jbcard->id;
                $jbbatch->save();

                #createcontrsleet

                $cs = new ControlSheetModel();
                $cs->batch_id =  $jbbatch->id;
                $cs->jobcard_id =  $jbcard->id;
                $cs->plan_id =  1;
                $cs->planitem =  1;
                $cs->btline =  1;
                $cs->opendate =   $this->schedule_date;
                $cs->shift =  "DAY";
                $cs->save();

                #link controlsheet to scheles
                $sc->controlsheet_id = $cs->id;
                $sc->save();
            }


                unset($this->createjb);
        }



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

    public function listProductitems($fieldName, $value, $formData)
    {

        $i =  ProductModel::all();
        $arrayName = array();

        foreach ($i as $key_ => $value_) {
            $arrayName[$value_->id] = $value_->PNRating->name." X ".$value_->Diameter->name." mm Dia";
        }

        return $arrayName;
    }

    public function listAccountitems($fieldName, $value, $formData)
    {
        $i =  PushModel::find(41);

        $arrayName = array();
        if (!empty($i)) {
            $arrayName[$i->id] = $i->quote->company_name;
        }

        return $arrayName;
    }

    public function getFromscheduleOptions()
    {
        $obj = array();
        if (isset($this->quote->id)) {
            $p = PushModel::where("quote_id", $this->quote->id)->whereHas('pipes', function ($query) {
                $query->where('active', 1)->where('created_at', '>', '2023-10-01');
            })->get();
            foreach ($p as $key => $pv) {
                foreach ($pv->pipes as $pk => $pipes) {
                    foreach ($pipes->schedules as $sk => $schedules) {
                        $desc = "";
                        if (isset($pipes->quoteitems->description)) {
                                #$str  =  str_replace("HDPE PE 100","",$pipes->quoteitems->description);
                                #$desc = str_replace("length","",$str);
                            $desc = $pipes->quoteitems->description;
                        }

                        $obj[$schedules->id] = $desc." / Day  ".$schedules->production_days." / Date ".$schedules->production_date." / QC Passed  ".$schedules->total_units_passed_qc." / Extr Pipes ".$schedules->extra;
                    }
                }
            }
        }
        return $obj;
    }

    public function getQuoteOptions()
    {
        $obj = array();
        $enddate = Carbon::now();
        $current = Carbon::now();
        $startdate = "2023/08/01";

        $p = PushModel::whereBetween('date_of_accepted', array($startdate, $enddate." 23:59:00"))->where("status_id", '>', 0)->orderby("quote_id", 'desc')->get();
        $p2 =  PushModel::find(41);
        foreach ($p as $key => $pv) {
            $count = 0;
            foreach ($pv->pipes as $pk => $pipes) {
                foreach ($pipes->schedules as $sk => $schedules) {
                    $count = 1;
                }
            }
            if ($count > 0) {
                $obj[$pv->quote_id] = $pv->quote_id." / ".$pv->quote->company_name." / Production #".$pv->id;
            }
        }
        $obj[$p2->quote_id] = $p2->quote_id." / ".$p2->quote->company_name." / Production #".$p2->id;

        return $obj;
    }

    public function getCatalogueitemOptions()
    {
        $catalogues = array();
        if (isset($this->quote->id)) {
            $catalogueOBj = QuoteItemCatalogue::where('btproduct_id', '<>', null)->where('quote_id', $this->quote->id)->get();
            foreach ($catalogueOBj as $catalogueitems) {
                $catalogues[$catalogueitems->id] = $catalogueitems->description;
            }
        }
        return $catalogues;
    }
}
