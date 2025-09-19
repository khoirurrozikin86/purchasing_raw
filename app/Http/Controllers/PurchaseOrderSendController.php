<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderSend;
use Illuminate\Http\Request; 
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use App\Exports\PurchaseOrderSendExport;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseOrderSendController extends Controller
{
    // Menampilkan semua data PurchaseOrderSend
    public function Allpurchaseordersend()
    {
        return view('purchase_order_send.all_purchaseordersend');
    }


    public function Addpurchaseordersend()
    {
        return view('purchase_order_send.add_purchaseordersend');
    }


    public function Storepurchaseordersend(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'purchase_order_no' => 'required|string|exists:purchase_orders,purchase_order_no|unique:purchase_order_sends,purchase_order_no',
            'status' => 'nullable|string',
            'remark' => 'nullable|string',
        ]);
    
        // Simpan PurchaseOrderSend
        $purchaseOrderSend = new PurchaseOrderSend();
        $purchaseOrderSend->purchase_order_no = $validated['purchase_order_no'];
        $purchaseOrderSend->status = $validated['status'] ?? 'sent'; // default status
        $purchaseOrderSend->remark = $validated['remark'] ?? null;
        $purchaseOrderSend->save();
    
        // Ambil PurchaseOrder beserta relasi detailorder dan item
        $purchaseOrder = PurchaseOrder::with('detailorder.item', 'supplier')->where('purchase_order_no', $validated['purchase_order_no'])->first();
    
        // Jika PurchaseOrder tidak ditemukan, kirim respons gagal
        if (!$purchaseOrder) {
            return response()->json([ 
                'success' => false,
                'message' => 'Purchase Order not found',
            ]);
        }
    
      // Update the status of the PurchaseOrder to "sent"
        $purchaseOrder->remarksx = 'sent';
        $purchaseOrder->save();
    
        // Kirimkan data yang baru disimpan beserta detailnya
        return response()->json([
            'success' => true,
            'message' => 'Purchase Order sent successfully',
            'purchaseOrderSend' => $purchaseOrderSend,
            'purchaseOrderDetails' => $purchaseOrder->detailorder,
            'supplier' => $purchaseOrder->supplier, // Mengirimkan informasi supplier
        ]);
    }

