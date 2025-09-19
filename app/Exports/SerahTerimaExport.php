<?php

namespace App\Exports;

use App\Models\SerahTerima;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SerahTerimaExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SerahTerima::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'Name',
            'Department',
            'Code',
            'Desc',
            'Remark',
            'Create',
        ];
    }

    public function map($row): array
    {
        static $index = 0;
        $index++;

        return [
            // Add sequential number instead of ID
            $index,
            $row->nik,
            $row->name,
            $row->department,
            $row->item_code,
            $row->itiem_name,
            $row->remark,
            $row->created_at,
        ];
    }

}
