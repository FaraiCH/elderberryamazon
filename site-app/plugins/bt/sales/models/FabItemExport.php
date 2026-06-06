<?php

namespace Bt\Sales\Models;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FabItemExport implements FromArray, ShouldAutoSize, WithEvents
{
    public function array(): array{
        $quoteItemsObj = array();
        $quoteItemsObj[] = array(
            "Item ID",
            "Fabrication No",
            "Batch No",
            "Quote No",
            "Name",
            "Qty",
            "Stock Weight",
            "Stock Value",
            "Date Created",
            "Date Updated",
        );
        if (isset($_SESSION['srnstart'])) {
            $srns = Fabrication::whereBetween('schedule_date', [$_SESSION['srnstart'], $_SESSION['srneend']]);
        } else {
            $srns = Fabrication::whereBetween('schedule_date', [Carbon::now()->subDays(30), Carbon::now()]);
        }
        if (isset($_SESSION['srn']) && $_SESSION['srn'] > 0) {
            $srns = $srns->where('id', $_SESSION['srn']);
        }
        $srns = $srns->orderBy('id', 'desc')->orderBy('schedule_date', 'desc')->get();

        foreach ($srns as $srn) {
            if (!empty($srn->items))
            {
                foreach ($srn->items as $item) {
                    $description = null;
                    $fabrication = null;
                    $batch = null;
                    if(!empty($item->pipe->quoteitems)){
                        $description = $item->pipe->quoteitems->description;
                    }
                    if(!empty($item->fabrication)){
                        $fabrication =  $item->fabrication->quote_id;

                    }
                    if(isset($item->pipe->jobcard->first()->id)){
                        $batch = $item->pipe->jobcard->first()->id . " - " . $item->pipe->jobcard->first()->batch->first()->id;
                    }
                    $quoteItemsObj[] = array(
                        $item->id,
                        $item->fabrication_id,
                        $batch,
                        $fabrication,
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
                    $fabrication = null;
                    if(!empty($item->fabrication)){
                        $fabrication =   $catalogue->fabrication->quote_id;
                    }
                    $quoteItemsObj[] = array(
                        $catalogue->id,
                        $catalogue->fabrication_id,
                        "",
                        $fabrication,
                        $catalogue->qoutecat->description,
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
