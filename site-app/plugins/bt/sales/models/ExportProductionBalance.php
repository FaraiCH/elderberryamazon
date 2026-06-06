<?php

namespace Bt\Sales\Models;

use BackendAuth;
use Backend\Models\ExportModel;
use Bt\Sales\Controllers\Mydashboard;
use Bt\Sales\Models\Invoice as InvoiceModel;
use Bt\Sales\Models\Newquote as QuoteModel;
use Bt\Sales\Models\Quoteitems;
use Bt\Sales\Models\PricePerKg;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use RainLab\User\Models\User as UserModel;

class ExportProductionBalance implements FromArray, ShouldAutoSize, WithEvents
{

    public function array(): array
    {
        $otherdate = Carbon::now();
        $current = Carbon::now();
        $startdate =($otherdate->year - 1) .'-03-01'  . ' 00:00:00';

        $im_id = 0;

        if (isset($_SESSION['user_sales'])) {
            $im_id = $_SESSION['user_sales'];
        }
        $poqouteObj = array();

        $poqoutes = QuoteModel::where('ponumber', "<>", "")->whereNotnull('ponumber')
            ->where('created_at','>', $startdate)->orderby("user_id", "asc")->orderby("created_at", "desc")->get();
        $production_blend = new Mydashboard();
        $blend = $production_blend->getProductionBalance('', '', $im_id, $startdate);
        $amount = 0;
        $poqouteObj[] = array("Quote Date", "Status", "Approved by production", "Quote", "PO Number", "PO Date", "Client Name", "Sales Agent", "KG Ordered", "KG Processed", "Total Ordered Pipes", "Total Produced Pipes", "Total Price", "Buy Outs", "Total Inc Vat",  "R/Kg", "Invoice Percentage", "Invoice Amount");
        foreach ($poqoutes as $key => $quote) {
            $total = $quote->totalincvat;
            $amount = $quote->invoice()->sum('amount');
            $per = 0;
            if($total > 0){
                $per = ($amount/$total) * 100;
                $per = number_format($per, 2);
            }
            if($per > 100)
            {
                $per = 100;
                $per = number_format($per, 2);
            }
            $no_pipes_orderd = $quote->items()->sum("units") + $quote->itemscat()->sum("units");
            $invoiceamount = $quote->invoice()->sum("amount");
            $difference = $no_pipes_orderd - $quote->totalPipeUnits;
            if ($quote->productionStatus == 'In Production' && $quote->productionAproval == 'Approved' && $difference >= 0  && $quote->created_at > $startdate && $per != 100){
                if (isset($quote->client->company_name))
                    $client = $quote->client->company_name;

                if (isset($quote->user)) {
                    $sales = $quote->user->name . " " . $quote->user->surname;
                }
                $kg_processed = 0;
                $status = "";
                $production_approved = "";
                $kg_delievered = 0;
                $units_delievered = 0;
                $pkg = 0;
                $datemade = null;
                // if (isset($blend[$quote->id]["total_kg_processed"]))
                //     $kg_processed =  $blend[$quote->id]["total_kg_processed"];

                if (isset($blend[$quote->id]["deliveyweight"]))
                    $kg_delievered = $blend[$quote->id]["deliveyweight"];
                if (isset($blend[$quote->id]["total_units_unit_in_date"]))
                    $units_delievered = $blend[$quote->id]["total_units_unit_in_date"];
                $price = $quote->items()->sum("price");
                $weight = $quote->items()->sum("totalweight");
                if ($quote->responses) {
                    foreach ($quote->responses as $r => $rdata) {
                        if ($rdata->quote_status_id == 10) {
                            $date_r = new \DateTime($rdata->created_at);
                            $datemade = $date_r->format('M Y');
                        }
                    }
                }


                $status = $quote->productionStatus;
                $production_approved = $quote->productionAproval;
                $kg_processed = $quote->totalKgProcessed ?: '0';
                $pipe_produced = $quote->totalPipeUnits ?: '0';
                if (!empty($price) && $weight > 0) {
                    $pkg = number_format($price / $weight, 2, '.', ',');
                }
                $poqouteObj[] = array(date_format($quote->created_at, 'M Y'), $status, $production_approved, $quote->id, $quote->ponumber, $datemade, $client, $sales, $weight, $kg_processed, $no_pipes_orderd, $pipe_produced, $price, $quote->itemscat()->sum("price"), $quote->totalincvat, $pkg, $per, $invoiceamount);
            }
        }
        return [$poqouteObj];
    }


    public function registerEvents(): array
    {
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'FFFF0000'],
                ],
            ],
        ];

        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14)->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKBLUE));
            },
        ];
    }
}
