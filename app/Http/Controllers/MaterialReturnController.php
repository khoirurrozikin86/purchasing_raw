<?php

namespace App\Http\Controllers;

use App\Models\MaterialReturn;
use App\Models\MaterialReturnDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\MaterialReturnDetailsExport;
use DataTables;

class MaterialReturnController extends Controller
{
    public function Allmaterialreturn()
    {
        return view('material_return.all_materialreturn');
    }

    
    public function Getmaterialreturn(Request $request)
    {
        if ($request->ajax()) {
            $query = MaterialReturn::with(['details.QRCode', 'details.item.unit']);

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
                            'supplier_name' => $detail->QRCode->supplier_name ?? '', 
                            'item_name' =>  $itemName,
                            'unit_code' => $detail->item->unit->unit_code ?? '',
                            'color_code' => $detail->color_code ?? '', 
                            'color_name' => $detail->color_name ?? '', 
                            'size' => $detail->size ?? '', 
                         
                            'qty' => $detail->qty,
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
                        '<a href="/edit/materialreturn/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';

                    $deleteButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                        '<a href="javascript:void(0)" class="dropdown-item text-danger deleteMaterialreturn" data-id="' . $row->id . '"> &nbsp; Delete</a>';

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



    public function Addmaterialreturn()
    {
        return view('material_return.add_materialreturn');
    }


    public function Storematerialreturn(Request $request)
    {
        
         // Validate the request data
         $request->validate([
            'department' => 'required|string',
            'person' => 'required|string',
           
            'details.*.item_code' => 'required',
            // 'details' => 'required|array',
          
        ]);

            // Generate material_return_no
        $yearMonth = date('Ym');
        $lastMaterialRT = MaterialReturn::where('material_return_no', 'like','RT'. $yearMonth . '%')
            ->orderBy('material_return_no', 'desc')
            ->first();

        if ($lastMaterialRT) {
            $lastNumber = substr($lastMaterialRT->material_return_no, -6);
            $newNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        $materialRTNo = 'RT' . $yearMonth . $newNumber;



        $materialRT = MaterialReturn::create([
            'material_return_no' =>$materialRTNo,
                 
            'department' => $request->department,
            'person' => $request->person,
            'remark' => $request->remark,
            // 'status' =>$request->status, 
            'user_id' =>Auth::id(),
        ]);

        // Simpan detail pembelian ke purchase_order_details
        foreach ($request->details as $detail) {
            MaterialReturnDetail::create([
                'material_return_id' => $materialRT->id,
              
                'original_no' => '',
              
                'item_code' => $detail['item_code'],
             
                'color_code' => $detail['color_code'] ?? null,
                'color_name' => $detail['color_name'] ?? null,
                'size' => $detail['size'] ?? null, 
             
                'qty' => $detail['qty'],
      
                'note' => '',
            ]);

        
           }
           return redirect()->route('all.materialreturn')->with('message', 'data berhasil diperbarui.');
    }

    
    public function EditMaterialreturn($id){

        // Fetch the Purchase Order with details, supplier
        $materialRT = MaterialReturn::with(['details.item.unit'])->findOrFail($id);
        return view('material_return.edit_materialreturn', compact('materialRT'));


    }


    public function Updatematerialreturn(Request $request, $id)
    {
        // Validasi data
        $request->validate([
         'department' => 'required|string',
         'person' => 'required|string',
        
         'details.*.item_code' => 'required',
        ]);
 
        $materialReturn = MaterialReturn::findOrFail($id);
 
 
        // Update entitas MaterialReturn
     $materialReturn->update([
         'department' => $request->department,
         'person' => $request->person,
         'remark' => $request->remark,
         // 'status' => $request->status, 
     ]);
 
     // Hapus detail lama yang terkait dengan materialReturn ini
     MaterialReturnDetail::where('material_return_id', $materialReturn->id)->delete();
 
     // Simpan detail yang baru
     foreach ($request->details as $detail) {
         MaterialReturnDetail::create([
             'material_return_id' => $materialReturn->id,
             'original_no' =>'',
             'item_code' => $detail['item_code'],
             'color_code' => $detail['color_code'] ?? null,
             'color_name' => $detail['color_name'] ?? null,
             'size' => $detail['size'] ?? null,
             'qty' => $detail['qty'],
     
             'note' => '',
         ]);
        }
 
        return redirect()->route('all.materialreturn')->with('message', 'Material RTN berhasil diperbarui.');
    }


    public function Deletematerialreturn(Request $request, $id)
    {
     
        try {
            if ($request->has('detail_id')) {
                // Hapus detail berdasarkan ID detail
                $detail = MaterialReturnDetail::findOrFail($request->input('detail_id'));
    
    
                $detail->delete();
    
              
                return response()->json([
                    'message' => true,
                    'message' => 'Detail berhasil dihapus!',
                ]);
            } else {
                // Hapus MaterialIn beserta detailnya
                $material_return = MaterialReturn::findOrFail($id);
    
               
    
                $material_return->details()->delete();
                $material_return->delete();
    
            
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




    public function Allmaterialreturndetail()
    {
        return view('material_return.all_materialreturndetail
        ');
    }

 

    public function Getmaterialreturndetail(Request $request) 
    {
        if ($request->ajax()) {
            $query = MaterialReturnDetail::with(['materialReturn', 'item.unit','QRCode']);
    
            // Filter by date range
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->startDate;
                $endDate = $request->endDate;
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
    
            $data = $query->get();          
    
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('return_no', function($row) {
                    return $row->materialReturn->material_return_no ?? ''; // Ensure materialReturn has 'return_no'
                })
                ->addColumn('date', function($row) {
                    return $row->created_at->format('Y-m-d'); // Format date if necessary
                })
                ->addColumn('department', function($row) {
                    return $row->materialReturn->department ?? ''; // Adjust if you have a different field
                })
                ->addColumn('original_no', function($row) {
                    return $row->QRCode->original_no ?? ''; // Ensure QRCode has 'original_no'
                })
                ->addColumn('supplier', function($row) {
                    return $row->QRCode->supplier_name ?? ''; // Ensure QRCode has 'supplier_name'
                })
                ->addColumn('item_code', function($row) {
                    return $row->item->item_code ?? '';
                })
                ->addColumn('item_name', function($row) {
                    return $row->item->item_name ?? ''; // Ensure item has 'item_name'
                })
                ->addColumn('unit', function($row) {
                    return $row->item->unit->unit_code ?? ''; // Ensure unit has 'unit_code'
                })
                ->addColumn('color_code', function($row) {
                    return $row->color_code ?? ''; // Ensure you have 'color_code'
                })
                ->addColumn('color_name', function($row) {
                    return $row->color_name ?? ''; // Ensure you have 'color_name'
                })
                ->addColumn('size', function($row) {
                    return $row->size ?? ''; // Ensure you have 'size'
                })
                ->addColumn('batch', function($row) {
                    return $row->QRCode->batch ?? ''; // Ensure you have 'batch'
                })
                ->addColumn('no_roll', function($row) {
                    return $row->QRCode->roll ?? ''; // Adjust if you have a different field
                })

                ->addColumn('basic_width', function($row) {
                    return $row->QRCode->basic_width ?? ''; // Adjust if you have a different field
                })

                ->addColumn('basic_grm', function($row) {
                    return $row->QRCode->basic_grm ?? ''; // Adjust if you have a different field
                })
                ->addColumn('gross_weight', function($row) {
                    return $row->QRCode->gross_weight ?? ''; // Adjust if you have a different field
                })
                ->addColumn('net_weight', function($row) {
                    return $row->QRCode->net_weight ?? ''; // Adjust if you have a different field
                })











                ->addColumn('qty', function($row) {
                    return $row->qty ?? ''; // Ensure you have 'quantity'
                })
      
                ->make(true);
        }
    }

 

} 
