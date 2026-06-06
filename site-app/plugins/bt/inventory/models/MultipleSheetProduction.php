<?php

namespace Bt\Inventory\Models;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetProduction implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new MinimumRunExport(),
            new ProductionReportExport(),
        ];
    }
}
