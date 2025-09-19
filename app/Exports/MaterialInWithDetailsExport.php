<?php

namespace App\Exports;

use App\Models\MaterialIn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;

class MaterialInWithDetailsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return MaterialIn::with('details')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Material In ID',
            'Material In No',
            'Supplier ID',
            'No SJ',
            'Received By',
            'Location',
            'Courier',
            'Remark',
            'Detail ID',
            'Purchase Order ID',
            'Original No',
            'Receive Date',
            'Supplier Name',
            'Item Code',
            'PO',
            'Color Code',
            'Color Name',
            'Size',
            'Batch',
            'Roll',
            'Gross Weight',
            'Net Weight',
            'Qty',
            'Basic Width',
            'Basic Grm',
            'MO',
            'Actual Weight',
            'Rak',
            'Note',
            'Created At',
            'Updated At',
        ];
    }

    public function map($materialIn): array
    {
        $mappedData = [];

        foreach ($materialIn->details as $detail) {
            $mappedData[] = [
                $materialIn->id,
                $materialIn->material_in_no,
                $materialIn->supplier_id,
                $materialIn->no_sj,
                $materialIn->received_by,
                $materialIn->location,
                $materialIn->courier,
                $materialIn->remark,
                $detail->id,
                $detail->purchase_order_id,
                $detail->original_no,
                $detail->receive_date,
                $detail->supplier_name,
                $detail->item_code,
                $detail->po,
                $detail->color_code,
                $detail->color_name,
                $detail->size,
                $detail->batch,
                $detail->roll,
                $detail->gross_weight,
                $detail->net_weight,
                $detail->qty,
                $detail->basic_width,
                $detail->basic_grm,
                $detail->mo,
                $detail->actual_weight,
                $detail->rak,
                $detail->note,
                $materialIn->created_at,
                $materialIn->updated_at,
            ];
        }

        return $mappedData;
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function(\Maatwebsite\Excel\Events\AfterSheet $event) {
                $event->sheet->getDelegate()->freezePane('A2');
            },
        ];
    }
}
