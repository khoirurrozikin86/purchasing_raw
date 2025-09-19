<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use App\Models\Cbd;
use Carbon\Carbon;
use App\Exports\PurchaseRequestExport;
use PDF;
use Illuminate\Support\Facades\Log;


class PurchaseRequestController extends Controller
{
    public function Allpurchaserequest()
    {
        return view('purchase_request.all_purchaserequest');
    }

    public function Addpurchaserequest(){
        return view('purchase_request.add_purchaserequest');
    }

    public function Addpurchaserequestid($id){
     // Fetch the CBD by ID along with its details
     $cbd = Cbd::with('details')->findOrFail($id);

     // Extract size, color, and quantity data from CBD details
     $sizes = [];
     $colors = [];
     $qtyData = [];
 
     foreach ($cbd->details as $detail) {
         $sizes[$detail->size] = $detail->size;
         $colors[$detail->color] = $detail->color;
         $qtyData[$detail->size][$detail->color] = $detail->qty;
     }
 
     // Sort sizes and colors alphabetically
     sort($sizes);
     sort($colors);

     $cbdId = $cbd->id;
     $cbdno = $cbd->order_no;
     $year = $cbd->year;
     $planning_ssn = $cbd->planning_ssn;
     $planning_ssn = $cbd->planning_ssn;


        return view('purchase_request.add_purchaserequestid',compact('sizes', 'colors', 'qtyData', 'cbdId','cbdno','cbd'));
    }

    public function GetpurchaserequestCount(){
        $requestCount = PurchaseRequest::count();

        return response()->json([
            'request' => $requestCount,
         
        ]);
    }


