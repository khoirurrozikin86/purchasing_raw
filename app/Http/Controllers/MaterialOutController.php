<?php

namespace App\Http\Controllers;

use App\Models\MaterialOut;
use App\Models\MaterialOutDetail; 
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\MaterialOutDetailsExport;
use DataTables;

class MaterialOutController extends Controller
{
    public function Allmaterialout()
    {
        return view('material_out.all_materialout');
    }

    public function Getmaterialout(Request $request)
    {
        if ($request->ajax()) {
            $query = MaterialOut::with(['details.materialInDetail', 'details.item.unit']);

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
                          
                            'item_code' => $detail->item->item_code,
                            'supplier_name' => $detail->materialInDetail->supplier_name ?? '', 
                            'item_name' =>  $itemName,
                            'unit_code' => $detail->item->unit->unit_code ?? '',
                            'color_code' => $detail->color_code ?? '', 
                            'color_name' => $detail->color_name ?? '', 
                            'size' => $detail->size ?? '', 
                          
                            'mo' =>  $detail->mo?? '',
                            'qty' => $detail->qty,
                        
                     
                            'style' => $detail->style,
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
                        '<a href="/edit/materialout/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';

                    $deleteButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                        '<a href="javascript:void(0)" class="dropdown-item text-danger deleteMaterialout" data-id="' . $row->id . '"> &nbsp; Delete</a>';

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


    public function Getmaterialoutcount(){
        $out = MaterialOut::count();

        return response()->json([
            'request' => $out,
         
        ]);
    }
 



    public function Allmaterialoutdetail()
    {
        return view('material_out.all_materialoutdetail
        ');
    }

 

    public function Getmaterialoutdetail(Request $request)
    {
        if ($request->ajax()) {
            $query = MaterialOutDetail::with(['materialOut', 'item.unit','materialInDetail']);
    
            // Filter by date range
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->startDate;
                $endDate = $request->endDate;
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
    
            $data = $query->get();          
    
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('out_no', function($row) {
                    return $row->materialOut->material_out_no ?? ''; // Ensure materialOut has 'out_no'
                })
              
                ->addColumn('allocation', function($row) {
                    return $row->materialOut->allocation ?? ''; // Adjust if you have a different field
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
              
                ->addColumn('qty', function($row) {
                    return $row->qty ?? ''; // Ensure you have 'quantity'
                })
                ->addColumn('mo', function($row) {
                    return $row->mo ?? ''; // Ensure you have 'mo'
                })
                ->addColumn('style', function($row) {
                    return $row->mo ?? ''; // Ensure you have 'mo'
                })
                ->addColumn('style', function($row) {
                    
                })
             
                ->make(true);
        }
    }
 




    public function Addmaterialout()
    {
        return view('material_out.add_materialout');
    }



    
    public function Storematerialout(Request $request)
    {
        
         // Validate the request data
         $request->validate([
            'allocation' => 'required|string',
            'person' => 'required|string',
           
            'details.*.item_code' => 'required',
            // 'details' => 'required|array',
          
        ]);

            // Generate material_out_no
        $yearMonth = date('Ym');
        $lastMaterialOUT = MaterialOut::where('material_out_no', 'like','OUT'. $yearMonth . '%')
            ->orderBy('material_out_no', 'desc')
            ->first();

        if ($lastMaterialOUT) {
            $lastNumber = substr($lastMaterialOUT->material_out_no, -6);
            $newNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        $materialInNo = 'OUT' . $yearMonth . $newNumber;



        $materialIn = MaterialOut::create([
            'material_out_no' =>$materialInNo,
                 
            'allocation' => $request->allocation,
            'person' => $request->person,
            'remark' => $request->remark,
            // 'status' =>$request->status, 
            'user_id' =>Auth::id(),
        ]);

        // Simpan detail pembelian ke purchase_order_details
        foreach ($request->details as $detail) {
            MaterialOutDetail::create([
                'material_out_id' => $materialIn->id,
              
                'original_no' => '',
              
                'item_code' => $detail['item_code'],
             
                'color_code' => $detail['color_code'] ?? null,
                'color_name' => $detail['color_name'] ?? null,
                'size' => $detail['size'] ?? null,
             
                'qty' => $detail['qty'],
                'mo' => $detail['mo'] ?? null,
                'style' => $detail['style'] ?? null,
                'rak' => '',
                'note' => '',
            ]);

        
           }
           return redirect()->route('all.materialout')->with('message', 'data berhasil diperbarui.');
    }




    public function Deletematerialout(Request $request, $id)
    {
     
        try {
            if ($request->has('detail_id')) {
                // Hapus detail berdasarkan ID detail
                $detail = MaterialOutDetail::findOrFail($request->input('detail_id'));
    
    
                $detail->delete();
    
              
                return response()->json([
                    'message' => true,
                    'message' => 'Detail berhasil dihapus!',
                ]);
            } else {
                // Hapus MaterialIn beserta detailnya
                $material_out = MaterialOut::findOrFail($id);
    
               
    
                $material_out->details()->delete();
                $material_out->delete();
    
            
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


    public function EditMaterialout($id){

        // Fetch the Purchase Order with details, supplier
   $materialOUT = Materialout::with(['details.item.unit','details.materialInDetail'])->findOrFail($id);


   return view('material_out.edit_materialout', compact('materialOUT'));


   }


   public function Updatematerialout(Request $request, $id)
   {
       // Validasi data
       $request->validate([
        'allocation' => 'required|string',
        'person' => 'required|string',
       
        'details.*.item_code' => 'required',
       ]);

       $materialOut = MaterialOut::findOrFail($id);
       

       // Update entitas MaterialOut
    $materialOut->update([
        'allocation' => $request->allocation,
        'person' => $request->person, 
        'remark' => $request->remark,
        // 'status' => $request->status, 
    ]);

    // Hapus detail lama yang terkait dengan materialOut ini
    MaterialOutDetail::where('material_out_id', $materialOut->id)->delete();

    // Simpan detail yang baru
    foreach ($request->details as $detail) {
        MaterialOutDetail::create([
            'material_out_id' => $materialOut->id,
            'original_no' => '',
            'item_code' => $detail['item_code'],
            'color_code' => $detail['color_code'] ?? null,
            'color_name' => $detail['color_name'] ?? null,
            'size' => $detail['size'] ?? null,
            'qty' => $detail['qty'],
            'mo' => $detail['mo'] ?? null,
            'style' => $detail['style'] ?? null,
            'rak' => '',
            'note' => '',
        ]);
       }

       return redirect()->route('all.materialout')->with('message', 'Material OUT berhasil diperbarui.');
   }


   
   public function Exportmaterialout(Request $request)
   {
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    return Excel::download(new MaterialOutDetailsExport($startDate, $endDate), 'material_out_details_' . $startDate . '_to_' . $endDate . '.xlsx');
   }


   public function Getmaterialoutoriginal($original_no){

    $qrcode = MaterialOutDetail::with('materialInDetail')->where('original_no', $original_no)->first();
    if ($qrcode) {
        return response()->json([
            'material_in_detail' => $qrcode
        ]);
    } else {
        return response()->json(['message' => 'No data found'], 404);
    }

     

}


public function Getmaterialoutid($id)
{
    $materialOUT = Materialout::with(['details.item.unit','details.materialInDetail'])->findOrFail($id);
    

    // Return the data as JSON
    return response()->json(['material_out_detail' => $materialOUT]);
}


 


}
