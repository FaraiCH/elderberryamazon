<?php

namespace Bt\Production\Models;

use Model;
use BackendAuth;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Sales\Models\QuoteReponse as QuoteReponseModel;
use Carbon\Carbon;


use Auth;
use Flash;
use Input;
use Validator;
use Redirect;
use ValidationException;
use GuzzleHttp\Client;
use Http;
use Mail;
use Config;
use Renatio\DynamicPDF\Classes\PDF;
use DB;
use RainLab\User\Models\UserGroup;

/**
 * Push Model
 */
class Push extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_production_pushes';
    use \October\Rain\Database\Traits\Validation;

    public $rules = [

        'status'                  => 'required'
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
    protected $appends = ['is_cod'];

    public $hasOne = [
        'approved' => ['Bt\Production\Models\Pushapprove', 'key' => 'push_id'],
    ];
    public $hasMany = [
        'pipes' => ['Bt\Production\Models\Pipe', 'key' => 'push_id'],
        'productiondelay' => ['Bt\Production\Models\ProductionDelay', 'key' => 'push_id'],
    ];
    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote', 'key' => 'quote_id'],
        'status' => ['Bt\Production\Models\Status', 'key' => 'status_id'],
        'createdby' => ['Backend\Models\User', 'key' => 'created_by', 'other' => 'id'],
        'updatedby' => ['Backend\Models\User', 'key' => 'updated_by', 'other' => 'id'],
        'blendedprice' => ['Bt\Inventory\Models\BlendedPurchase', 'key' => 'blendedprice_id']
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

    public function afterUpdate()
    {

        if ($this->status_id == 2) {
            $foundpipes = 0;
            if (count($this->pipes) == 0) {
                $foundpipes = 1;
            }
            $count = 0;

            foreach ($this->quote->items as $value) {
                $check = PipeModel::where('quoteitem_id', $value->id)->first();
                if (empty($check)) {
                    $pipe = new PipeModel();
                    $pipe->quoteitem_id = $value->id;
                    $pipe->push_id = $this->id;
                    $pipe->line_id = 1;
                    $pipe->pipe_target_weight = $value->weight;
                    $pipe->production_rate =  700;
                    $pipe->target_scrap_rate = 3;
                    $pipe->target_availability = 98;
                    $pipe->changeover_days = 0;
                    $pipe->original_items_count = $value->units;
                    $pipe->save();
                    if ($pipe->id) {
                        $count++;
                    }
                }
            }
            if ($foundpipes == 0 && $count  > 0) {
                $this->qresponse($this->quote_id, 16, 'Date accepted (' . Carbon::now() . ") with $count pipes");
                Flash::success("Production accepted...");
            }
            // }else{

            //     Flash::error("Pipes already linked...");
            // }
        }

        if ($this->status_id == 3) {
            $this->qresponse($this->quote_id, 17, 'Date completed  (' . Carbon::now() . ")");
            Flash::success("Production completed...");

            ##Send email
            $obj = $this;
            $user = BackendAuth::getUser();
        if (!$user) return;
            $name = $user->first_name;
            $name .= ' ' . $user->last_name;

            $x = 0;

            $groupusers = UserGroup::where('id', 18)->first();

            foreach ($groupusers->users as $key => $value) {
                $x++;
                $data = [];
                $data['name'] = $value->name;
                $data['to_email'] = $value->email;
                $data['username'] = $name;
                $data['report'] = $obj;
                $data['ref'] = $obj->quote_id;
                // $data['response_details'] =  $link;
                Mail::send('BT.production.completed', $data, function ($message) use ($data) {
                    $message->subject("BT Production Completed: Quote BT-QT-" . $data['ref']);
                    $message->to($data['to_email'], $data['name']);
                });
            }
        }

        if ($this->status_id == 4) {
            Flash::success("Production put on hold...");
            $this->qresponse($this->quote_id, 18);
        }
    }

    private function qresponse($quote_id, $status, $note = null)
    {
        #$user = Auth::getUser();
        $qr = new QuoteReponseModel();
        $data['user_id'] = 1;
        $data['quote_id'] = $quote_id;
        $data['quote_status_id'] =  $status;
        $data['notes'] = $note;
        $q = $qr->subQuoteReponse($data);
    }

    public function getIsCodAttribute()
    {

        $balance = 0;
        if (isset($this->quote->client->limit)) {
            $balance = $this->quote->client->limit - $this->quote->client->utilization;

            if ($this->quote->client->is_cod > 0) {
                return 'COD';
            } else {
                return 'Account' . ' (Credit Balance: R' . number_format($balance, 2, '.', ',') . ')';
            }
        } else {
            return 'Account (Limit Not Set)';
        }
    }

    public function scopeFilterByUser($query, $filter)
    {
        return $query->whereHas('quote', function ($group) use ($filter) {
            $group->whereIn('user_id', $filter);
        });
    }

    public function filterFields($fields, $context = null)
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        if ($user->hasAccess('bt.production.analysis')) {
            $fields->blendedprice->hidden = false;
        } else {
            $fields->blendedprice->hidden = true;
        }
    }

    public function getTotalKgProcessedAttribute(): int
    {
        $pipes = optional($this)->pipes;

        if(count($pipes) > 0 && $pipes != null) {
            return $pipes->sum('totalKgProcessed');
        }

        return 0;
    }
    public function getTotalPipeUnitsAttribute(): int
    {
        $pipes = optional($this)->pipes;

        if(count($pipes) > 0 && $pipes != null) {
            return $pipes->sum('totalPipeUnits');
        }

        return 0;
    }
}
