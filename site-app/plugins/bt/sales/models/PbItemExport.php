<?php namespace Bt\Sales\Models;

use Bt\Sales\Controllers\Mydashboard;
use Bt\Sales\Models\Newquote as QuoteModel;
use Carbon\Carbon;
use Session;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PbItemExport  implements FromArray, ShouldAutoSize, WithEvents
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
            $startdate = $current->addDays(-30)->setTime(00, 00, 00);
        }

        $im_id = 9999;

        if(isset($_SESSION['user_sales'])){
            $im_id = $_SESSION['user_sales'] ;
        }
        $poqouteObj = array();

        $poqoutes = QuoteModel::where('ponumber',"<>","")->whereNotnull('ponumber')->whereBetween('created_at', array($startdate, $enddate))
            ->whereHas('user', function ($query) use ($im_id)  {
                if($im_id != 9999){
                    $query->where('id', $im_id);
                }
                $query->orderby("name","asc");
            })->orderby("user_id","asc")->orderby("created_at","desc")->get();
        $poqouteObj[] = array("Quote Date","Quote Overview","PO Number", "Quote item","Product Name","Diameter","Unit Length", "PO Date", "Client","Sales Rep", "Total Weight Ordered", " Total KG Processed",  "Total KG Delivered in Date", "Total Ordered Pipes", "Units Produced", "Total Units Delivered In Date", "Total Units Delivered", "Outstanding Units To Deliver", "Quote Price","Unit Price","Amount Invoiced", "Total Inc Vat",  "R/Kg", "");
        foreach($poqoutes as $key => $quote){
            if(isset($quote->client->company_name))
                $client =  $quote->client->company_name;

            if(isset($quote->user)){
                $sales =  $quote->user->name . " " . $quote->user->surname;
            }

            $datemade = null;
            $description = "";
            $unitlength = "";
            $pn = "";
            $Diameter = "";
            $priceitem = 0;

            foreach ($quote->items as $item){
                if(!empty($item->pipe->schedules)){
                    $kg_processed =  $item->pipe->schedules->sum('total_kg_processed');
                    $kg_units = $item->pipe->schedules->sum('total_units_passed_qc');
                }
                else{
                    $kg_processed = 0;
                    $kg_units = 0;
                }

                $no_pipes_orderd = $item->units;

                if (!empty($item->delivered)){
                    $units_delievered = $item->getSameItemDelivered($item->quote_id, $item->product_id, $item->unitlength, '', '')->sum('units');
                    $units_delievered_in_date = $item->getSameItemDelivered($item->quote_id, $item->product_id, $item->unitlength, $startdate, $enddate)->sum('units');
                    $kg_delievered = $item->getSameItemDelivered($item->quote_id, $item->product_id, $item->unitlength, $startdate, $enddate)->sum('stockweight');
                }
                else{
                    $kg_delievered = 0;
                    $units_delievered_in_date = 0;
                    $units_delievered = 0;
                }
                $price = $item->price;
                $weight = $item->totalweight;
                if($weight > 0){
                    $pkg = number_format($price / $weight,2, '.', ',');
                }else{
                    $pkg = 0;
                }
                if(!empty($item->description)){
                   $description =  $item->description;
                }

                if(!empty($item->unitprice)){
                   $priceitem = $item->unitprice;
                }

                if(!empty($item->unitlength)){
                   $unitlength =  $item->unitlength;
                }
                 if(!empty($item->product->PNRating->name)){
                   $pn =  $item->product->PNRating->name;
                }
                if(!empty($item->product->Diameter->name)){
                   $Diameter =  $item->product->Diameter->name;
                }
                $amountinv = $priceitem * $units_delievered;

                $outstandingdeliver = $no_pipes_orderd - $units_delievered;

                $poqouteObj[] = array( date_format($quote->created_at,'M Y'), $quote->id, $quote->ponumber,$description,$pn,$Diameter, $unitlength,$datemade,$client,$sales,$weight,$kg_processed,$kg_delievered,$no_pipes_orderd,$kg_units, $units_delievered_in_date,$units_delievered, $outstandingdeliver,$price,$priceitem,$amountinv, $quote->totalincvat,$pkg,null);
            }

        }
            return [$poqouteObj];
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
