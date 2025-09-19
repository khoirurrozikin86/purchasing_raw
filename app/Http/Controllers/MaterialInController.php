<?php

namespace App\Http\Controllers;

use App\Models\MaterialIn;
use App\Models\MaterialInDetail;
use Illuminate\Http\Request;
use App\Imports\MaterialInImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\PurchaseRequest;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrder;
use App\Exports\MaterialInWithDetailsExport;
use App\Exports\MaterialInExport;
use Carbon\Carbon;

class MaterialInController extends Controller
{
    public function Allmaterialin()
    {
        return view('material_in.all_materialin
        ');
    }

    public function Allmaterialindetail()
    {
        return view('material_in.all_materialindetail
        ');
    }
 

    public function Addmaterialin()
    {
        return view('material_in.add_materialin
        ');
    }

    public function Addmaterialinsp()
    {
        return view('material_in.add_materialinsp
        ');
    }


    public function Importmaterialin(Request $request){

        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,csv'
        ]);

        $file = $request->file('import_file');

        $import = new MaterialInImport;
        Excel::import($import, $file);

        if (!$import->isHeaderValid()) {
            return response()->json(['error' => 'Invalid header.'], 400);
        }

        // Convert the data to array for JSON response
        $data = $import->getData()->toArray();

        return response()->json([
            'header' => $import->expectedHeader,
            'rows' => $data
        ]);
 
    }
 

    public function Getmaterialin(Request $request)
{
    if ($request->ajax()) {
        $query = MaterialIn::with(['details', 'details.item.unit', 'details.purchaseOrder.purchaseRequest', 'supplier']);

       // Menambahkan filter berdasarkan tanggal startDate dan endDate
       if ($request->has('startDate') && $request->has('endDate')) {
        // Mengonversi startDate dan endDate menjadi format Carbon (startOfDay dan endOfDay)
        $startDate = Carbon::parse($request->startDate)->startOfDay();
        $endDate = Carbon::parse($request->endDate)->endOfDay();

        // Menambahkan filter tanggal pada query
        $query->whereRaw("STR_TO_DATE(remark, '%Y-%m-%d') BETWEEN ? AND ?", [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
    }

    // Mengambil data berdasarkan query
    $data = $query->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('supplier_name', function ($row) {
                return $row->supplier->supplier_name ?? '';
            })
            ->addColumn('item_details', function ($row) {
                $itemDetails = [];
                foreach ($row->details as $detail) {
                    $itemName = strlen($detail->item->item_name) > 25 ? 
                                substr($detail->item->item_name, 0, 25) . '...' : 
                                $detail->item->item_name;

                    $itemDetails[] = [
                        'item_code' => $detail->item->item_code,
                        'item_name' => $itemName,
                        'unit_code' => $detail->item->unit->unit_code ?? '',
                        'color' => $detail->color_name ?? '',
                        'size' => $detail->size ?? '',
                        'batch' => $detail->batch ?? '',
                        'no_roll' => $detail->no_roll ?? '',
                        'purchase_order_id' => $detail->purchase_order_id ?? '',
                        'mo' => $detail->purchaseOrder->purchaseRequest->mo ?? '',
                        'qty' => $detail->qty,
                        'remark' => $detail->remark ?? '',
                    ];
                }
                return $itemDetails;
            })
            ->addColumn('action', function ($row) {
                $hasStatus = $row->details->contains(function ($detail) {
                    return !empty($detail->status);
                });

                $editButton = $hasStatus ? 
                    '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Edit</a>' : 
                    '<a href="/edit/materialin/' . $row->id . '" class="dropdown-item text-primary"> &nbsp; Edit</a>';

                $deleteButton = $hasStatus ? 
                    '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                    '<a href="javascript:void(0)" class="dropdown-item text-danger deleteMaterialin" data-id="' . $row->id . '"> &nbsp; Delete</a>';

                return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="actions dropdown">
                                        <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                        <div class="dropdown-menu" role="menu">
                                            ' . $editButton . '
                                            ' . $deleteButton . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            })
            ->rawColumns(['purchase_order_no', 'action'])
            ->make(true);
    }
}


    public function Getmaterialin0(Request $request)
    {
        if ($request->ajax()) {
            $data = MaterialIn::with(['details', 'details.item.unit', 'details.purchaseOrder.purchaseRequest', 'supplier'])
                ->get();
    
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('supplier_name', function($row) {
                    return $row->supplier->supplier_name ?? '';
                })
                ->addColumn('item_details', function($row) {
                    $itemDetails = [];
                    foreach ($row->details as $detail) {
                        $itemName = strlen($detail->item->item_name) > 25 ? 
                                    substr($detail->item->item_name, 0, 25) . '...' : 
                                    $detail->item->item_name;
    
                        $itemDetails[] = [
                            'item_code' => $detail->item->item_code,
                            'item_name' =>  $itemName,
                            'unit_code' => $detail->item->unit->unit_code ?? '',
                            'color' => $detail->color_name ?? '',
                            'size' => $detail->size ?? '',
                            'batch' =>  $detail->batch?? '',
                            'no_roll' =>  $detail->no_roll?? '',
                            'purchase_order_id' =>  $detail->purchase_order_id?? '',
                            'mo' =>  $detail->purchaseOrder->purchaseRequest->mo?? '',
                            'qty' => $detail->qty,
                            'remark' => $detail->remark ?? '',
                        ];
                    }
                    return $itemDetails;
                }) 
             
                ->addColumn('action', function ($row) {
                    $hasStatus = $row->details->contains(function ($detail) {
                        return !empty($detail->status);
                    });
    
                    $editButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Edit</a>' : 
                        '<a href="/edit/materialin/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';
    
                    $deleteButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                        '<a href="javascript:void(0)" class="dropdown-item text-danger deleteMaterialin" data-id="' . $row->id . '"> &nbsp; Delete</a>';
    
                    return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                              <div class="d-flex align-items-center">
                                  <div class="d-flex align-items-center">
                                      <div class="actions dropdown">
                                          <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                          <div class="dropdown-menu" role="menu">
                                              ' . $editButton . '
                                              ' . $deleteButton . '
                                             
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>';
                })
                ->rawColumns(['purchase_order_no', 'action'])
                ->make(true);
        }
    }


    public function Getmaterialincount(){
        $in = MaterialIn::count();

        return response()->json([
            'request' => $in,
         
        ]);
    }



    public function Getmaterialin_old1(Request $request)
    {
        if ($request->ajax()) {
            $query = MaterialIn::with(['details', 'details.item.unit', 'details.purchaseOrder.purchaseRequest']);

            // Apply date range filter if both dates are provided
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('item_details', function($row) {
                    $itemDetails = [];
                    foreach ($row->details as $detail) {
                        $itemName = strlen($detail->item->item_name) > 25 ? 
                                    substr($detail->item->item_name, 0, 25) . '...' : 
                                    $detail->item->item_name;

                        $itemDetails[] = [
                            'original_no' => $detail->original_no ?? '',
                            'item_code' => $detail->item->item_code,
                            'supplier_name' => $detail->supplier_name ?? '', 
                            'item_name' =>  $itemName,
                            'unit_code' => $detail->item->unit->unit_code ?? '',
                            'color_code' => $detail->color_code ?? '', 
                            'color_name' => $detail->color_name ?? '', 
                            'size' => $detail->size ?? '',
                            'batch' =>  $detail->batch?? '',
                            'roll' =>  $detail->roll?? '',
                            'mo' =>  $detail->mo?? '',
                            'qty' => $detail->qty,
                            'actual_weight' => $detail->actual_weight ?? '',
                            'rak' => $detail->rak,
                        ];
                    }
                    return $itemDetails;
                })
                ->addColumn('action', function ($row) {
                    $hasStatus = $row->details->contains(function ($detail) {
                        return !empty($detail->status);
                    });

                    $editButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Edit</a>' : 
                        '<a href="/edit/materialin/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';

                    $deleteButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                        '<a href="javascript:void(0)" class="dropdown-item text-danger deleteMaterialin" data-id="' . $row->id . '"> &nbsp; Delete</a>';

                    return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                              <div class="d-flex align-items-center">
                                  <div class="d-flex align-items-center">
                                      <div class="actions dropdown">
                                          <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                          <div class="dropdown-menu" role="menu">
                                              ' . $editButton . '
                                              ' . $deleteButton . '
                                             
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

 

    public function Getmaterialindetail(Request $request)
    {
        if ($request->ajax()) {
            $query = MaterialInDetail::with(['materialIn', 'item.unit']);
    
            // Filter by date range
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->startDate;
                $endDate = $request->endDate;
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
    
            $data = $query->get();          
    
            return datatables()->of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }



       

 




    public function Storematerialinsp(Request $request)
    {


        // Generate material_in_no
$yearMonth = date('Ym');
$lastMaterialIn = MaterialIn::where('material_in_no', 'like', 'IN' . $yearMonth . '%')
    ->orderBy('material_in_no', 'desc')
    ->first();

if ($lastMaterialIn) {
    // Ambil nomor terakhir dan tambahkan 1
    $lastNumber = substr($lastMaterialIn->material_in_no, -6);
    $newNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
} else {
    // Jika belum ada, mulai dari '000001'
    $newNumber = '000001';
}

// Generate material_in_no dengan nomor urut yang baru
$materialInNo = 'IN' . $yearMonth . $newNumber;


   
       // Validate the request data
       $request->validate([
           'supplier_id' => 'required|integer',
           'no_sj' => 'required|string',
           'recived_by' => 'required|string',
           'location' => 'required|string',
           'courier' => 'required|string',
           'remark' => 'nullable|string',
           'details' => 'required|array',
           'details.*.po_id' => 'required',
           'details.*.item_id' => 'required',
           'details.*.qty' => 'required',
       ]);
   
       // Create a new MaterialIn record
       $materialIn = MaterialIn::create([
           'material_in_no' => $materialInNo,
           'supplier_id' => $request->supplier_id,
           'no_sj' => $request->no_sj,
           'received_by' => $request->recived_by,
           'location' => $request->location,
           'courier' => $request->courier,
           'remark' => $request->date_in,
           'user_id' => Auth::id(),
       ]);
   
       // Store purchase order details in MaterialInDetail
       foreach ($request->details as $detail) {
           MaterialInDetail::create([
               'material_in_id' => $materialIn->id,
               'purchase_order_id' => $detail['po_id'],
               'original_no' => '',
               'item_code' => $detail['item_code'],
               'color_code' => $detail['color'],
               'color_name' => $detail['color'],
               'size' => $detail['size'],
               'qty' => $detail['qty'],
               'po' => $detail['item_id'],
           ]);
   
           // Update status of Purchase Order details to 'received'
           PurchaseOrderDetail::where('purchase_order_id', $detail['po_id'])
               ->where('item_id', $detail['item_id'])
               ->where('color', $detail['color'])
               ->where('size', $detail['size'])
               ->update(['status' => 'received']);
       }
   
       // Redirect to 'all.materialin' route with success message
       return redirect()->route('all.materialin')
                        ->with('message', 'Data Berhasil Disimpan!');
    }





    public function Deletematerialin(Request $request, $id)
    {
     
        try {
            if ($request->has('detail_id')) {
             
                $detail = MaterialInDetail::with(['item'])->findOrFail($request->input('detail_id'));
    
                PurchaseOrderDetail::where('purchase_order_id', $detail->purchase_order_id)
                ->where('item_id', $detail->item->item_id)
                ->where('size', $detail->size)
                ->where('color', $detail->color_code)
                ->update(['status' => null]); 
    
                $detail->delete(); 
    
              
                return response()->json([
                    'message' => true,
                    'message' => 'Detail berhasil dihapus!',
                ]);
            } else {
                // Hapus MaterialIn beserta detailnya
                $material_in = MaterialIn::with(['details.item'])->findOrFail($id);
    
                // Mengembalikan status item menjadi kosong di PurchaseOrderDetail untuk setiap detail
                foreach ($material_in->details as $detail) {
             
                    PurchaseOrderDetail::where('purchase_order_id', $detail->purchase_order_id)
                    ->where('item_id', $detail->po)  // Use item_code instead of item_id
                    ->where('color', $detail->color_code)
                    ->where('size', $detail->size)
                    ->update(['status' => null]);
    
                }
    
                $material_in->details()->delete();
                $material_in->delete();
    
            
                return response()->json([
                    'message' => true,
                    'message' => 'Material In dan detail berhasil dihapus!',
                ]);
            }
        } catch (\Exception $e) {
     
            return response()->json([
                'message' => false,
                'message' => 'Terjadi kesalahan saat menghapus: ' . $e->getMessage(),
            ]);
        }
    }


    public function EditMaterialin($id){

         // Fetch the Purchase Order with details, supplier
    $materialIN = Materialin::with(['details.item.unit', 'supplier', 'details.purchaseOrder.purchaseRequest'])->findOrFail($id);


    return view('material_in.edit_materialin', compact('materialIN'));


    }


    public function Updatematerialin(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'supplier_id' => 'required|integer',
            'no_sj' => 'required|string',
            'recived_by' => 'required|string',
            'location' => 'required|string',
            'courier' => 'required|string',
            'remark' => 'nullable|string',
            'details.*.item_code' => 'required',
            // 'details.*.roll' => 'required|numeric',
            // 'details.*.qty' => 'required|numeric',
            // Tambahkan validasi tambahan jika diperlukan
        ]);

        // Update data MaterialIn
        $materialIn = MaterialIn::findOrFail($id);
        $materialIn->update([
            'supplier_id' => $request->supplier_id,
            'no_sj' => $request->no_sj,
            'received_by' => $request->recived_by,
            'location' => $request->location,
            'courier' => $request->courier,
            'remark' => $request->date_in,
            'user_id' => Auth::id(), // Memperbarui user_id jika diperlukan
        ]);

        // Hapus detail yang ada sebelumnya
        MaterialInDetail::where('material_in_id', $id)->delete();

        // Simpan detail yang baru
        foreach ($request->details as $detail) {
            MaterialInDetail::create([
                'material_in_id' => $materialIn->id,
                'purchase_order_id' =>  $detail['po_id'], // Kosong jika tidak digunakan
                'original_no' =>  $detail['original_no'] ?? null,
                'receive_date' => $detail['receive_date'] ?? null,
                'supplier_name' => $detail['supplier_name'] ?? null,
                'item_code' => $detail['item_code'],
                'po' => $detail['item_id'] ?? null,
                'color_code' => $detail['color'] ?? null,
                'color_name' => $detail['color'] ?? null,
                'size' => $detail['size'] ?? null,
                'batch' => $detail['batch'] ?? null,
                'roll' => 0,
                'gross_weight' => $detail['gross_weight'] ?? null,
                'net_weight' => $detail['net_weight'] ?? null,
                'qty' => $detail['qty'],
                'basic_width' => $detail['basic_width'] ?? null,
                'basic_grm' => $detail['basic_grm'] ?? null,
                'mo' => $detail['mo'] ?? null,
                'actual_weight' => $detail['actual_weight'] ?? null,
                'rak' => $detail['rak'] ?? null,
                'note' => '',
            ]);
        }

        return redirect()->route('all.materialin')->with('message', 'Material IN berhasil diperbarui.');
    }
 


    public function exportMaterialInxx(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new MaterialInWithDetailsExport($startDate, $endDate), 'material_in_' . $startDate . '_to_' . $endDate . '.xlsx');
    }



    public function Exportmaterialin(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        // Konversi tanggal ke format Carbon untuk filter
        $startDate = Carbon::parse($request->startDate)->startOfDay();
        $endDate = Carbon::parse($request->endDate)->endOfDay();

        // Ekspor file Excel
        return Excel::download(new MaterialInExport($startDate, $endDate), 'MaterialIn_' . now()->format('Ymd_His') . '.xlsx');
    }



    public function Getmaterialinoriginal($original_no){

        $qrcode = MaterialInDetail::with('uStockSumOri')->where('original_no', $original_no)->first();
        if ($qrcode) {
            return response()->json([
                'material_in_detail' => $qrcode,
                'stock' => $qrcode->uStockSumOri
            ]);
        } else {
            return response()->json(['message' => 'No data found'], 404);
        }

         

    }


 


       

}
