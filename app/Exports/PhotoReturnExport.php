<?php

namespace App\Exports;

use App\Models\PhotoReturn;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Collection;

class PhotoReturnExport implements  FromCollection, WithHeadings, WithEvents
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // return $this->data;

        $formattedData = $this->data->map(function ($row) {
            return [
                $row->department,
                $row->remark,
                $row->creator,
                $row->created_at,
                $row->photo1,
                $row->photo2,
                $row->photo3,
                $row->photo4,
                $row->photo5,
            ];
        });

        return $formattedData;
    }

  

    public function headings(): array
    {
        // Sesuaikan dengan kolom-kolom yang ingin Anda tampilkan dalam file Excel
        return [
            'Department',
            'Remark',
            'Creator',
            'Created',
            'Photo 1',
            'Photo 2',
            'Photo 3',
            'Photo 4',
            'Photo 5',
        ];
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $sheet = $event->sheet->getDelegate();
    //             $lastRow = $sheet->getHighestRow();

    //             for ($row = 2; $row <= $lastRow; $row++) {
    //                 for ($photoNumber = 1; $photoNumber <= 5; $photoNumber++) {
    //                     $column = 'D' . $row; // Photo 1 column

    //                     switch ($photoNumber) {
    //                         case 2:
    //                             $column = 'E' . $row; // Photo 2 column
    //                             break;
    //                         case 3:
    //                             $column = 'F' . $row; // Photo 3 column
    //                             break;
    //                         case 4:
    //                             $column = 'G' . $row; // Photo 4 column
    //                             break;
    //                         case 5:
    //                             $column = 'H' . $row; // Photo 5 column
    //                             break;
    //                     }

    //                     $photoPath = $sheet->getCell($column)->getValue();

    //                     if ($photoPath) {
    //                         $drawing = new Drawing();
    //                         $drawing->setName('Photo ' . $photoNumber);
    //                         $drawing->setDescription('Photo ' . $photoNumber);
    //                         $drawing->setPath(storage_path('app/public/' . $photoPath));
    //                         $drawing->setCoordinates($column);
    //                         $drawing->setOffsetX(5);
    //                         $drawing->setOffsetY(5);
    //                         $drawing->setWidthAndHeight(150, 150);
    //                         $drawing->setWorksheet($sheet);
    //                     }
    //                 }
    //             }
    //         },
    //     ];
    // }

    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                $photoColumns = ['E', 'F', 'G', 'H', 'I'];

                // Set row height to fit images
                $sheet->getRowDimension(1)->setRowHeight(20);

                // Set width for photo columns
                foreach ($photoColumns as $column) {
                    $sheet->getColumnDimension($column)->setWidth(30);
                }

                for ($row = 2; $row <= $lastRow; $row++) {
                    foreach ($photoColumns as $index => $column) {
                        // Set row height to fit images
                        $sheet->getRowDimension($row)->setRowHeight(100);

                        $photoPath = $sheet->getCell($column . $row)->getValue();

                        if ($photoPath) {
                            $drawing = new Drawing();
                            $drawing->setName('Photo ' . ($index + 1));
                            $drawing->setDescription('Photo ' . ($index + 1));
                            $drawing->setPath(storage_path('app/public/' . $photoPath));
                            $drawing->setCoordinates($column . $row);
                            $drawing->setOffsetX(5);
                            $drawing->setOffsetY(5);
                            $drawing->setWidthAndHeight(100, 100); // Adjust width and height as needed
                            $drawing->setWorksheet($sheet);
                        }
                    }
                }
            },
        ];
    }
}
