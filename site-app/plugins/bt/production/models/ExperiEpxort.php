<?php namespace Bt\Production\Models;

use Backend\Models\User;
use Bt\Sales\Models\Srn;
use Bt\Sales\Models\SrnItem;
use Carbon\Carbon;
use Dompdf\FrameDecorator\AbstractFrameDecorator;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ExperiEpxort implements FromArray, ShouldAutoSize, WithEvents
{
    public $lines = array();
    public function array(): array
    {
        #Name: Farai Chakarisa
        #Description: Experimental Export for Production
        #link: i.btindustrial.co.za/backend/push/export
        #Change: Added Delivered and Produced Fields
        $holdit = array();
        $pushObj = \Bt\Production\Models\Push::where('created_at', '>', '2023-10-01')->orderBy('created_at', 'desc')->get();

        $holdit[] = array('Production ID', 'Client Name', 'Quote Number', 'Sales Value', 'Sales Weight', 'Status', 'Delivery Amount', 'Delivery Amount Hidden', 'Standard Prouction Weight', 'Actual Production Weight', 'Difference Of Sales Weight and Standard');

        $delivery_requested = 0;

        foreach ($pushObj as $push){
            if($push->quote->items->sum('id') > 0){
                $produccdWeight = 0;
                $standardWeight  = 0;
                if(!empty($push->pipes)){
                    foreach ($push->pipes as $pipe){
                        $produccdWeight += $pipe->schedules->sum('total_kg_processed');
                    }
                    foreach ($push->quote->items as $item)
                    {
                        $standardWeight += ($item->product->production_value * $item->unitlength) * $item->units;
                    }
                }

                if($push->quote->deliveryrequest == 0){
                    $delivery_requested = "No";
                }else{
                    $delivery_requested = "Yes";
                }
                $holdit[] = [
                    $push->id,
                    $push->quote->company_name,
                    $push->quote_id,
                    $push->quote->items->sum('price'),
                    $push->quote->items->sum('totalweight'),
                    $delivery_requested,
                    $push->quote->deliveryamount,
                    $push->quote->deliveryamounthidden,
                    $standardWeight,
                    $produccdWeight,
                    $push->quote->items->sum('totalweight') - $standardWeight,
                ];
            }

        }
        return [
            $holdit
        ];
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

            },
        ];
    }
}
