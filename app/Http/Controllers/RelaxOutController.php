<?php

namespace App\Http\Controllers;

use App\Models\RelaxOut;
use App\Models\RelaxOutDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use DataTables;

class RelaxOutController extends Controller
{

    public function Allrelaxout(){

        return view ('relaxout.all_relaxout');
       }
 
    
    public function Addrelaxout(){

        return view ('relaxout.add_relaxout');
    }


    public function Storerelaxout(Request $request)
    {
        
         // Validate the request data
         $request->validate([
            'allocation' => 'required|string',
            'person' => 'required|string',
           
            'details.*.original_no' => 'required',
            // 'details' => 'required|array',
          
        ]);

            // Generate relax_out_no
        $yearMonth = date('Ym');
        $lastMaterialOUT = RelaxOut::where('relax_out_no', 'like','OUT'. $yearMonth . '%')
            ->orderBy('relax_out_no', 'desc')
            ->first();

        if ($lastMaterialOUT) {
            $lastNumber = substr($lastMaterialOUT->relax_out_no, -6);
            $newNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        $relaxInNo = 'FOUT' . $yearMonth . $newNumber;



        $relaxIn = RelaxOut::create([
            'relax_out_no' =>$relaxInNo,
                 
            'allocation' => $request->allocation,
            'person' => $request->person,
            'remark' => $request->remark,
            // 'status' =>$request->status, 
            'user_id' =>Auth::id(),
        ]);

        // Simpan detail pembelian ke purchase_order_details
        foreach ($request->details as $detail) {
            RelaxOutDetail::create([
                'relax_out_id' => $relaxIn->id,
              
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
           return redirect()->route('all.relaxout')->with('message', 'data berhasil diperbarui.');
    }

  

    public function Getrelaxout(Request $request)
   {
       if ($request->ajax()) {
           $query = RelaxOut::with(['details.item.unit']);

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
                           'relax_out_no' => $detail->relaxOut->relax_out_no ?? '',
                           'allocation' => $detail->relaxOut->allocation ?? '',
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
                       '<a href="/edit/relaxout/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';

                   $deleteButton = $hasStatus ? 
                       '<a href="javascript:void(0)" class="dropdown-item text-muted disabled"> &nbsp; Delete</a>' : 
                       '<a href="javascript:void(0)" class="dropdown-item text-danger deleteRelaxOut" data-id="' . $row->id . '"> &nbsp; Delete</a>';

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

 
   public function Editrelaxout($id){

    $relaxOut = RelaxOut::with(['details.item.unit','details.QRCode'])->findOrFail($id);
    return view('relaxout.edit_relaxout', compact('relaxOut'));


    }


    public function Updaterelaxout(Request $request, $id)
{
    $request->validate([
        'allocation' => 'required|string',
        'person' => 'required|string',
        'details.*.original_no' => 'required|string|max:255',
       
    ]);

    $relaxIn = RelaxOut::findOrFail($id);
    $relaxIn->update($request->only(['relax_out_id', 'person', 'remark']));

    // Delete details that are not in the request
    $existingDetailIds = $relaxIn->details->pluck('id')->toArray();
    $updatedDetailIds = array_filter(array_column($request->details, 'id'));
    $detailsToDelete = array_diff($existingDetailIds, $updatedDetailIds);

    RelaxOutDetail::whereIn('id', $detailsToDelete)->delete();

    // Update or create details
    foreach ($request->details as $detail) {
        $relaxIn->details()->updateOrCreate(
            ['id' => $detail['id'] ?? null],
            [
                'relax_out_id' => $relaxIn->id,
              
                'original_no' => $detail['original_no'],
              
                'item_code' => $detail['item_code'],
             
                'color_code' => $detail['color_code'] ?? null,
                'color_name' => $detail['color_name'] ?? null,
                'size' => $detail['size'] ?? '',
             
                'qty' => $detail['qty'],
                'mo' => $detail['mo'] ?? null,
                'style' => $detail['style'] ?? null,
                'note' => '',

            ]
        );
    }

    return redirect()->route('all.relaxout')->with('message', 'Relax Out updated successfully');
}


public function Deleterelaxout(Request $request, $id)
{
  
    try {
        if ($request->has('detail_id')) {
            // Hapus detail berdasarkan ID detail
            $detail = RelaxOutDetail::findOrFail($request->input('detail_id'));


            $detail->delete();

          
            return response()->json([
                'message' => true,
                'message' => 'Detail berhasil dihapus!',
            ]);
        } else {
            // Hapus MaterialIn beserta detailnya
            $relaxin = RelaxOut::findOrFail($id);

           

            $relaxin->details()->delete();
            $relaxin->delete();

        
            return response()->json([
                'message' => true,
                'message' => 'Material Out dan detail berhasil dihapus!',
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
