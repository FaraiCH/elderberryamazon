<?php namespace Bt\Sales\Models;
use BackendAuth;
use Backend\Models\ExportModel;
use Bt\Sales\Models\Invoice as InvoiceModel;
use Bt\Sales\Models\Srn as SrnModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use RainLab\User\Models\User as UserModel;

class DeliveryExport implements FromArray, ShouldAutoSize, WithEvents
{

    public function array(): array{
        if(isset($_SESSION['ender'])){
            $enddate = $_SESSION['ender'];
        }else{
            $enddate = Carbon::now()->setTime(00, 00, 00);;
        }

        if(isset($_SESSION['starter'])){
            $startdate = $_SESSION['starter'];
        }else{
            $current = Carbon::now();
            $startdate = $current->addDays(-30)->setTime(00, 00, 00);;
        }

        $im_id = 9999;

        if(isset($_SESSION['user_sales'])){
            $im_id = $_SESSION['user_sales'] ;
        }
        $invoiceObj = array();
        $invoices  = SrnModel::whereBetween('schedule_date', array($startdate, $enddate))
            ->whereHas('quote', function ($query) use ($im_id)  {
                if($im_id != 9999){
                    $query->where('user_id', $im_id);
                }
            })->orderby("schedule_date","desc")->get();

        $amnt = 0;
        $ac_weight = 0;
        $t_amount = 0;
        $invoiceObj[] = array("SRN Date","SRN REF","Qoute","PO Number","Client","Sales Person", "Weight (Pipe)","Accumlative Weight", "Value (Pipe)","Catalogue Weight","Value(CAT)","Value To Invoice");
        $weekObj = array();
        foreach($invoices as $invoice){

             if(isset($invoice->client->company_name))
                $client =  $invoice->client->company_name;

            if(isset($invoice->quote->user->name)){
                $sales =  $invoice->quote->user->name . " " . $invoice->quote->user->surname;
            }
            if(isset($invoice->quote->ponumber)){
                $po = $invoice->quote->ponumber;
            }
             $price = $invoice->items()->sum("stockvalue");
             $weight = $invoice->items()->sum("stockweight");
             $ac_weight += $invoice->items()->sum("stockweight");
             $catweight = $invoice->itemscat()->sum("stockweight");
             $catstockvalue = $invoice->itemscat()->sum("stockvalue");
             $quote = $invoice->quote->id;

             $vatamount = number_format(($price  +$catstockvalue)+( ($price + $catstockvalue ) * 0.15),2, '.', ',');

            $invoiceObj[] = array( date_format($invoice->created_at,'Y-M-d'),$invoice->id,$quote,$po,$client,$sales,$weight,$ac_weight,$price,$catweight,$catstockvalue,$vatamount);
        }
        return [$invoiceObj];
    }
    public function registerEvents(): array{
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'FFFF0000'],
                ],
            ],
        ];

        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14)->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKBLUE));
            },
        ];
    }
}
