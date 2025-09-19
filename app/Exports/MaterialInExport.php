<?php

namespace App\Exports;

use App\Models\MaterialIn;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MaterialInExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Ambil data berdasarkan tanggal.
     */
    public function collection()
    {
        return MaterialIn::with('details.item.unit', 'supplier')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
    }

    /**
     * Header kolom di Excel.
     */
    public function headings(): array
    {
        return [
            'Material IN No',
            'Supplier Name',
            'Date',
            'No SJ',
            'Receiver',
            'Location',
            'Courier',
            'Item Code',
            'Item Name',
            'Unit',
            'Color',
            'Size',
            'Quantity',
            'Remark',
        ];
    }

    /**
     * Mapping data untuk setiap baris.
     */
    public function map($materialIn): array
    {
        $rows = [];
        foreach ($materialIn->details as $detail) {
            $rows[] = [
                $materialIn->material_in_no,
                $materialIn->supplier->supplier_name ?? '',
                Carbon::parse($materialIn->created_at)->format('Y-m-d'),
                $materialIn->no_sj,
                $materialIn->received_by,
                $materialIn->location,
                $materialIn->courier,
                $detail->item_code,
                $detail->item->item_name ?? '',
                $detail->item->unit->unit_code ?? '',
                $detail->color_name ?? '',
                $detail->size ?? '',
                $detail->qty,
                $materialIn->remark ?? '',
            ];
        }
        return $rows;
    }
}