    public function Getpurchaserequest(Request $request)
{
    if ($request->ajax()) {
        // Start with the base query
        $query = PurchaseRequest::with(['detailrequest.item.unit','cbd']);
        
        if ($request->has('startDate') && $request->has('endDate')) {
            $query->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')]);
        }

        $data = $query->get();
    
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $allDetailsPo = true;
                $hasStatus = false;
                
                foreach ($row->detailrequest as $detail) {
                    if ($detail->status !== 'po') {
                        $allDetailsPo = false;
                    }
                    if (!empty($detail->status)) {
                        $hasStatus = true;
                    }
                }

                $createPOButton = $allDetailsPo ? 
                    '' : 
                    '<a href="/add/purchaseorderid/'.$row->id.'" class="dropdown-item text-success"> &nbsp; Create Purchase Order</a>';
                
                $editButton = $hasStatus ? 
                    '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Edit</a>' : 
                    '<a href="/edit/purchaserequest/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';
                
                $deleteButton = $hasStatus ? 
                    '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                    '<a href="javascript:void(0)" class="dropdown-item text-danger deletePurchaserequest" data-id="' . $row->id . '"> &nbsp; Delete</a>';

                return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                          <div class="d-flex align-items-center">
                              <div class="d-flex align-items-center">
                                  <div class="actions dropdown">
                                      <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                      <div class="dropdown-menu" role="menu">
                                         
                                          <a href="/pdf/purchaserequest/'.$row->id.'" class="dropdown-item text-info" target="_blank"> &nbsp; View PDF</a>
                                          ' . $createPOButton . '
                                           ' . $editButton . '
                                          ' . $deleteButton . '
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>';
            })
            ->addColumn('order_no', function ($row) {
                return $row->cbd->order_no ?? '-';
            })
            ->addColumn('item_name', function ($row) {
                $details = '<ul>';
                foreach ($row->detailrequest as $detail) {
                    $itemName = strlen($detail->item->item_name) > 25 ? 
                                substr($detail->item->item_name, 0, 25) . '...' : 
                                $detail->item->item_name;
                    $details .= '<li>' . $itemName . '</li>';
                }
                $details .= '</ul>';
                return $details;
            })
            ->addColumn('color', function ($row) {
                $details = '<ul>';
                foreach ($row->detailrequest as $detail) {
                    if (!empty($detail->color)) {
                        $details .= '<li>' . $detail->color . '</li>';
                    }
                }
                $details .= '</ul>';
                if (trim($details) == '<ul></ul>') {
                    return '&nbsp;';
                }
                return $details;
            })
            ->addColumn('size', function ($row) {
                $details = '<ul>';
                foreach ($row->detailrequest as $detail) {
                    if (!empty($detail->size)) {
                        $details .= '<li>' . $detail->size . '</li>';
                    }
                }
                $details .= '</ul>';
                if (trim($details) == '<ul></ul>') {
                    return '&nbsp;';
                }
                return $details;
            })
            ->addColumn('unit', function ($row) {
                $details = '<ul>';
                foreach ($row->detailrequest as $detail) {
                    if (!empty($detail->item->unit->unit_code)) {
                        $details .= '<li>' . $detail->item->unit->unit_code . '</li>';
                    }
                }
                $details .= '</ul>';
                if (trim($details) == '<ul></ul>') {
                    return '&nbsp;';
                }
                return $details;
            })
            ->addColumn('total', function ($row) {
                $details = '<ul>';
                foreach ($row->detailrequest as $detail) {
                    $details .= '<li>' . $detail->total . '</li>';
                }
                $details .= '</ul>';
                return $details;
            })
            ->addColumn('remark', function ($row) {
                $details = '<ul>';
                foreach ($row->detailrequest as $detail) {
                    if (!empty($detail->remark)) {
                        $details .= '<li>' . $detail->remark . '</li>';
                    }
                }
                $details .= '</ul>';
                if (trim($details) == '<ul></ul>') {
                    $details = '<p class="text-center">-</p>';
                }
                return $details;
            })
            ->addColumn('status', function ($row) {
                $details = '<ul>';
                foreach ($row->detailrequest as $detail) {
                    if ($detail->status == 'po') {
                        $details .= '<li>' .'<span class="badge bg-success">'. $detail->status .'</span>'. '</li>';
                    }
                    else{
                        $details .= '<li>' .'<span class="badge bg-danger">'.'waiting'.'</span>' .'</li>';
                    }
                }
                if (trim($details) == '<ul></ul>') {
                    $details = '<p class="text-center">-</p>';
                }
                $details .= '</ul>';
                return $details;
            })
            ->rawColumns(['action', 'item_name', 'color', 'size','unit', 'total', 'remark', 'status'])
            ->make(true);
    }
}



    public function Getpurchaserequest0(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseRequest::with(['detailrequest.item.unit','cbd'])->get();
    
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $allDetailsPo = true;
                    $hasStatus = false;
                    
                    foreach ($row->detailrequest as $detail) {
                        if ($detail->status !== 'po') {
                            $allDetailsPo = false;
                        }
                        if (!empty($detail->status)) {
                            $hasStatus = true;
                        }
                    }
    
                    $createPOButton = $allDetailsPo ? 
                        '' : 
                        '<a href="/add/purchaseorderid/'.$row->id.'" class="dropdown-item text-success"> &nbsp; Create Purchase Order</a>';
                    
                    $editButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Edit</a>' : 
                        '<a href="/edit/purchaserequest/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';
                    
                    $deleteButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                        '<a href="javascript:void(0)" class="dropdown-item text-danger deletePurchaserequest" data-id="' . $row->id . '"> &nbsp; Delete</a>';
    
                    return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                              <div class="d-flex align-items-center">
                                  <div class="d-flex align-items-center">
                                      <div class="actions dropdown">
                                          <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                          <div class="dropdown-menu" role="menu">
                                             
                                              <a href="/pdf/purchaserequest/'.$row->id.'" class="dropdown-item text-info" target="_blank"> &nbsp; View PDF</a>
                                              ' . $createPOButton . '
                                               ' . $editButton . '
                                              ' . $deleteButton . '
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>';
                })
                ->addColumn('order_no', function ($row) {
                    return $row->cbd->order_no ?? '-';
                })
                
                ->addColumn('item_name', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        $itemName = strlen($detail->item->item_name) > 25 ? 
                                    substr($detail->item->item_name, 0, 25) . '...' : 
                                    $detail->item->item_name;
                        $details .= '<li>' . $itemName . '</li>';
                    }
                    $details .= '</ul>';
                    return $details;
                })
                ->addColumn('color', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if (!empty($detail->color)) {
                            $details .= '<li>' . $detail->color . '</li>';
                        }
                    }
                    $details .= '</ul>';
                    if (trim($details) == '<ul></ul>') {
                        return '&nbsp;';
                    }
                    return $details;
                })
                ->addColumn('size', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if (!empty($detail->size)) {
                            $details .= '<li>' . $detail->size . '</li>';
                        }
                    }
                    $details .= '</ul>';
                    if (trim($details) == '<ul></ul>') {
                        return '&nbsp;';
                    }
                    return $details;
                })
                ->addColumn('unit', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if (!empty($detail->item->unit->unit_code)) {
                            $details .= '<li>' . $detail->item->unit->unit_code . '</li>';
                        }
                    }
                    $details .= '</ul>';
                    if (trim($details) == '<ul></ul>') {
                        return '&nbsp;';
                    }
                    return $details;
                })
                ->addColumn('total', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        $details .= '<li>' . $detail->total . '</li>';
                    }
                    $details .= '</ul>';
                    return $details;
                })
                ->addColumn('remark', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if (!empty($detail->remark)) {
                            $details .= '<li>' . $detail->remark . '</li>';
                        }
                    }
                    $details .= '</ul>';
                    if (trim($details) == '<ul></ul>') {
                        $details = '<p class="text-center">-</p>';
                    }
                    return $details;
                })
                ->addColumn('status', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if ($detail->status == 'po') {
                            $details .= '<li>' .'<span class="badge bg-success">'. $detail->status .'</span>'. '</li>';
                        }
                        else{
                            $details .= '<li>' .'<span class="badge bg-danger">'.'waiting'.'</span>' .'</li>';
                        }
                    }
                    if (trim($details) == '<ul></ul>') {
                        $details = '<p class="text-center">-</p>';
                    }
                    $details .= '</ul>';
                    return $details;
                })
                ->rawColumns(['action', 'item_name', 'color', 'size','unit', 'total', 'remark', 'status'])
                ->make(true);
        }
    }
    




    
    public function Getpurchaserequest1(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseRequest::with('detailrequest.item.unit')->get();
    
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                              <div class="d-flex align-items-center">
                                  <div class="d-flex align-items-center">
                                      <div class="actions dropdown">
                                          <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                          <div class="dropdown-menu" role="menu">
                                           <a href="/edit/purchaserequest/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>
                                           <a href="javascript:void(0)" class="dropdown-item text-danger deletePurchaserequest" data-id="' . $row->id . '"> &nbsp; Delete</a>
                                           <a href="/pdf/purchaserequest/'.$row->id.'" class="dropdown-item text-info" target="_blank"> &nbsp; View PDF</a>
                                           <a href="/add/purchaseorderid/'.$row->id.'" class="dropdown-item text-success" target="_blank"> &nbsp; Create Purchase Order</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>';
                })
                ->addColumn('item_name', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        $details .= '<li>' . $detail->item->item_name . '</li>';
                    }
                    $details .= '</ul>';
                    return $details;
                })
                ->addColumn('color', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if (!empty($detail->color)) {
                            $details .= '<li>' . $detail->color . '</li>';
                        }
                    }
                    $details .= '</ul>';
                    if (empty($details)) {
                        return '&nbsp;';
                    }
                    return $details;
                })
                ->addColumn('size', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if (!empty($detail->size)) {
                            $details .= '<li>' . $detail->size . '</li>';
                        }
                    }
                    $details .= '</ul>';
                    if (empty($details)) {
                        return '&nbsp;';
                    }
                    return $details;
                })
                ->addColumn('unit', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if (!empty($detail->item->unit->unit_code)) {
                            $details .= '<li>' . $detail->item->unit->unit_code . '</li>';
                        }
                    }
                    $details .= '</ul>';
                    if (empty($details)) {
                        return '&nbsp;';
                    }
                    return $details;
                })
                ->addColumn('total', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        $details .= '<li>' . $detail->total . '</li>';
                    }
                    $details .= '</ul>';
                    return $details;
                })
                ->addColumn('remark', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if (!empty($detail->remark)) {
                            $details .= '<li>' . $detail->remark . '</li>';
                        }
                    }
                    $details .= '</ul>';
                    if (empty($details)) {
                        $details = '<p class="text-center">-</p>';
                    }
                    return $details;
                })
                ->addColumn('status', function ($row) {
                    $details = '<ul>';
                    foreach ($row->detailrequest as $detail) {
                        if ($detail->status) {
                            $details .= '<li class="badge bg-danger" >' . $detail->status . '</li>';
                        }
                    }
                    if (empty($details)) {
                        $details = '<p class="text-center"></p>';
                    }
                    $details .= '</ul>';
                    return $details;
                })
                ->rawColumns(['action', 'item_name', 'color', 'size','unit', 'total', 'remark', 'status'])
                ->make(true);
        }
    }

    private function generatePurchaseRequestNo()
    {
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $prefix = '/PR/PCH/' . $currentMonth . '/' . $currentYear;

        // Find the last purchase request of the current month and year
        $latestRequest = PurchaseRequest::whereYear('created_at', $currentYear)
                                         ->whereMonth('created_at', $currentMonth)
                                         ->orderBy('id', 'desc')
                                         ->first();

        $newNumber = 1;
        if ($latestRequest) {
            $lastNumber = (int) substr($latestRequest->purchase_request_no, 0, 4);
            $newNumber = $lastNumber + 1;
        }

        $newNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $newNumber . $prefix;
    }
    





    public function Storepurchaserequest(Request $request)
    {
        // Validasi input
        $request->validate([
            // 'cbd_id' => 'exists:cbds,id',
            'tipe' => 'required',
            'department' => 'required',
            'applicant' => 'required',
            'details.*.item_id' => 'required',
            'details.*.qty' => 'required|numeric',
            'details.*.total' => 'required|numeric',
        ]);


         // Generate Purchase Request Number
         $purchaseRequestNo = $this->generatePurchaseRequestNo();

        // Simpan Purchase Request
        $purchaseRequest = PurchaseRequest::create([
            'cbd_id' => $request->cbd_id,
            'tipe' => $request->tipe,
            'purchase_request_no' => $purchaseRequestNo,
            'department' => $request->department,
            'applicant' => $request->applicant,
            'mo' => $request->mo,
            'style' => $request->style,
            'destination' => $request->destination,
            'time_line' => $request->time_line,
            'remark1' => $request->remark1,
            'status' => '',
            'revision_no' => 0,
            'user_id' => Auth::id(),
        ]);

        // Simpan Detail Purchase Request
        if ($purchaseRequest) {
            foreach ($request->details as $detail) {
                PurchaseRequestDetail::create([
                    'purchase_request_id' => $purchaseRequest->id,
                    'item_id' => $detail['item_id'],
                    'supplier_id' => $detail['supplier_id'],
                    'color' => $detail['color'] ?? null,
                    'size' => $detail['size'] ?? null,
                    'qty' => $detail['qty'],
                    'consumtion' => $detail['consumption'] ?? null,
                    'allowance' => $detail['allowance'] ?? null,
                    'total' => $detail['total'],
                    'remark' => $detail['remark'] ?? null,
                    'status' => '',
                ]);
            }
        }

        return redirect()->route('all.purchaserequest')->with('message', 'Purchase Request berhasil disimpan.');
    }



    public function Editpurchaserequest($id)
    {
       // Ambil data Purchase Request berdasarkan ID
    $purchaseRequest = PurchaseRequest::with('detailrequest')->findOrFail($id);

    $sizes = [];
    $colors = [];
    $qtyData = [];
    $cbdId = null;
    $cbdno = null;

    // Periksa apakah ada CBD terkait
    if ($purchaseRequest->cbd_id) {
        // Ambil CBD berdasarkan ID bersama dengan detailnya
        $cbd = Cbd::with('details')->findOrFail($purchaseRequest->cbd_id);

        // Extract size, color, dan quantity data dari detail CBD
        if ($cbd->details) {
            foreach ($cbd->details as $detail) {
                $sizes[$detail->size] = $detail->size;
                $colors[$detail->color] = $detail->color;
                $qtyData[$detail->size][$detail->color] = $detail->qty;
            }
        }

        // Sort sizes dan colors secara alfabetis
        ksort($sizes);
        ksort($colors);

        // Ambil CBD ID dan nomor CBD
        $cbdId = $cbd->id;
        $cbdno = $cbd->order_no;
        
    }


    
    return view('purchase_request.edit_purchaserequest', compact('purchaseRequest', 'sizes', 'colors', 'qtyData', 'cbdId', 'cbdno'));
 

    }



    public function Updatepurchaserequest(Request $request, $id)
{
    // Validasi input
    $request->validate([
        // Sesuaikan dengan kebutuhan validasi
        'tipe' => 'required',
        'department' => 'required',
        'applicant' => 'required',
        'details.*.item_id' => 'required',
        'details.*.qty' => 'required|numeric',
        'details.*.total' => 'required|numeric',
    ]);

    // Log::info('Request Data:', $request->all());

    // Temukan Purchase Request berdasarkan ID
    $purchaseRequest = PurchaseRequest::findOrFail($id);

    // Periksa apakah pengguna memiliki izin untuk mengedit
    // if ($purchaseRequest->user_id !== Auth::id()) {
    //     return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit Purchase Request ini.');
    // }

     // Increment revision_no
     $purchaseRequest->increment('revision_no');

    // Update Purchase Request
    $purchaseRequest->update([
        'cbd_id' => $request->cbd_id,
        'tipe' => $request->tipe,
        'purchase_request_no' => $request->purchase_request_no,
        'department' => $request->department,
        'applicant' => $request->applicant,
        'mo' => $request->mo,
        'style' => $request->style,
        'destination' => $request->destination,
        'time_line' => $request->time_line,             
        'remark1' => $request->remark1,
        'status' => '',
        'user_id' => Auth::id(),
    ]);

   

    // Hapus semua detail terkait sebelum menambahkan yang baru
    $purchaseRequest->detailrequest()->delete();

    // Simpan Detail Purchase Request
    foreach ($request->details as $detail) {
        PurchaseRequestDetail::create([
            'purchase_request_id' => $purchaseRequest->id,
            'item_id' => $detail['item_id'],
            'supplier_id' => $detail['supplier_id'],
            'color' => $detail['color'] ?? null,
            'size' => $detail['size'] ?? null,
            'qty' => $detail['qty'],
            'consumtion' => $detail['consumption'] ?? null,
            'allowance' => $detail['allowance'] ?? null,
            'total' => $detail['total'],
            'remark' => $detail['remark'] ?? null,
            'status' => '',
        ]); 
    }

    return redirect()->route('all.purchaserequest')->with('message', 'Purchase Request berhasil diperbarui.');
}



