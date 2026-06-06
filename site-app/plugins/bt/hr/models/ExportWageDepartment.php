<?php namespace Bt\Hr\Models;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportWageDepartment  implements FromArray, ShouldAutoSize, WithEvents
{
    public $lines = [];
    public function array(): array
    {
        $wagebObj = Wagebill::select('employee_id')->distinct()->get();
        $dataObj = [];
        $counter = 2;
        $dataObj[] = [
            'employee' => "Employee Name",
            'role' => "Designation",
            'department' => "Department",
        ];
        foreach ($wagebObj as $wages){
            $counter++;
            if(isset($wages->employee->designation->name)){
                $designation = $wages->employee->designation->name;
            }else{
                $designation = 'None';
            }
            $dataObj[$wages->employee->id] = [
                'employee' => $wages->employee->firstname . " " . $wages->employee->lastname,
                'role' => $designation,
                'department' => $wages->employee->department->name,
            ];
            $this->lines['rows'][$counter] = $counter;
         }
        return [$dataObj];
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
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->insertNewRowBefore(1);
                $countRow = 2;
                $countcolumn = 3;
                $mylastColumn = 0;
                $wagebObj = Wagebill::with(['employee', 'leavetype'])->whereBetween('date',['2023-09-01', '2023-10-30'])->get();
                $days = [];
                foreach ($wagebObj as $wages){
                    if(!isset($wages->hours_over) || $wages->hours_over < 0){
                        $negative_over = 0;
                    }else{
                        $negative_over = $wages->hours_over;
                    }
                    if(isset($wages->leavetype->name)){
                        $leave = $wages->leavetype->name;
                    }else{
                        $leave = 'None';
                    }

                    if($wages->shift == 0)
                    {
                        $shift = "Day";
                    }
                    elseif ($wages->shift = 1)
                    {
                        $shift = "Night";
                    }else
                    {
                        $shift = "Next Day";
                    }
                    if(isset($wages->employee->designation->name)){
                        $designation = $wages->employee->designation->name;
                    }else{
                        $designation = 'None';
                    }

                    $this->lines['headers'][] = [
                        $countcolumn + 1 => "Shift",
                        $countcolumn + 2 => "Start Time",
                        $countcolumn + 3 => "End Time",
                        $countcolumn + 4 => "Hours Worked",
                        $countcolumn + 5 => "Normal Hours",
                        $countcolumn + 6 => "Overtime",
                        $countcolumn + 7 => "Double Time",
                        $countcolumn + 6 => "Shift Cancellation",
                        $countcolumn + 7 => "Leave/Holiday",
                    ];
                    $this->lines['employees'][$wages->employee->id][$wages->date] = [
                        $countcolumn + 1 => $shift,
                        $countcolumn + 2 => $wages->start_time,
                        $countcolumn + 3 => $wages->end_time,
                        $countcolumn + 4 => $wages->hours_worked,
                        $countcolumn + 5 => $wages->normal,
                        $countcolumn + 6 => $negative_over,
                        $countcolumn + 7 => $wages->double,
                        $countcolumn + 6 => $wages->cancel,
                        $countcolumn + 7 => $leave,
                    ];

                    $days[] = [
                        $countcolumn + 1 => $wages->date,
                    ];

                    $countcolumn = $countcolumn + 7;
                }


                foreach ($this->lines['headers'] as $default){

                    foreach ($default as $num => $value){
                        $event->sheet->setCellValueByColumnAndRow((int)$num, 2, $value);
                    }
                    $mylastColumn = $num;
                }
                $countRow++;
                $myrows = $this->lines['rows'][$countRow];
//                foreach ($this->lines['hours'] as $default){
//                    foreach ($default as $num => $value){
//                        $event->sheet->setCellValueByColumnAndRow((int)$num, $myrows, $value);
//                    }
//                }

                $cellRange = 'A2:'. $this->num2alpha($mylastColumn) . "2"; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14)->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));

                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('00008b');

            },
        ];
    }

    public function DepertmentExport(){

    }

    public function EmployeeExport(){

    }

    function num2alpha($n)
    {
        for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
            $r = chr($n%26 + 0x41) . $r;
        return $r;
    }
}