public function Getpurchaseordersend(Request $request){

    if ($request->ajax()) {
        // Query untuk mengambil PurchaseOrderSend dengan relasi yang diperlukan
        $query = PurchaseOrderSend::with([
            'purchaseOrder.purchaseRequest',
            'purchaseOrder.supplier',
            'purchaseOrder.detailorder.item.unit',
            'purchaseOrder.detailorder.item.category'
        ])
        ->orderBy('id', 'desc');
      $query->limit(50);

     

        // Ambil data sesuai query
        $data = $query->get();

        // Mengembalikan response dalam format DataTables
        return datatables()->of($data)
            ->addIndexColumn()

            // Supplier Name
            ->addColumn('supplier_name', function($row) {
                return $row->purchaseOrder->supplier->supplier_name ?? 'N/A';
            })

            ->addColumn('date_in_house', function($row) {
                return $row->purchaseOrder->date_in_house ?? 'N/A';
            })
            

            // Supplier Remark
            ->addColumn('supplier_remark', function($row) {
                return $row->purchaseOrder->supplier->remark ?? '';
            })

            // Item Details
            ->addColumn('item_details', function($row) {
                $itemDetails = [];
                foreach ($row->purchaseOrder->detailorder as $detail) {
                  $itemName = !empty($detail->item->item_name) ? 
                    (strlen($detail->item->item_name) > 25 ? 
                        substr($detail->item->item_name, 0, 25) . '...' : 
                        $detail->item->item_name) : 
                    '-';

                       // Cek jika item_code kosong, tampilkan '-'
        $itemCode = !empty($detail->item->item_code) ? 
                    (strlen($detail->item->item_code) > 25 ? 
                        substr($detail->item->item_code, 0, 25) . '...' : 
                        $detail->item->item_code) : 
                    '-';

                    $itemDetails[] = [
                        'category' => $detail->item->category->name ?? '',
                        'item_code' => $itemCode,
                        'item_name' => $itemName,
                        'unit_code' => $detail->item->unit->unit_code ?? '',
                        'color' => $detail->color ?? '',
                        'size' => $detail->size ?? '',  
                        'qty' => $detail->qty,
                        'price' => $detail->price,
                        'status' => $detail->status,
                    ];
                }
                return $itemDetails;
            })

            // Purchase Request No
            ->addColumn('purchase_request_no', function($row) {
                return $row->purchaseOrder->purchaseRequest->purchase_request_no ?? 'N/A';
            })

            // MO / Style
     ->addColumn('mo', function($row) {
    $mo = isset($row->purchaseOrder->purchaseRequest) ? $row->purchaseOrder->purchaseRequest->mo : '';
    $style = isset($row->purchaseOrder->purchaseRequest) ? $row->purchaseOrder->purchaseRequest->style : '';
    
    // Jika mo atau style kosong, maka return string kosong
    return ($mo ? $mo : '') . ' | ' . ($style ? $style : '');
})


            // Action Buttons (Edit, Delete, View PDF)
            ->addColumn('action', function($row) {
           
 
            

                $deleteButton = '<a href="javascript:void(0)" class="dropdown-item text-danger deletePurchaseOrderSend" data-id="' . $row->id . '"> &nbsp; Delete</a>';

                return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                          <div class="d-flex align-items-center">
                              <div class="d-flex align-items-center">
                                  <div class="actions dropdown">
                                      <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                      <div class="dropdown-menu" role="menu">
                                      
                                          ' . $deleteButton . '
                                       
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>';
            })

            // Raw Columns (to enable HTML in specific columns)
            ->rawColumns(['purchase_request_no','action'])
            ->make(true);
    }



}



    public function Getpurchaseordersendxxx(){

    // $today = Carbon::today();
    
     // Fetch PurchaseOrderSend with related PurchaseOrder, PurchaseRequest, Supplier, and User data
     $purchaseOrderSends = PurchaseOrderSend::with(['purchaseOrder.purchaseRequest','purchaseOrder.supplier','purchaseOrder.detailorder.item.unit','purchaseOrder.detailorder.item.category'])
    //  ->whereDate('created_at', $today)
     ->orderBy('created_at', 'desc')
     ->limit(10)
     ->get(); 


      

    return response()->json($purchaseOrderSends);
    }








    public function Deletepurchaseordersend(Request $request)
    {
        // Validasi apakah ID yang diterima ada
   

        try {
             // Cari purchase order berdasarkan ID
            $purchaseOrderSend = PurchaseOrderSend::findOrFail($request->id);

            // Find the related PurchaseOrder based on the purchase_order_no
            $purchaseOrder = PurchaseOrder::where('purchase_order_no', $purchaseOrderSend->purchase_order_no)->first();

            // Delete the PurchaseOrderSend record
            $purchaseOrderSend->delete();

            // If related PurchaseOrder exists, set its status to null
            if ($purchaseOrder) {
                $purchaseOrder->remarksx = null;
                $purchaseOrder->save();
            }
            // Jika penghapusan sukses, kembalikan response sukses
            return response()->json(['success' => true, 'message' => 'Purchase Order Send berhasil dihapus.']);
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan response error
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus Purchase Order Send.'], 500);
        }
    }


	 public function Getpurchaseordersendall(Request $request)
    {
        if ($request->ajax()) {
            // Query untuk mengambil PurchaseOrderSend dengan relasi yang diperlukan
            $query = PurchaseOrderSend::with([
                'purchaseOrder.purchaseRequest',
                'purchaseOrder.supplier',
                'purchaseOrder.detailorder.item.unit',
                'purchaseOrder.detailorder.item.category'
            ])
            ->orderBy('id', 'desc');
    
            // Filter berdasarkan startDate dan endDate
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->startDate;
                $endDate = $request->endDate;
    
                // Filter tanggal pada kolom created_at (atau sesuaikan dengan kolom yang relevan)
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
    
            // Ambil data sesuai query
            $data = $query->get();
    
            // Mengembalikan response dalam format DataTables
            return datatables()->of($data)
                ->addIndexColumn()
    
                // Supplier Name
                ->addColumn('supplier_name', function($row) {
                    return $row->purchaseOrder->supplier->supplier_name ?? 'N/A';
                })

                ->addColumn('date_in_house', function($row) {
                    return $row->purchaseOrder->date_in_house ?? 'N/A';
                })
                
    
                // Supplier Remark
                ->addColumn('supplier_remark', function($row) {
                    return $row->purchaseOrder->supplier->remark ?? '';
                })
    
                // Item Details
               // Item Details
            ->addColumn('item_details', function($row) {
                $itemDetails = [];

                // Pastikan purchaseOrder dan detailorder tidak null
                if ($row->purchaseOrder && $row->purchaseOrder->detailorder) {
                    foreach ($row->purchaseOrder->detailorder as $detail) {
                        $itemName = strlen($detail->item->item_name) > 25 ? 
                                    substr($detail->item->item_name, 0, 25) . '...' : 
                                    $detail->item->item_name;

                        $itemCode = strlen($detail->item->item_code) > 25 ? 
                                    substr($detail->item->item_code, 0, 25) . '...' : 
                                    $detail->item->item_code;

                        $itemDetails[] = [
                            'category' => $detail->item->category->name ?? '',
                            'item_code' => $itemCode,
                            'item_name' => $itemName,
                            'unit_code' => $detail->item->unit->unit_code ?? '',
                            'color' => $detail->color ?? '',
                            'size' => $detail->size ?? '',  
                            'qty' => $detail->qty,
                            'price' => $detail->price,
                            'status' => $detail->status,
                        ];
                    }
                }
                
                // Jika tidak ada item details, kembalikan array kosong
                return !empty($itemDetails) ? $itemDetails : [];
            })

    
                // Purchase Request No
                ->addColumn('purchase_request_no', function($row) {
                    return $row->purchaseOrder->purchaseRequest->purchase_request_no ?? 'N/A';
                })
    
->addColumn('mo', function($row) {
    $mo = isset($row->purchaseOrder->purchaseRequest) ? $row->purchaseOrder->purchaseRequest->mo : '';
    $style = isset($row->purchaseOrder->purchaseRequest) ? $row->purchaseOrder->purchaseRequest->style : '';
    
    // Jika mo atau style kosong, maka return string kosong
    return ($mo ? $mo : '') . ' | ' . ($style ? $style : '');
})

    
               
    
                // Action Buttons (Edit, Delete, View PDF)
                ->addColumn('action', function($row) {
               
     
                
    
                    $deleteButton = '<a href="javascript:void(0)" class="dropdown-item text-danger deletePurchaseOrderSend" data-id="' . $row->id . '"> &nbsp; Delete</a>';
    
                    return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                              <div class="d-flex align-items-center">
                                  <div class="d-flex align-items-center">
                                      <div class="actions dropdown">
                                          <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                          <div class="dropdown-menu" role="menu">
                                          
                                              ' . $deleteButton . '
                                           
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>';
                })
    
                // Raw Columns (to enable HTML in specific columns)
                ->rawColumns(['purchase_request_no','action'])
                ->make(true);
        }
    }
    


    public function Getpurchaseordersendallx(Request $request)
    {
        // Ambil startDate dan endDate dari request
        $startDate = $request->startDate;
        $endDate = $request->endDate;
    
        try {
            // Query untuk mengambil PurchaseOrderSend dengan relasi yang diperlukan
            $query = PurchaseOrderSend::with([
                'purchaseOrder.purchaseRequest',
                'purchaseOrder.supplier',
                'purchaseOrder.detailorder.item.unit',
                'purchaseOrder.detailorder.item.category'
            ])
            ->orderBy('created_at', 'desc');
    
            // Jika startDate dan endDate ada, filter berdasarkan rentang tanggal
            if ($startDate && $endDate) {
                // Pastikan format tanggal sesuai dengan yang ada di database (Y-m-d)
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
    
            // Ambil data sesuai limit yang diinginkan
            $purchaseOrderSends = $query->get(); // Jangan gunakan limit(10) jika ingin mengambil semua data yang relevan
    
            // Mengembalikan response dalam format JSON
            return response()->json($purchaseOrderSends);
    
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan response error
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengambil data Purchase Orders.'], 500);
        }
    }

    public function Exportpurchaseordersend(Request $request)
    {
        // Ambil tanggal dari request (misalnya dari form)
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Validasi input tanggal
        if (!$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Start date and end date are required!');
        }

        // Pastikan endDate lebih besar atau sama dengan startDate
        if (new \DateTime($startDate) > new \DateTime($endDate)) {
            return redirect()->back()->with('error', 'End date must be greater than or equal to start date!');
        }

        // Ekspor data ke Excel
        return Excel::download(new PurchaseOrderSendExport($startDate, $endDate), 'purchase_orders_send.xlsx');
    }

    public function Getpurchaseordersendcount() {

        $requestCount = PurchaseOrderSend::count();

        return response()->json([
            'request' => $requestCount,
         
        ]);
    }
 


   
}
