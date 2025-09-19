<?php

namespace App\Exports;

use App\Models\Bom;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BomExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Fetch data for export.
     */
    public function collection()
    {
        return Bom::with('details.item.unit', 'details.item.category')->get();
    }

    /**
     * Define column headings.
     */
    public function headings(): array
    {
        return [
            'BOM NO',
            'Style',
            'CBD ID',
            'Item ID',
            'Item Code',
            'Item Name',
            'Unit',
            'Category',
            'Size',
        	'Color',
            'Consumption',
        ];
    }

    /**
     * Map data to rows.
     */
    public function map($bom): array
    {
        $rows = [];

        foreach ($bom->details as $detail) {
            $rows[] = [
                $bom->bom_no,
                $bom->style,
                $bom->cbd_id,
                $detail->item_id,
                $detail->item->item_code ?? '-',
                $detail->item->item_name ?? '-',
                $detail->item->unit->unit_code ?? '-',
                $detail->item->category->name ?? '-',
                $detail->size ?? '-',
             	$detail->remark1 ?? '-',
                $detail->consumption,
            ];
        }

        return $rows;
    }
}
