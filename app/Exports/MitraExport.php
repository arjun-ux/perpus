<?php

namespace App\Exports;

use App\Models\Mitra;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class MitraExport implements FromQuery
{
    use Exportable;


    public function query()
    {
        return Mitra::query()->whereYear('created_at', date('Y'));
    }
}
