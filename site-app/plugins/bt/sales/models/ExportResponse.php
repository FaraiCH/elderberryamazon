<?php


namespace Bt\Sales\Models;


use Backend\Models\ExportModel;
use Carbon\Carbon;

class ExportResponse extends ExportModel
{
    public $table = 'bt_sales_quote_reponses';
    public $belongsTo = [
        'quote' => ['Bt\Sales\Models\Newquote','key'=>'quote_id','order'=>'id desc'],
        'status' => ['Bt\Sales\Models\QuoteStatus','key'=>'quote_status_id'],
        'user' => 'RainLab\User\Models\User'
    ];
    public $attachOne = ['file' => 'System\Models\File'];
    protected $appends = [
        'client_name',
        'po_number',
        'sales_rep',
        'invoice_quote',
        'amount_po',
        'difference',
        'invoiced',
        'status_name'
    ];
    public function exportData($columns, $sessionKey = null)
    {
        $query = self::make();
        $query = $query->where('quote_status_id',10)->whereHas('quote', function ($query) {

                          $query->whereNotNUll('ponumber');
                          $query->where('ponumber','<>','');
                    });

        if(!empty($_SESSION['startresp'])){
            return $query->whereBetween('created_at', [$_SESSION['startresp'], $_SESSION['endresp']])->orderBy('id','desc')->get()->toArray();
        }else{
            $starter = Carbon::now()->subDays(30);
            $ender = Carbon::now();
            return $query->whereBetween('created_at',[$starter, $ender])->orderBy('id','desc')->get()->toArray();
        }

    }

    public function getClientNameAttribute(){
        return $this->quote->company_name;
    }

    public function getPoNumberAttribute(){
        return $this->quote->ponumber;
    }

    public function getSalesRepAttribute(){
        return $this->quote->user->name . " " . $this->quote->user->surname;
    }

    public function getInvoiceQuoteAttribute(){
        return number_format($this->quote->totalincvat,2, ',', ' ');
    }

    public function getAmountPoAttribute(){
        return number_format($this->poamount,2, ',', ' ');
    }

    public function getDifferenceAttribute(){
        if($this->poamount == 99){
            return 'Invalid PO';
        }else if($this->poamount == 0){
            return  '-';

        }else if(($this->poamount == $this->quote->totalincvat) || ( abs($this->poamount - $this->quote->totalincvat) < 100)){
            return 'Match';
        }else  {

            if($this->quote->totalincvat == 0){
                return 'Please check Quote';
            }else{
                $per = intval((abs($this->poamount - $this->quote->totalincvat)/$this->quote->totalincvat) * 100);
                if($per == 0){
                    return 'Match';
                }else{
                    $perc = number_format(abs($this->poamount - $this->quote->totalincvat),2, ',', ' ');
                    return $perc . " (" . $per . "%)";
                }
            }
        }
    }

    public function getStatusNameAttribute(){
        if(isset($this->status->name))
            return $this->status->name;
        else
            return '-';
    }
    public function getInvoicedAttribute(){
        if(isset($this->quote->invoice) && $this->quote->invoice){
            return number_format($this->quote->invoice->sum('amount'),2, '.', ',');
        }else{
            return '-';
        }
    }
    // public function getAltfilesAttribute(){
    //     $myresponse = \Cache::remember('quote_response_' . $this->id, 3600, function () {
    //         return QuoteReponse::with('file')->find($this->id);
        });

    //     if ($myresponse && $myresponse->file) {

    //         return $myresponse->file->file_name;
    //     } else {
    //         return '-';
    //     }
    // }
}
