<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ProductExport implements FromCollection, WithDrawings, WithColumnWidths, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
    }


    public function drawings()
    {


        $drawing = new Drawing();

        $coba = new Product();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('image');
        $drawing->setDescription('This is my signatuer');
        $drawing->setPath(public_path('upload/product/20231205045313.png'));

        $drawing->setHeight(90);
        $drawing->setCoordinates('l1');

        return $drawing;
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'detail',
            'image',
            'created_at',
            'updated_at',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
        ];
    }
}
