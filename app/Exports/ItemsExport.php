<?php

namespace App\Exports;

use App\Models\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings
{
    /**
     * Return all items from the database.
     */
    public function collection()
    {
        return Item::select('id', 'item_code', 'item_name', 'description', 'category_id', 'unit_id', 'remark')
                    ->with(['category', 'unit'])
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'item_code' => $item->item_code,
                            'item_name' => $item->item_name,
                            'description' => $item->description,
                            'category' => optional($item->category)->name,
                            'unit' => optional($item->unit)->unit_code,
                            'remark' => $item->remark,
                        ];
                    });
    }

    /**
     * Define the headings of the Excel sheet.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Item Code',
            'Item Name',
            'Description',
            'Category',
            'Unit',
            'Remark'
        ];
    }
}
