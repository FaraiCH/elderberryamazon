<?php namespace Bt\Sales\Models;


use Backend\Models\ExportModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Session;

class QuoteItemExport implements FromArray, ShouldAutoSize, WithEvents
{
    public function array(): array{
        $quoteItemsObj = array();
        $quoteItemsObj[] = array(
            "ID",
            "Quote No",
            "In Production?",
            "Name",
            "Qty",
            "Price Per KG",
            "Unit Price",
            "Total Price",
            "Weight",
            "Created By",
            "Updated By",
            "Date Created",
            "Date Updated",
        );
        $production = null;
        $created = null;
        $updated = null;
        if(isset($_SESSION['quote'])){
            $new_quote = Newquote::find($_SESSION['quote']);

            if(!empty($new_quote->items))
            {
                foreach ($new_quote->items as $pipe){
                    if(!empty($pipe->pipe))
                        $production = $pipe->pipe->created_at;
                    if(!empty($pipe->createdby)){
                        $created = $pipe->createdby->first_name . ' ' .$pipe->createdby->last_name;
                    }
                    if(!empty($pipe->updatedby)){
                        $updated = $pipe->updatedby->first_name . ' ' . $pipe->updatedby->last_name;
                    }
                    $quoteItemsObj[] = array(
                        $pipe->id,
                        $pipe->quote_id,
                        $production,
                        $pipe->description,
                        $pipe->units,
                        number_format($pipe->priceperkg, 2,'.', ','),
                        number_format($pipe->unitprice, 2, '.', ','),
                        number_format($pipe->totalprice, 2, '.', ','),
                        number_format($pipe->weight, 2, '.', ','),
                        $created,
                        $updated,
                        $pipe->created_at,
                        $pipe->updated_at,
                    );

                }
            }
            if(!empty($new_quote->itemscat))
            {
                foreach ($new_quote->itemscat as $catalogue){
                    if(!empty($catalogue->createdby)){
                        $created = $catalogue->updatedby->first_name . ' ' . $catalogue->createdby->last_name;
                    }
                    if(!empty($catalogue->updatedby)){
                        $updated = $catalogue->updatedby->first_name . ' ' . $catalogue->updatedby->last_name;
                    }
                    $quoteItemsObj[] = array(
                        $catalogue->id,
                        $catalogue->quote_id,
                        null,
                        $catalogue->description,
                        $catalogue->units,
                        number_format($catalogue->priceperkg, 2, '.', ','),
                        number_format($catalogue->unitprice, 2, '.', ','),
                        number_format($catalogue->price, 2, '.', ','),
                        number_format($catalogue->weight, 2, '.', ','),
                        $created,
                        $updated,
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
