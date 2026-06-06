<?php namespace Bt\QC\Models;

use Bt\Sales\Models\Newquote;
use Bt\Sales\Models\Quoteitems;
use Model;
use BackendAuth;
use Input;
use  Bt\Sales\Models\Invoice;
use Bt\Production\Models\Push as PushModel;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\QC\Models\DataPackIndex;
/**
 * Datapack Model
 */
class Datapack extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'bt_qc_datapacks';

    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'name' => 'required',
        'summary' => 'required',
        'quote' => 'required',
        // 'item_id' => 'required'
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
    protected $jsonable = ['dataoptions'];

    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'pipereport' => ['Bt\QC\Models\PipeReport', 'key' => 'pipereport_id'],
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'item' => ['Bt\Sales\Models\Quoteitems','key'=>'item_id'],
        'createdby' =>['Backend\Models\User','key'=>'created_by','other'=>'id'],
        'updatedby' =>['Backend\Models\User','key'=>'updated_by','other'=>'id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'qualityplan' => 'System\Models\File',
        'template' => 'System\Models\File',
        'header' => 'System\Models\File',
        'footer' => 'System\Models\File',
    ];
    public $attachMany = [];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->created_by = $user->id;
        $pipeReport = PipeReport::find(\Request::segment(6));
        if(isset($pipeReport->id)){
            $this->is_pipe = 1;
        }
    }

    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        if (!$user) return;
        $this->updated_by = $user->id;
    }

    public function getItemIdOptions()
    {
        $pipeReport = PipeReport::find(\Request::segment(6));
        $arrayName = array();

        if (!isset($pipeReport->id)) {
            $quote_id = $this->quote_id;
            if ($quote_id > 0) {
                $i = PushModel::where("quote_id", $quote_id)->first();
                if (!empty($i->pipes)) {
                    foreach ($i->pipes as $key => $pipe) {
                        $arrayName[$pipe->quoteitems->id] = " #ITEM " . $pipe->quoteitems->id . " : DESC #" . $pipe->quoteitems->description;
                    }
                }

                $i = PushModel::where("quote_id", $quote_id)->first();
                if (!empty($i->quote->pipesdeliver)) {
                    foreach ($i->quote->pipesdeliver as $key => $pipe) {
                        $arrayName[$pipe->quoteitems->id] = " ASSOCIATED #ITEM " . $pipe->quoteitems->id . " : DESC #" . $pipe->quoteitems->description;
                    }
                }
            }
        } else {
            $item_id = $pipeReport->item_id;
            $quoteItem = Quoteitems::find($item_id);
            $arrayName[$quoteItem->id] = " #ITEM " . $quoteItem->id . " : DESC #" . $quoteItem->description;
        }
        return $arrayName;
    }

    public function getQuoteIdOptions(){
        $pipeReport = PipeReport::find(\Request::segment(6));
        $arrayName = array();
        if(!isset($pipeReport->id) && ($this->is_pipe == 0)){
            $newquote = Newquote::all();
            foreach ($newquote as $quote){
                $arrayName[$quote->id] = $quote->id . ' ' . $quote->company_name;
            }
        }else
        {
            $url_name = \Request::segment(4);

            if($url_name !== 'datapack'){
                $newquote = Newquote::find($pipeReport->quote_id);
                $arrayName[$newquote->id] = $newquote->id . ' ' . $newquote->company_name;
            }else{
                $newquote = Newquote::all();
                foreach ($newquote as $quote){
                    $arrayName[$quote->id] = $quote->id . ' ' . $quote->company_name;
                }
            }

        }

        return $arrayName;
    }

    public function getIndexOptions(){
        $arrayName = array();
        $variable = DataPackIndex::orderby("orderno")->get();
        foreach ($variable as $key => $value) {
            $arrayName[$value->id] = $value->id." - ".$value->name;
        }
        #return DataPackIndex::where("id",'>',0)->orderby("orderno")->lists('name', 'id');
        return $arrayName;
    }

}
