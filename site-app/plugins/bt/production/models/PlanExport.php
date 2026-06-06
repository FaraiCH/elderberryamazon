<?php

namespace Bt\Production\Models;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class PlanExport implements FromArray, ShouldAutoSize, WithEvents, WithTitle
{
    public $lines = array();
    public function title(): string
    {
        return 'Production Plan';
    }

    public function array(): array{

        if(isset($_SESSION['openstart'])){
            $obj = \Bt\Production\Models\ProductionPlan::whereBetween('startdate', [$_SESSION['openstart'], $_SESSION['openend']])->where('type', 0)->get();
        }else{

            $obj = \Bt\Production\Models\ProductionPlan::whereBetween('startdate', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        }
        $poqouteObj = array();
        $poqouteObj[] = array("Quote", "Client", "Production Push Plan", "Pipe Size", "OD","PN", "Unit Length", "Units",  "Unit Weight", "Tonnage (KG)", "Due Date", 'Minimum Run', "Length",  "Expected Scrap %", "Baila 1 Estimated Runtime (H)",  "Baila 2 Estimated Runtime (H)", "Baila 3 Estimated Runtime (H)",  "Baila 4 Estimated Runtime (H)", "Baila 5 Estimated Runtime (H)");
        $pipeCount = 2;
        foreach ($obj as $sub){
            foreach($sub->planitems as $planitem){
                $enddate = new \DateTime($planitem->enddate);
                $dateFormat = $enddate->format('d F');
                $days = 'No Production';
                $min = 0;
                $length = 0;
                $scrap = 0;
                if(isset($planitem->item->pipe->id)){
                    $datess = new \DateTime($planitem->item->pipe->created_at);
                    $date1 = $datess->format('Y-m-d');
                    $date2 = date('Y-m-d');
                    $timestamp1 = strtotime($date1);
                    $timestamp2 = strtotime($date2);
                    $difference = $timestamp2 - $timestamp1;
                    $days = $datess->format('d-M') . ' ('. $difference/(24*60*60) . ' days)';
                }
                if (isset($planitem->item->product->Diameter->minimumrun)) {
                    $min = $planitem->item->product->Diameter->minimumrun->minimum_run;

                    $length = $planitem->item->product->Diameter->minimumrun->startup_scrap + $planitem->item->product->Diameter->minimumrun->end_scrap +
                        $planitem->item->product->Diameter->minimumrun->workmanship + $planitem->item->product->Diameter->minimumrun->other;

                    $scrap = number_format((($length/($planitem->item->unitlength * $planitem->qty)) * 100), 2) ;
                }
                if ($sub->line_id == 2) {
                    $poqouteObj[] = array($planitem->quote_id, $planitem->quote->company_name, $days, $planitem->item->product->Diameter->name, $planitem->item->product->od_min, $planitem->item->product->PNRating->name, $planitem->item->unitlength, $planitem->qty, $planitem->item->weight, $planitem->item->weight * $planitem->qty, $dateFormat, $min, $length, $scrap .'%', number_format($planitem->item->weight / 600, 1) , 0, 0, 0);
                }elseif ($sub->line_id == 1) {
                    $poqouteObj[] = array($planitem->quote_id, $planitem->quote->company_name, $days, $planitem->item->product->Diameter->name, $planitem->item->product->od_min, $planitem->item->product->PNRating->name, $planitem->item->unitlength, $planitem->qty, $planitem->item->weight, $planitem->item->weight * $planitem->qty, $dateFormat, $min, $length, $scrap .'%', 0, number_format($planitem->item->weight / 600, 1) , 0, 0);
                }
                elseif ($sub->line_id == 3) {
                    $poqouteObj[] = array($planitem->quote_id, $planitem->quote->company_name, $days, $planitem->item->product->Diameter->name, $planitem->item->product->od_min, $planitem->item->product->PNRating->name, $planitem->item->unitlength, $planitem->qty, $planitem->item->weight, $planitem->item->weight * $planitem->qty, $dateFormat, $min, $length, $scrap .'%', 0, 0,number_format($planitem->item->weight / 350, 1) , 0);
                }
                elseif ($sub->line_id == 4) {
                    $poqouteObj[] = array($planitem->quote_id, $planitem->quote->company_name, $days, $planitem->item->product->Diameter->name, $planitem->item->product->od_min, $planitem->item->product->PNRating->name, $planitem->item->unitlength, $planitem->qty, $planitem->item->weight, $planitem->item->weight * $planitem->qty, $dateFormat, $min, $length, $scrap .'%', 0, 0, 0, number_format($planitem->item->weight / 220, 1));
                }
                $this->lines[$pipeCount] = $pipeCount;
                $pipeCount++;
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
                $cellRange = 'A1:Y1'; // All headers
                $lastCell = 0;
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14)->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKBLUE));

                foreach ($this->lines as $key => $pipePosition) {
                    $event->sheet->setCellValue('L'. $key, "=VLOOKUP(D" . $key .",'Minimum Run'!A$2:H$26,7)");
                    $event->sheet->setCellValue('M'. $key, "=VLOOKUP(D" . $key .",'Minimum Run'!A$2:H$26,6)");
                    $event->sheet->setCellValue('N'. $key, "=M" . $key ."/H". $key . "/G". $key);
                    $event->sheet->formatColumn(
                        'N', '0.00%'
                    );
                    $event->sheet->mergeCells('M1:M1');
                    $lastCell = $pipePosition;
                }
                $event->sheet->getDelegate()->getStyle('L2:N'. $lastCell)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('ffa4ffa4');
                $event->sheet->getDelegate()->getStyle('M1:N1')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);;
            },
        ];
    }
}
