<?php

namespace App\Exports;

use App\Models\Procurement;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonitoringProcessDataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Procurement::all();
    }
}