public function Deletepurchaserequest(Request $request, $id)
{
    if ($request->has('detail_id')) {
        // Hapus detail berdasarkan ID detail
        $detail = PurchaseRequestDetail::findOrFail($request->input('detail_id'));
        $detail->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    } else {
        // Hapus Purchase Request beserta detailnya
        $purchaseRequest = PurchaseRequest::findOrFail($id);
        $purchaseRequest->detailrequest()->delete();
        $purchaseRequest->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }
} 

public function ExportPDF($id)
{
    // Ambil data PurchaseRequest beserta detail dan unit item
    $purchaseRequest = PurchaseRequest::with('detailrequest.item.unit')->findOrFail($id);

    // Ambil cbd_id dari PurchaseRequest
    $idx = $purchaseRequest->cbd_id;

    // Jika cbd_id ada, ambil data Cbd beserta details
    if ($idx) {
        $cbd = Cbd::with('details')->findOrFail($idx);

        $sizes = [];
        $colors = [];
        $qtyData = [];

        foreach ($cbd->details as $detail) {
            $sizes[$detail->size] = $detail->size;
            $colors[$detail->color] = $detail->color;
            $qtyData[$detail->size][$detail->color] = $detail->qty;
        }

        // Sort sizes and colors alphabetically
        sort($sizes);
        sort($colors);

        // Gunakan view 'print' dengan data lengkap
        $view = 'purchase_request.print';
        $data = compact('purchaseRequest', 'sizes', 'colors', 'qtyData');
    } else {
        // Jika cbd_id kosong, gunakan view 'print_support'
        $view = 'purchase_request.print_support';
        $data = compact('purchaseRequest');
    }

    // Buat PDF dari view yang dipilih dengan data yang sesuai
    $pdf = Pdf::loadView($view, $data);

    // Return stream PDF
    return $pdf->stream('purchase_request.pdf');
}


