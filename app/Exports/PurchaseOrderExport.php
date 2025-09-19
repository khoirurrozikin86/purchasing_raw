<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseOrderExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Query untuk mengambil data Purchase Orders beserta relasi
        $query = PurchaseOrder::with(['supplier', 'purchaseRequest', 'detailorder.item.unit', 'detailorder.item.category', 'user']);

        // Filter berdasarkan tanggal jika parameter tersedia
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Purchase Order ID',
            'Purchase Order No',
            'Purchase Request No',
            'Supplier Name',
            'Supplier Remark',

            'Date in House',
            'MO',  // Added MO
            'Style',  // Added Style
            'Category',  // New column for item category
            'Item Code',
            'Item Name',
            'Unit',
            'Color',
            'Size',
            'Quantity',

            'Price',
            'Total Price',
            'Currency',
            'Status',
            'User Name',
            'Created At',
            'Updated At',
        ];
    }

 public function map($purchaseOrder): array
    {
        $mappedData = [];

        // Periksa apakah detailorder ada dan tidak kosong
        if ($purchaseOrder->detailorder && $purchaseOrder->detailorder->isNotEmpty()) {
            // Jika ada detailorder, lakukan pemetaan untuk setiap item
            foreach ($purchaseOrder->detailorder as $detail) {
                $mataUang = '';
                if ($purchaseOrder->supplier->remark == 'Local' || $purchaseOrder->supplier->remark == 'Lokal') {
                    $mataUang = 'IDR'; // For lokal suppliers
                } elseif ($purchaseOrder->supplier->remark == 'Import') {
                    $mataUang = 'USD'; // For import suppliers
                }

                $mappedData[] = [
                    $purchaseOrder->id,
                    $purchaseOrder->purchase_order_no,
                    $purchaseOrder->purchaseRequest->purchase_request_no ?? 'N/A',
                    $purchaseOrder->supplier->supplier_name ?? 'N/A',
                    $purchaseOrder->supplier->remark ?? 'N/A',
                    $purchaseOrder->date_in_house ?? 'N/A',
                    $purchaseOrder->purchaseRequest->mo ?? 'N/A',
                    $purchaseOrder->purchaseRequest->style ?? 'N/A',
                    $detail->item->category->name ?? 'N/A',
                    $detail->item->item_code ?? 'N/A',
                    $detail->item->item_name ?? 'N/A',
                    $detail->item->unit->unit_code ?? 'N/A',
                    $detail->color ?? 'N/A',
                    $detail->size ?? 'N/A',
                    $detail->qty ?? 'N/A',
                    $detail->price ?? 'N/A',
                    $detail->total_price ?? 'N/A',
                    $mataUang ?? 'N/A',
                    $detail->status ?? 'N/A',
                    $purchaseOrder->user->name ?? 'N/A',
                    $purchaseOrder->created_at ?? 'N/A',
                    $purchaseOrder->updated_at ?? 'N/A',
                ];
            }
        } else {
            // Jika tidak ada detailorder, tampilkan N/A untuk semua item terkait
            $mappedData[] = [
                $purchaseOrder->id,
                $purchaseOrder->purchase_order_no,
                $purchaseOrder->purchaseRequest->purchase_request_no ?? 'N/A',
                $purchaseOrder->supplier->supplier_name ?? 'N/A',
                $purchaseOrder->supplier->remark ?? 'N/A',
                $purchaseOrder->date_in_house ?? 'N/A',
                $purchaseOrder->purchaseRequest->mo ?? 'N/A',
                $purchaseOrder->purchaseRequest->style ?? 'N/A',
                'N/A', // Category
                'N/A', // Item Code
                'N/A', // Item Name
                'N/A', // Unit
                'N/A', // Color
                'N/A', // Size
                'N/A', // Quantity
                'N/A', // Price
                'N/A', // Total Price
                'N/A', // Currency
                'N/A', // Status
                $purchaseOrder->user->name ?? 'N/A',
                $purchaseOrder->created_at ?? 'N/A',
                $purchaseOrder->updated_at ?? 'N/A',
            ];
        }

        return $mappedData;
    }
}