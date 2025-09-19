<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
  /**
     * @return Collection
     */
    public function collection()
    {
        return Employee::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'Name',
            'Department',
            'Posisi',
            'Remark',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
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
            $row->posisi,
            $row->remark,
        ];
    }

    /**
     * @param mixed $row
     * @return int
     */
        
}
