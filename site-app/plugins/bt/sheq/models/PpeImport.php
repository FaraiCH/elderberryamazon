<?php


namespace Bt\Sheq\Models;


use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class PpeImport implements ToModel
{
    public function model(array $row)
    {
        return new Ppe([
            'name' => $row[0],
            'surname' => $row[1],
            'crew' => $row[2],
            'shoe_cover' => $row[3],
            'mop_caps' => $row[4],
            'beard_cover' => $row[5],
            'boats' => $row[6],
            'overall' => $row[7],
            'gloves' => $row[8]
        ]);
    }
}
