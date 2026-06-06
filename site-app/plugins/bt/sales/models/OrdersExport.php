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

class OrdersExport implements FromArray, ShouldAutoSize, WithEvents
{

    public function array(): array
    {
        if (isset($_SESSION['ender'])) {
            $enddate = $_SESSION['ender'];
        } else {
            $enddate = Carbon::now()->setTime(00, 00, 00);;
        }

        if (isset($_SESSION['starter'])) {
            $startdate = $_SESSION['starter'];
        } else {
            $current = Carbon::now();
            $startdate = $current->addDays(-30)->setTime(00, 00, 00);;
        }

        $im_id = 9999;

        if (isset($_SESSION['user_sales'])) {
            $im_id = $_SESSION['user_sales'];
        }
        $poqouteObj = array();

        $poqoutes = QuoteModel::where('ponumber', "<>", "")->whereNotnull('ponumber')->whereBetween('created_at', array($startdate, $enddate))
            ->whereHas('user', function ($query) use ($im_id) {
                if ($im_id != 9999) {
                    $query->where('id', $im_id);
                }
                $query->orderby("name", "asc");
            })
            ->whereHas("responses", function ($query){
                $query->where('id',"!=", 15);
            })
            ->orderby("user_id", "asc")->orderby("created_at", "desc")->get();
        $production_blend = new Mydashboard();
        $blend = $production_blend->getProductionBalance($startdate, $enddate, $im_id, '');

        $amount = 0;
        $poqouteObj[] = array("Quote Date", "Status", "Approved by production", "Cancelled?","Quote", "PO Number", "PO Date", "Client Name", "Sales Agent", "KG Ordered", "KG Processed",  "KG Delivered in Date", "Total Ordered Pipes", "Units Delivered In Date", "Total Pipe Price To Invoice",  "Buy Outs", "Total Inc Vat",  "R/Kg", "");
        foreach ($poqoutes as $key => $quote) {
            if(!empty($quote->responses->where('quote_status_id', 15)->first()) || !empty($quote->responses->where('quote_status_id', 20)->first()))
            {
                $cancelled = "Yes";
            }else
            {
                $cancelled = "No";
            }
                if (isset($quote->client->company_name))
                    $client =  $quote->client->company_name;

                if (isset($quote->user)) {
                    $sales =  $quote->user->name . " " . $quote->user->surname;
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
                $no_pipes_orderd = $quote->items()->sum("units") + $quote->itemscat()->sum("units");
                if (isset($blend[$quote->id]["deliveyweight"]))
                    $kg_delievered = $blend[$quote->id]["deliveyweight"];
                if (isset($blend[$quote->id]["total_units_unit_in_date"]))
                    $units_delievered = $blend[$quote->id]["total_units_unit_in_date"];
                $price = $quote->items()->sum("price");
                $weight = $quote->items()->sum("totalweight") + $quote->itemscat()->sum("totalweight");
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

                if (!empty($price) &&  $weight > 0) {
                    $pkg = number_format($price / $weight, 2, '.', ',');
                }
                $poqouteObj[] = array(date_format($quote->created_at, 'M Y'), $status, $production_approved, $cancelled, $quote->id, $quote->ponumber, $datemade, $client, $sales, $weight, $kg_processed, $kg_delievered, $no_pipes_orderd, $units_delievered, $price, $quote->itemscat()->sum("price"), $quote->totalincvat, $pkg, null);


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
