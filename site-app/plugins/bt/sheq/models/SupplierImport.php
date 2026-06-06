<?php


namespace Bt\Sheq\Models;


use Maatwebsite\Excel\Concerns\ToModel;

class SupplierImport Implements ToModel
{
    public function model(array $row)
    {
        return new Supplier([
            'company_name' => $row[0],
            'company_description' => $row[1],
            'items' => $row[2],
            'nationality' => $row[3],
            'person' => $row[4],
            'email' => $row[5],
            'number' => $row[6],
            'tax' => $row[7],
            'bbbee' => $row[8],
            'account' => $row[9],
        ]);
    }
}
