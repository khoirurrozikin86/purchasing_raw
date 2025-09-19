<?php

namespace App\Exports;

use App\Models\PurchaseOrderSend;
use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class PurchaseOrderSendExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();
    }

    // Menentukan data yang akan diekspor
    public function collection()
    {
        return PurchaseOrderSend::with([
            'purchaseOrder.purchaseRequest',
            'purchaseOrder.supplier',
            'purchaseOrder.detailorder.item.unit',
            'purchaseOrder.detailorder.item.category',
        ])->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
    }

    // Menentukan header untuk file Excel
    public function headings(): array
    {
        return [

            'ID PO SEND',
            'TIMW PO EMAIL DATE',
            'PO NO',
            'MAKE PO DATE',
            'STATUS',
            'REQUEST NO',
            'PPIC SENT PR TO PURCHASING DATE',
            'CBD ORDER NO',
            'CBD IMPORT DATE',
            'PO UQ',
            'PO UQ DATE',

            'MO',
            'SUPPLIER NAME',
            'SUPPLIER REMARK',
            'DATELINE IN HOUSE',

            'ITEM CATEGORY',
            'ITEM CODE',
            'ITEM NAME',
            'COLOR',
            'SIZE',
            'UNIT',
            'QTY',
            'PRICE',

        ];
    }

    // Menentukan data untuk setiap baris
    public function map($purchaseOrderSend): array
    {
        $data = [];

        // Cek jika purchaseOrderSend memiliki purchaseOrder dan detailorder
        $purchaseOrder = $purchaseOrderSend->purchaseOrder;

        if ($purchaseOrder && $purchaseOrder->detailorder && $purchaseOrder->detailorder->isNotEmpty()) {

            $cbdOrderNo = $purchaseOrder->purchaseRequest && $purchaseOrder->purchaseRequest->cbd
                ? $purchaseOrder->purchaseRequest->cbd->order_no
                : '-';

            $cbdOrderDATE = $purchaseOrder->purchaseRequest && $purchaseOrder->purchaseRequest->cbd
                ? $purchaseOrder->purchaseRequest->cbd->created_at
                : '-';

            // Ambil po_uq dan po_uq_date dari PurchaseOrderSend atau PurchaseOrder
            $poUq = $purchaseOrder->purchaseRequest && $purchaseOrder->purchaseRequest->cbd
                ? $purchaseOrder->purchaseRequest->cbd->po_uq
                : '-';
            $poUqDate = $purchaseOrder->purchaseRequest && $purchaseOrder->purchaseRequest->cbd
                ? $purchaseOrder->purchaseRequest->cbd->po_uq_date
                : '-';

            // Jika purchaseOrder dan detailorder ada dan tidak kosong
            foreach ($purchaseOrder->detailorder as $detail) {
                $data[] = [
                    'id_send_po' => $purchaseOrderSend->id ?? 'N/A',
                    'created_at' => $purchaseOrderSend->created_at ?? 'N/A',
                    'purchase_order_no' => $purchaseOrderSend->purchase_order_no ?? 'N/A',
                    'date_po' => $purchaseOrder->created_at ?? 'N/A',
                    'status' => $purchaseOrderSend->status ?? 'N/A',
                    'request_no' => $purchaseOrder->purchaseRequest ? $purchaseOrder->purchaseRequest->purchase_request_no : 'N/A',
                    'date_request' => $purchaseOrder->purchaseRequest->created_at ?? 'N/A',
                    'cbd_order_no' => $cbdOrderNo,
                    'cbd_order_date' => $cbdOrderDATE,
                    'po_uq' => $poUq, // Add PO UQ
                    'po_uq_date' => $poUqDate, // Add PO UQ Date
                    'mo_style' => $purchaseOrder->purchaseRequest ? $purchaseOrder->purchaseRequest->mo : 'N/A',
                    'supplier_name' => $purchaseOrder->supplier ? $purchaseOrder->supplier->supplier_name : 'N/A',
                    'supplier_remark' => $purchaseOrder->supplier ? $purchaseOrder->supplier->remark : 'N/A',
                    'date_in_house' => $purchaseOrder->date_in_house ?? 'N/A',
                    'category' => $detail->item->category ? $detail->item->category->name : 'N/A',
                    'item_code' => $detail->item->item_code ?? 'N/A',
                    'item_name' => $detail->item->item_name ?? 'N/A',
                    'color' => $detail->color ?? 'N/A',
                    'size' => $detail->size ?? 'N/A',
                    'unit' => $detail->item->unit ? $detail->item->unit->unit_name : 'N/A',
                    'quantity' => $detail->qty ?? 'N/A',
                    'price' => $detail->price ?? 'N/A',
                ];
            }
        } else {
            // Jika purchaseOrder atau detailorder kosong, tampilkan data dengan nilai 'N/A' untuk setiap kolom terkait item
            $data[] = [
                'id_send_po' => $purchaseOrderSend->id ?? 'N/A',
                'created_at' => $purchaseOrderSend->created_at ?? 'N/A',
                'purchase_order_no' => $purchaseOrderSend->purchase_order_no ?? 'N/A',
                'date_po' => $purchaseOrder ? $purchaseOrder->created_at : 'N/A',
                'status' => $purchaseOrderSend->status ?? 'N/A',
                'request_no' => $purchaseOrder && $purchaseOrder->purchaseRequest ? $purchaseOrder->purchaseRequest->purchase_request_no : 'N/A',
                'date_request' => $purchaseOrder && $purchaseOrder->purchaseRequest ? $purchaseOrder->purchaseRequest->created_at : 'N/A',
                'cbd_order_no' => $purchaseOrder && $purchaseOrder->purchaseRequest && $purchaseOrder->purchaseRequest->cbd
                    ? $purchaseOrder->purchaseRequest->cbd->order_no
                    : 'N/A', // Tambahan untuk CBD Order Number
                'cbd_order_date' => $cbdOrderDATE,
                'po_uq' => $poUq, // Add PO UQ
                'po_uq_date' => $poUqDate, // Add PO UQ Date
                'mo_style' => $purchaseOrder && $purchaseOrder->purchaseRequest ? $purchaseOrder->purchaseRequest->mo : 'N/A',
                'supplier_name' => $purchaseOrder && $purchaseOrder->supplier ? $purchaseOrder->supplier->supplier_name : 'N/A',
                'supplier_remark' => $purchaseOrder && $purchaseOrder->supplier ? $purchaseOrder->supplier->remark : 'N/A',
                'date_in_house' => $purchaseOrder ? $purchaseOrder->date_in_house : 'N/A',
                'category' => 'N/A',  // Isi N/A karena tidak ada detail
                'item_code' => 'N/A',  // Isi N/A karena tidak ada detail
                'item_name' => 'N/A',  // Isi N/A karena tidak ada detail
                'color' => 'N/A',  // Isi N/A karena tidak ada detail
                'size' => 'N/A',  // Isi N/A karena tidak ada detail
                'unit' => 'N/A',  // Isi N/A karena tidak ada detail
                'quantity' => 'N/A',  // Isi N/A karena tidak ada detail
                'price' => 'N/A',  // Isi N/A karena tidak ada detail
            ];
        }

        return $data;
    }
}
