<?php

namespace App\Http\Controllers;

use App\Models\RelaxReturn;
use App\Models\RelaxReturnDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use DataTables;

class RelaxReturnController extends Controller
{

 
    public function AllrelaxReturn(){

        return view ('relaxreturn.all_relaxreturn');
    }

    public function Addrelaxreturn(){

        return view ('relaxreturn.add_relaxreturn');
    }



    public function Storerelaxreturn(Request $request)
    {
         
         // Validate the request data
         $request->validate([
            'allocation' => 'required|string',
            'person' => 'required|string',
           
            'details.*.original_no' => 'required',
            // 'details' => 'required|array',
          
        ]);

            // Generate relax_return_no
        $yearMonth = date('Ym');
        $lastMaterialRTN = RelaxReturn::where('relax_return_no', 'like','RTN'. $yearMonth . '%')
            ->orderBy('relax_return_no', 'desc')
            ->first();

        if ($lastMaterialRTN) {
            $lastNumber = substr($lastMaterialRTN->relax_return_no, -6);
            $newNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        $materialInNo = 'FRTN' . $yearMonth . $newNumber;



        $materialIn = RelaxReturn::create([
            'relax_return_no' =>$materialInNo,
                 
            'fromx' => $request->allocation,
            'person' => $request->person,
            'remark' => $request->remark,
            // 'status' =>$request->status, 
            'user_id' =>Auth::id(),
        ]);

        // Simpan detail pembelian ke purchase_order_details
        foreach ($request->details as $detail) {
            RelaxReturnDetail::create([
                'relax_return_id' => $materialIn->id,
              
                'original_no' => $detail['original_no'],
              
                'item_code' => $detail['item_code'],
             
                'color_code' => $detail['color_code'] ?? null,
                'color_name' => $detail['color_name'] ?? null,
                'size' => $detail['size'] ?? '',
             
                'qty' => $detail['qty'],
                'mo' => $detail['mo'] ?? null,
                'style' => $detail['style'] ?? null,
                'rak' => $detail['rak_relax'] ?? null,
                'note' => '',
            ]);

        
           }
           return redirect()->route('all.relaxreturn')->with('message', 'data berhasil diperbarui.');
    }


    public function Getrelaxreturn(Request $request)
    {
        if ($request->ajax()) {
            $query = RelaxReturn::with(['details.item.unit']);
 
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
                            'size' => $detail->QRCode->size ?? '', 
                            'batch' =>  $detail->QRCode->batch?? '',
                            'roll' =>  $detail->QRCode->roll?? '',
                            'mo' =>  $detail->mo?? '',
                            'qty' => $detail->qty,
                            'rak' => $detail->rak,
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
                        '<a href="/edit/relaxreturn/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';
 
                    $deleteButton = $hasStatus ? 
                        '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                        '<a href="javascript:void(0)" class="dropdown-item text-danger deleteRelaxin" data-id="' . $row->id . '"> &nbsp; Delete</a>';
 
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


    public function Editrelaxreturn($id){

        $relaxReturn = RelaxReturn::with(['details.item.unit','details.QRCode'])->findOrFail($id);
        return view('relaxreturn.edit_relaxreturn', compact('relaxReturn'));
    
    
        }


    public function Updaterelaxreturn(Request $request, $id)
        {
            $request->validate([
                'fromx' => 'required|string',
                'person' => 'required|string',
                'details.*.original_no' => 'required|string|max:255',
            
            ]);

            $relaxIn = RelaxReturn::findOrFail($id);
            $relaxIn->update($request->only(['relax_return_id', 'person', 'remark']));

            // Delete details that are not in the request
            $existingDetailIds = $relaxIn->details->pluck('id')->toArray();
            $updatedDetailIds = array_filter(array_column($request->details, 'id'));
            $detailsToDelete = array_diff($existingDetailIds, $updatedDetailIds);

            RelaxReturnDetail::whereIn('id', $detailsToDelete)->delete();

            // Update or create details
            foreach ($request->details as $detail) {
                $relaxIn->details()->updateOrCreate(
                    ['id' => $detail['id'] ?? null],
                    [
                      'relax_return_id' =>  $relaxIn->id,
                    
                        'original_no' => $detail['original_no'],
                        'item_code' => $detail['item_code'],
                        'color_code' => $detail['color_code'] ?? null,
                        'color_name' => $detail['color_name'] ?? null,
                        'size' => $detail['size'] ?? '',
                        'qty' => $detail['qty'],
                        'mo' => $detail['mo'] ?? null,
                        'style' => $detail['style'] ?? null,
                        'rak' => $detail['rak_relax'] ?? null,
                        'note' => '',

                    ]
                );
            }

            return redirect()->route('all.relaxreturn')->with('message', 'Relax Return updated successfully');
        }


public function Deleterelaxout(Request $request, $id)
{
  
    try {
        if ($request->has('detail_id')) {
            // Hapus detail berdasarkan ID detail
            $detail = RelaxReturnDetail::findOrFail($request->input('detail_id'));


            $detail->delete();

          
            return response()->json([
                'message' => true,
                'message' => 'Detail berhasil dihapus!',
            ]);
        } else {
            // Hapus MaterialIn beserta detailnya
            $relaxin = RelaxReturn::findOrFail($id);

           

            $relaxin->details()->delete();
            $relaxin->delete();

        
            return response()->json([
                'message' => true,
                'message' => 'Material Return dan detail berhasil dihapus!',
            ]);
        }
    } catch (\Exception $e) {
 
        return response()->json([
            'message' => false,
            'message' => 'Terjadi kesalahan saat menghapus: ' . $e->getMessage(),
        ]);
    }
}
    

}
