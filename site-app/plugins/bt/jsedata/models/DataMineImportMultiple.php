<?php namespace Bt\JSEData\Models;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Bt\JSEData\Models\DataMineImport;

class DataMineImportMultiple  implements WithMultipleSheets
{

    public function sheets(): array
    {

        return [
            "Income Statement" => new DataMineImport(1),
            "Balance Sheet" => new DataMineImport(2),
            "Cash Flow Statement" => new DataMineImport(3),
            "Share Statistics" => new DataMineImport(4),
            "Share Data" => new DataMineImport(5)

        ];
    }
}
