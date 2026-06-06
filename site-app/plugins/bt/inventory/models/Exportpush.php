<?php namespace Bt\Inventory\Models;


use Bt\Production\Models\Push as PushModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

/**
 * Supplier Model
 */
class Exportpush implements FromQuery
{
    var $id;
    use Exportable;

      function __construct($passid)
   {
       $this->id = $passid;
   }


     public function query()
    {
        return PushModel::query()->where('id',$this->id);
    }
}
