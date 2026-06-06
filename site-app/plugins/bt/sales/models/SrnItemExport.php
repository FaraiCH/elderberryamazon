<?php

namespace Bt\Sales\Models;

use Bt\Production\Models\ControlSheet;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SrnItemExport implements FromArray, ShouldAutoSize, WithEvents
{
    public function array(): array{
        $quoteItemsObj = array();
        $quoteItemsObj[] = array(
            "Item ID",
            "Client",
            "SRN No",
            "Quote No",
            "Batch No",
            "Name",
            "Qty",
            "Stock Weight",
            "Stock Value",
            "Date Created",
            "Date Updated",
        );
        if (isset($_SESSION['srnstart'])) {
            $srns = Srn::whereBetween('schedule_date', [$_SESSION['srnstart'], $_SESSION['srneend']]);
        } else {
            $srns = Srn::whereBetween('schedule_date', [Carbon::now()->subDays(30), Carbon::now()]);
        }
        if (isset($_SESSION['srn']) && $_SESSION['srn'] > 0) {
            $srns = $srns->where('id', $_SESSION['srn']);
        }
        $srns = $srns->orderBy('id', 'desc')->orderBy('schedule_date', 'desc')->get();
        $batch = '';
        foreach ($srns as $srn) {
            if (!empty($srn->items))
            {
                foreach ($srn->items as $item) {
                    $description = null;
                    if(!empty($item->pipe->quoteitems->quote)){
                        $description = $item->pipe->quoteitems->description;
                    }
                    if(!empty($item->pipe->jobcard)){
                        foreach ($item->pipe->jobcard as $key => $value) {
                            foreach ($value->batch as $k => $v) {
                                $batch = sprintf("%04d", $value->id)."-".sprintf("%04d", $v->id)." ";
                            }
                        }

                    }else{
                        $batch = 'Nah';
                    }
                    $quoteItemsObj[] = array(
                        $item->id,
                        optional(optional($item->pipe->quoteitems)->quote)->company_name,
                        $item->srn_id,
                        $item->srn->quote_id,
                        $batch,
                        $description,
                        $item->units,
                        number_format($item->stockweight, 2,'.', ','),
                        number_format($item->stockvalue, 2, '.', ','),
                        $item->created_at,
                        $item->updated_at,
                    );
                }
            }
            if(!empty($srn->itemscat))
            {
                foreach ($srn->itemscat as $catalogue){
                    if (is_object($catalogue->qoutecat) && !empty($catalogue->qoutecat)) {
                        $description = $catalogue->qoutecat->description;
                    } else {
                        $description = "No description";
                    }
                    $quoteItemsObj[] = array(
                        $catalogue->id,
                        $catalogue->srn->quote->company_name,
                        $catalogue->srn_id,
                        $catalogue->srn->quote_id,
                        $batch,
                        $description,
                        $catalogue->units,
                        number_format($catalogue->stockvalue, 2, '.', ','),
                        null,
                        $catalogue->created_at,
                        $catalogue->updated_at,
                    );

                }
            }

        }

        return [$quoteItemsObj];
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
