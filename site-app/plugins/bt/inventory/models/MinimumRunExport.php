<?php

namespace Bt\Inventory\Models;

use Bt\Production\Models\Minimumrun;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class MinimumRunExport implements FromArray, ShouldAutoSize, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'Minimum Run';
    }
    public function array(): array{
        $minimumRunObj = [];
        $minimumRuns = Minimumrun::all();
            $minimumRunObj[] = [
                'Diameter (mm)',
                'StartUp Scrap (m)',
                'End Scrap (m)',
                'Workmanship (m)',
                'Other (m)',
                'Total length (m)',
                'Minimum Run',
                'Target Scrap %',
                'Factor %'
            ];
        foreach ($minimumRuns as $minimumRun){
            $length = $minimumRun->startup_scrap + $minimumRun->end_scrap + $minimumRun->workmanship + $minimumRun->workmanship + $minimumRun->other;
            $minimumRunObj[] =[
                $minimumRun->diameter->name,
                $minimumRun->startup_scrap,
                $minimumRun->end_scrap,
                $minimumRun->workmanship,
                $minimumRun->other,
                $length,
                $minimumRun->minimum_run,
                $minimumRun->target_scrap,
                $minimumRun->factor
            ];
        }
        return [$minimumRunObj];
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
