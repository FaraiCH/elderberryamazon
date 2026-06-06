<?php namespace Bt\Sales\Models;
use BackendAuth;
use Backend\Models\ExportModel;
use Bt\Sales\Models\Invoice as InvoiceModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use RainLab\User\Models\User as UserModel;

class InvoiceExport implements FromArray, ShouldAutoSize, WithEvents
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
        $invoices  = InvoiceModel::
        whereHas('srn', function ($query) use ($startdate, $enddate)  {
            $query->whereBetween('schedule_date', array($startdate, $enddate));
        })->whereHas('quote', function ($query) use ($im_id)  {
                if($im_id != 9999){
                    $query->where('user_id', $im_id);
                }
        })->orderby("created_at","desc")->get();

        $amount = 0;
        $invoiceObj[] = array("SRN Date", "SRN REF","Quote No", "PO No", "Invoice No", "Invoice Date", "Client", "Sales Person", "Amount", "Total Amount");
        foreach($invoices as $key => $item){
            if(isset($item->quote->client->company_name))
                $client =  $item->quote->client->company_name;

            if(isset($item->quote->user)){
                $sales =  $item->quote->user->name . " " . $item->quote->user->surname;
                $amountMade =  number_format( $item->amount,2, '.', ',');
                $total = $amount += $item->amount;
            }
             $invoiceObj[] = array($item->srn->schedule_date, $item->srn_id, $item->quote->id, $item->quote->ponumber, $item->id, $item->invoice_date, $client, $sales, $amountMade, $total);
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
