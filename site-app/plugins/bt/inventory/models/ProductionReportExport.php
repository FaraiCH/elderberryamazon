<?php

namespace Bt\Inventory\Models;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Bt\Production\Models\Pipe as PipeModel;
use Bt\Production\Models\Schedule as ScheduleModel;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductionReportExport implements FromArray, ShouldAutoSize, WithEvents, WithTitle
{
    public $lines = array();
    public function title(): string
    {
        return 'Production Report';
    }
    public function array(): array{
        //Get from route
        $state = $_SESSION['state'];
        $company_id = $_SESSION['company_id'];

        $date = Carbon::now();

        if(isset($_SESSION['enddate'])){
            $this->enddate = $_SESSION['enddate'];
        }else{
            $this->enddate = Carbon::now()->setTime(23, 59, 0);
        }
        if(isset($_SESSION['prostart'])){;
            $this->startdate = $_SESSION['prostart'];
        }else{
            $current = Carbon::now();
            $this->startdate = $current->addDays(-7);
        }

        $data = array('startdate' => $this->startdate, 'enddate' => $this->enddate);
        $pipes = ScheduleModel::whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))->where('is_stock', 0)->get();
        $parra= array();
        foreach ($pipes as $v) {
            $parra[$v->pipe_id] = $v->pipe_id;
        }
        if(isset($_SESSION['openstart'])){
            $pipes = $this->getPipeModel($state, $parra, $data, $company_id);
        }else{
            $pipes = $this->getPipeModel($state, $parra, $data, $company_id);
        }
        $pipeCount = 2;
        $poqouteObj = array();

        $poqouteObj[] = array("Quote", "Client", "Pipe Description", "Diameter", "Unit Length", "Status", "Start Date","Units", "Weight Processed", "Overruns",  "Overruns Weight", "Scrap", "Scrap %", 'CODE', "Minimum Run", "Expected Scrap %",'',"Over weight (Kg)",  "Over weight %", "Wasted Material",  "Wasted %", "Material Used","Material Used Auto", '', 'Expected Scrap % Formula');

        foreach($pipes as $item) {
            if ($item->id > 3) {
                $total_auto_used = 0;
                $bt_units = 0;
                $bt_weight = 0;
                $sc_codes = null;
                $run = 0;
                $expected_scrap = 0;
                $length = 0;

                foreach($item->schedules as $sc){
                    if(!empty($sc->btaccount)){
                        $bt_units = $bt_units + $sc->btaccount->sum('units');
                        foreach ($sc->btaccount as $bt){
                            $bt_weight = $bt_weight + $bt->schedule->total_kg_processed;
                        }
                    }
                    foreach ($sc->usedmaterials as $rl) {
                        $total_auto_used = $total_auto_used + $rl->kg;
                    }
                }
                foreach ($item->schedules as $s_item){
                    foreach ($s_item->scrapcodes as $scrap_codes){
                        $sc_codes .= $scrap_codes->code . ' ';
                    }
                }
                if(isset($item->quoteitems->product->Diameter->minimumrun->minimum_run)){
                    $run = $item->quoteitems->product->Diameter->minimumrun->minimum_run;

                    $length = $item->quoteitems->product->Diameter->minimumrun->startup_scrap + $item->quoteitems->product->Diameter->minimumrun->end_scrap +
                        $item->quoteitems->product->Diameter->minimumrun->workmanship + $item->quoteitems->product->Diameter->minimumrun->other;

                    $expected_scrap = number_format((($length/($item->quoteitems->unitlength * $item->schedules->sum('total_units_passed_qc'))) * 100), 2, '.', '') ;

                }
                $this->lines[$pipeCount] = $pipeCount;
                $scrapperc = number_format(($item->schedules->sum('total_kg_processed') > 0)?(($item->schedules->sum('weight_scrap_kg')/$item->schedules->sum('total_kg_processed'))*100):0, 2, '.', '');
                $overweight_perc = number_format(($item->schedules->sum('over_weight_kg') > 0)?($item->schedules->sum('over_weight_kg')/$item->schedules->sum('total_kg_processed') * 100):0, 2, '.', '');
                $wasted = number_format($item->schedules->sum('weight_scrap_kg') + $item->schedules->sum('over_weight_kg'), 2, '.', '');
                $wasted_perc = number_format(($item->schedules->sum('total_kg_processed') > 0)? ($wasted*100)/$item->schedules->sum('total_kg_processed'):0, 2, '.', '');
                $material_used = number_format(($item->schedules->sum('weight_scrap_kg') + $item->schedules->sum('total_kg_processed')), 2, '.', '');

                $poqouteObj[] = array($item->qpush->quote->id, $item->qpush->quote->company_name, $item->quoteitems->description, $item->quoteitems->product->Diameter->name, $item->quoteitems->unitlength, $item->qpush->status->name, $item->start_date, number_format($item->schedules->sum('total_units_passed_qc'), 2,'.', ''),number_format($item->schedules->sum('total_kg_processed'), 2, '.', ''), $bt_units,  $bt_weight, number_format($item->schedules->sum('weight_scrap_kg'), 2, '.', '') , $scrapperc, $sc_codes,$run, $length, $expected_scrap, number_format($item->schedules->sum('over_weight_kg'), 2, '.', '')  , $overweight_perc, $wasted, $wasted_perc, $material_used,$total_auto_used);
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
                    $event->sheet->setCellValue('O'. $key, "=VLOOKUP(D" . $key .",'Minimum Run'!A$2:H$26,7)");
                    $event->sheet->setCellValue('P'. $key, "=VLOOKUP(D" . $key .",'Minimum Run'!A$2:H$26,6)");
                    $event->sheet->setCellValue('Q'. $key, "=P" . $key ."/H". $key . "/E". $key);
                    $event->sheet->formatColumn(
                        'Q', '0.00%'
                    );
                    $event->sheet->mergeCells('P1:Q1');
                    $lastCell = $pipePosition;
                }
                $event->sheet->getDelegate()->getStyle('O2:Q'. $lastCell)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('ffa4ffa4');
                $event->sheet->getDelegate()->getStyle('P1:Q1')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);;
                $event->sheet->setCellValue('Y'. '2', '(Length(Minimum Run)/(Unit Length * Units Produced)) * 100');
                $event->sheet->getDelegate()->getStyle('Y3')->getFont()->setSize(14)->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKBLUE));
                $event->sheet->setCellValue('Y'. '3', 'Minimum Run Length Formula');

                $event->sheet->setCellValue('Y'. '4', 'Start Up Scrap(MR) + End Scrap(MR) + Workmanship(MR) + Other(MR)');
            },
        ];
    }

    function getPipeModel($state, $parra, $data, $company_id){
        $pipe = PipeModel::whereIn('id',$parra)
            ->whereHas('schedules', function ($query) use ($data) {
                $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))->where('is_stock', 0)->has('usedmaterials');
            })
            ->with(['schedules' => function ($query) use ($data) {
                $query->whereBetween('production_date', array($data['startdate'], $data['enddate']." 23:59:00"))->where('is_stock', 0)->has('usedmaterials');
            }])
            ->orderBy('start_date','desc');
        if($state === "standard")
            $pipe = $pipe->get();
        elseif($state === "only")
            $pipe = $pipe->whereHas('quoteitems', function($query) use($company_id){
                $query->whereHas('quote', function($q) use ($company_id){
                    $q->whereHas('client', function($que) use($company_id){
                        $que->where('id', $company_id);
                    });
                });
            })->get();
        elseif($state === "exclude")
            $pipe = $pipe->whereHas('quoteitems', function($query) use($company_id){
                $query->whereHas('quote', function($q) use ($company_id){
                    $q->whereHas('client', function($que) use($company_id){
                        $que->where('id', '<>', $company_id);
                    });
                });
            })->get();
        else{
            $pipe = $pipe->get();
        }
        return $pipe;
    }
}
