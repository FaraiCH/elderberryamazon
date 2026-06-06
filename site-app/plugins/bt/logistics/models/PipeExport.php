<?php


namespace Bt\Logistics\Models;

use Backend\Models\ExportModel;
use Bt\Production\Models\Jobcard;
use Bt\Production\Models\JobCardBatch;
use Bt\Sales\Models\Newquote as QuoteModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class PipeExport implements FromArray, ShouldAutoSize, WithEvents
{
    /*
 *     id batch_no quote_no quote_name date length pn product sdr qty unitprice totalamount weights totalweights created_at
 */
    public function array(): array
    {
        $now = Carbon::now();
        $weekStartDate = $now;
        $weekEndDate = Carbon::now()->addDays(-30);
        $pipeObj = array();
        $pipes  = Pipeprice::whereBetween('created_at', array($weekEndDate, $weekStartDate))->with('quote')->get()->sortBy('quote.company_name');
        $pipeObj[] = array("Batch no", "Quote No", "Quote Name", "Start Date", "Length", "PN", "Product", "SDR", "Quantity", "Unit Price", "Total Amount", "Weights", "Total Weights", "Stock Created Date");
        foreach ($pipes as $pipe) {
            $jobcard = Jobcard::find($pipe->batch->jobcard_id);
            $pipeObj[] = array($pipe->batch->jobcard_id . ' - '. $pipe->batch->id , $pipe->quote->id, $pipe->quote->company_name, $jobcard->pipe->start_date, $pipe->length, $pipe->pn, $pipe->product, $pipe->sdr, $pipe->qty, $pipe->unitprice, $pipe->totalamount, $jobcard->pipe->quoteitems->weight, $jobcard->pipe->quoteitems->totalweight, $pipe->created_at);
        }


        return [$pipeObj];
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