public function Getpurchaserequestsp(Request $request){

    $purchaseRequestId = $request->input('idx');

    $purchaseRequests = PurchaseRequest::with(['detailrequest.supplier'])
        ->where('id', $purchaseRequestId)
        ->get();

    // Extract and collect all suppliers
    $allSuppliers = collect();

    foreach ($purchaseRequests as $purchaseRequest) {
        foreach ($purchaseRequest->detailrequest as $detail) {
            $allSuppliers->push($detail->supplier);
        }
    }

    // Filter unique suppliers by their ID
    $uniqueSuppliers = $allSuppliers->unique('id')->values();

    return response()->json($uniqueSuppliers);

  
}

public function Getpurchaserequestitems(Request $request)
{
    $purchaseRequestId = $request->input('id1');
    $supplierId = $request->input('id2');

    $items =  PurchaseRequestDetail::where('purchase_request_id', $purchaseRequestId)
        ->where('supplier_id', $supplierId)
        ->where(function ($query) {
            $query->where('status', '')
                  ->orWhereNull('status');
        })
        ->with('item.unit', 'supplier')
        ->get();

    return response()->json($items);
}


public function Exportpurchaserequest(Request $request)
{
    // Validasi input tanggal
    $request->validate([
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
    ]);

    // Ambil data berdasarkan rentang tanggal
    $startDate = Carbon::parse($request->startDate)->startOfDay();
    $endDate = Carbon::parse($request->endDate)->endOfDay();

    // Nama file hasil export
    $fileName = 'PurchaseRequests_' . now()->format('Ymd_His') . '.xlsx';

    return Excel::download(new PurchaseRequestExport($startDate, $endDate), $fileName);
}




}
