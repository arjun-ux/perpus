<?php

namespace App\Imports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantriImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Santri([
            // 'niup' => $row['NIUP'],
            // 'nim' => $row['NIM'],
        ]);
    }
}
