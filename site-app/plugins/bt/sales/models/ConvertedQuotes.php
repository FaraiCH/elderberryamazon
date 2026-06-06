<?php

namespace Bt\Sales\Models;

use Bt\Sales\Models\Srn as SrnModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ConvertedQuotes implements FromArray, ShouldAutoSize, WithEvents
{

    public function array(): array{

        $quoteQuery = Newquote::whereBetween('created_at',['2023-01-01', now()])->with('responses')->get();
        $quotes =    $quoteQuery->load(['items:id,quote_id,totalweight,units', 'itemscat:id,quote_id,totalweight,units']);
        $quoteObj[] = array_merge(
            [
                "Quote No",
                "Date of Quote",
                "Quote Value",
                "Quoted KGs",
                "Quoted Buyouts",
                "Account Manager",
                "Customer",
                "Converted To PO?",
                "Date of PO Reciept",
                "KG Produced",
                "Number of Deliveries",
                "KGs Delivered",
                "Buyouts Delivered",
                "Number of Invoices Issued",
                "Total Invoiced"
            ],
            array_map(function($i) { return "Invoice Date $i"; }, range(1, 33)),
            array_map(function($i) { return "Invoice Amount $i"; }, range(1, 33))
        );

        foreach ($quotes as $quote) {
            $cancelled = $quote->responses->where('quote_status_id', 20)->first();
            $sales_person = $quote->user->name . " " . $quote->user->surname;
            if (empty($cancelled)) {
                $invoiceDates = [];
                $invoiceAmounts = [];
                foreach ($quote->invoice as $invoice) {
                    $invoiceDates[] = $invoice->created_at;
                    $invoiceAmounts[] = number_format($invoice->amount, 2, '.', '');
                }

                $poDate = null;
                $poStatus = 0;
                $poItem = $quote->whereHas('responses', function ($query) {
                    $query->where('quote_status_id', 10);
                })->first();

                if (!empty($poItem)) {
                    $poDate = $poItem->created_at;
                    $poStatus = 1;
                }

                $total_quote_kg = $quote->items->sum('totalweight') + $quote->itemscat->sum("totalweight");
                $buy_outs = $quote->itemscat->sum('units');
                $row = [
                    $quote->id,
                    $quote->created_at,
                    number_format($quote->totalincvat, 2, '.', ''),
                    $total_quote_kg,
                    $buy_outs,
                    $sales_person,
                    $quote->company_name,
                    $poStatus,
                    $poDate,
                    optional($quote->qpush)->getTotalKgProcessedAttribute()?:null,
                    $quote->srn->count(),
                    optional($quote)->getDeliveredKg($quote->id)?:null,
                    optional($quote)->getBuyOutsDelivered($quote->id)?:null,
                    $quote->invoice->count(),
                    number_format($quote->invoice->sum("amount"), 2, '.', '')
                ];

                // Append invoice dates and amounts, up to 25 pairs
                for ($i = 0; $i < 33; $i++) {
                    $row[] = $invoiceDates[$i] ?? ''; // Use empty string if the date doesn't exist

                }

                for($i = 0; $i < 33; $i++)
                {
                    $row[] = $invoiceAmounts[$i] ?? ''; // Use empty string if the amount doesn't exist
                }

                $quoteObj[] = $row;
            }
        }
        return [$quoteObj];
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
                $cellRange = 'A1:DK1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14)->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKBLUE));
            },
        ];
    }
}
