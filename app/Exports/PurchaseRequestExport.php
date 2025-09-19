<?php
namespace App\Exports;

use App\Models\PurchaseRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseRequestExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Mengambil data berdasarkan rentang tanggal dan ekspand detail request.
     */
    public function collection()
    {
        // Mengambil data PurchaseRequest dan detailrequest-nya
        $purchaseRequests = PurchaseRequest::with('detailrequest.item.unit','detailrequest.item.category', 'cbd', 'user')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        $exportData = [];

        // Loop untuk memisahkan setiap detail request ke baris terpisah
        foreach ($purchaseRequests as $purchaseRequest) {
            foreach ($purchaseRequest->detailrequest as $detail) {
                $exportData[] = [
                    'purchase_request_id' => $purchaseRequest->id,
                    'purchase_request_no' => $purchaseRequest->purchase_request_no,
                    'cbd_order_no' => $purchaseRequest->cbd->order_no ?? '-',
                    'tipe' => $purchaseRequest->tipe,
                    'mo' => $purchaseRequest->mo,
                    'style' => $purchaseRequest->style,
                    'destination' => $purchaseRequest->destination,
                    'applicant' => $purchaseRequest->applicant,
                    
                    'item_code' => $detail->item->item_code ?? '-',  // Menambahkan item_code
                    'category_name' => $detail->item->category->name ?? '-',  // Menambahkan category_name
                    'item_name' => $detail->item->item_name ?? '-',
                    'color' => $detail->color ?? '-',
                    'size' => $detail->size ?? '-',
                    'unit_code' => $detail->item->unit->unit_code ?? '-',
                    'total' => $detail->total ?? '-',
                    'remark' => $detail->remark ?? '-',
                    'status' => $detail->status ?? '-',
                    'created_at' => $purchaseRequest->created_at->format('Y-m-d H:i:s'), // Tambahkan created_at
                    'user_id' => $purchaseRequest->user->id ?? '-', // Menambahkan user_id
                    'user_name' => $purchaseRequest->user->name ?? '-', // Menambahkan user_name
                ];
            }
        }

        return collect($exportData);
    }

    /**
     * Header kolom di file Excel.
     */
    public function headings(): array
    {
        return [
            'Request No',
            'CBD Order No',
            'Type',
            'MO',
            'Style',
            'Destination',
            'Applicant',
            'Item Code',         // Tambahkan header untuk item_code
            'Category Name',     // Tambahkan header untuk category_name
            'Item Name',
            'Color',
            'Size',
            'Unit',
            'Total',
            'Remarks',
            'Status',
            'Created At',
            'User ID',
            'User Name',
        ];
    }

    /**
     * Mapping data model ke baris Excel.
     */
    public function map($row): array
    {
        return [
            $row['purchase_request_no'],
            $row['cbd_order_no'],
            $row['tipe'],
            $row['mo'],
            $row['style'],
            $row['destination'],
            $row['applicant'],
            $row['item_code'],      // Masukkan item_code ke dalam mapping
            $row['category_name'],  // Masukkan category_name ke dalam mapping
            $row['item_name'],
            $row['color'],
            $row['size'],
            $row['unit_code'],
            $row['total'],
            $row['remark'],
            $row['status'],
            $row['created_at'],
            $row['user_id'],
            $row['user_name'],
        ];
    }
}
