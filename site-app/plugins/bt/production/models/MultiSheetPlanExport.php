<?php

namespace Bt\Production\Models;

use Bt\Inventory\Models\MinimumRunExport;
use Bt\Production\Models\PlanExport;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetPlanExport implements WithMultipleSheets
{
      public function sheets(): array
      {
          return [
              new MinimumRunExport(),
              new PlanExport()
          ];
      }
}
