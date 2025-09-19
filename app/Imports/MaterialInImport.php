<?php

namespace App\Imports;

use App\Models\MaterialIn;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MaterialInImport implements ToCollection, WithHeadingRow
{
    public $data;

    public $headerValid = true;
    public $expectedHeader = [
        'item_code','batch', 'qty', 'no_roll', 'gw', 'nw', 'width', 'gramasi', 'mo', 'style', 'rak_id', 'remark', 'satus'
    ];

    public function collection(Collection $rows)
    {
        // Validate the header
        $firstRow = $rows->first()->keys()->toArray();
        if ($firstRow !== $this->expectedHeader) {
            $this->headerValid = false;
            return;
        }

        $this->data = $rows;
    }

    public function getData()
    {
        return $this->data;
    }

    public function isHeaderValid()
    {
        return $this->headerValid;
    }
}
