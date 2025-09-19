<?php

namespace App\Http\Controllers;

use App\Models\RelaxIn;
use App\Models\RelaxInDetail;
use Illuminate\Http\Request;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class RelaxInController extends Controller 
{
   public function Allrelaxin(){

    return view ('relaxin.all_relaxin');
   }



   public function Getrelaxin(Request $request)
   {
       if ($request->ajax()) {
           $query = RelaxIn::with(['details.item.unit']);

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
                       '<a href="/edit/relaxin/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Edit</a>';

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



   public function Addrelaxin(){

    return view ('relaxin.add_relaxin');
   }




   public function Storerelaxin(Request $request)
   {
       // Validasi data yang diterima
       $request->validate([
           'material_out_id' => 'required',
           'person' => 'required|string|max:255',
           'remark' => 'nullable|string|max:255',
           'details.*.original_no' => 'required|unique:relax_in_details,original_no',
          
       ]);


            // Generate relax_out_no
            $yearMonth = date('Ym');
            $lastMaterialOUT = RelaxIn::where('relax_in_no', 'like','OUT'. $yearMonth . '%')
                ->orderBy('relax_in_no', 'desc')
                ->first();
    
            if ($lastMaterialOUT) {
                $lastNumber = substr($lastMaterialOUT->relax_in_no, -6);
                $newNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '000001';
            }
    
            $relaxInNo = 'FIN' . $yearMonth . $newNumber;

       // Buat catatan RelaxIn
       $relaxIn = RelaxIn::create([
           'relax_in_no' => $relaxInNo,
           'material_out_id' => $request->material_out_id,
           'person' => $request->person,
           'remark' => $request->remark,
       ]);

       // Buat catatan RelaxInDetail
       foreach ($request->details as $detail) {
         $relaxInDetail = new RelaxInDetail();
         $relaxInDetail->relax_in_id = $relaxIn->id;
         $relaxInDetail->original_no = $detail['original_no'];
         $relaxInDetail->item_code = $detail['item_code'];
         $relaxInDetail->color_code = $detail['color_code'];
         $relaxInDetail->color_name = $detail['color_name'];
         $relaxInDetail->size = '';
      
         $relaxInDetail->qty = $detail['qty'];
         $relaxInDetail->style = $detail['style'];
         $relaxInDetail->mo_number = $detail['mo_number'];
         $relaxInDetail->fabric_pcs = $detail['fabric_pcs'];
         $relaxInDetail->inspec_machine_no = $detail['inspec_machine_no'];
         $relaxInDetail->act_width_front = $detail['act_width_front'];
         $relaxInDetail->act_width_center = $detail['act_width_center'];
         $relaxInDetail->act_width_back = $detail['act_width_back'];
         $relaxInDetail->panjang_actual = $detail['panjang_actual'];
         $relaxInDetail->hasil_fabric_ins = $detail['hasil_fabric_ins'];
         $relaxInDetail->kotor = $detail['kotor'];
         $relaxInDetail->crease_mark = $detail['crease_mark'];
         $relaxInDetail->knot = $detail['knot'];
         $relaxInDetail->hole = $detail['hole'];
         $relaxInDetail->missing_yarn = $detail['missing_yarn'];
         $relaxInDetail->foreign_yarn = $detail['foreign_yarn'];
         $relaxInDetail->benang_tebal = $detail['benang_tebal'];
         $relaxInDetail->kontaminasi = $detail['kontaminasi'];
         $relaxInDetail->shinning_others = $detail['shinning_others'];
         $relaxInDetail->maxim_ok_point = $detail['maxim_ok_point'];
         $relaxInDetail->pass_ng = $detail['pass_ng'];
         $relaxInDetail->relaxing_rack_no = $detail['relaxing_rack_no'];
         $relaxInDetail->b_roll_rack_no = $detail['b_roll_rack_no'];
         $relaxInDetail->reason = $detail['reason'];
         $relaxInDetail->selisih = $detail['selisih'];
         $relaxInDetail->sambungan_di_meter = $detail['sambungan_di_meter'];
         $relaxInDetail->save();
       }

       return redirect()->route('all.relaxin')->with('message', 'Relax In created successfully.');
   }


   public function Deleterelaxin(Request $request, $id)
   {
    
       try {
           if ($request->has('detail_id')) {
               // Hapus detail berdasarkan ID detail
               $detail = RelaxInDetail::findOrFail($request->input('detail_id'));
   
   
               $detail->delete();
   
             
               return response()->json([
                   'message' => true,
                   'message' => 'Detail berhasil dihapus!',
               ]);
           } else {
               // Hapus MaterialIn beserta detailnya
               $relaxin = RelaxIn::findOrFail($id);
   
              
   
               $relaxin->details()->delete();
               $relaxin->delete();
   
           
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



   public function Editrelaxin($id){

    // Fetch the Purchase Order with details, supplier
$relaxIn = RelaxIn::with(['details.item.unit','details.QRCode','materialout'])->findOrFail($id);


return view('relaxin.edit_relaxin', compact('relaxIn'));


}


public function Updaterelaxin(Request $request, $id)
{
    $request->validate([
        'material_out_id' => 'required|integer',
        'person' => 'required|string|max:255',
        'remark' => 'nullable|string|max:255',
        'details.*.original_no' => 'required|string|max:255',
       
    ]);

    $relaxIn = RelaxIn::findOrFail($id);
    $relaxIn->update($request->only(['material_out_id', 'person', 'remark']));

    // Delete details that are not in the request
    $existingDetailIds = $relaxIn->details->pluck('id')->toArray();
    $updatedDetailIds = array_filter(array_column($request->details, 'id'));
    $detailsToDelete = array_diff($existingDetailIds, $updatedDetailIds);

    RelaxInDetail::whereIn('id', $detailsToDelete)->delete();

    // Update or create details
    foreach ($request->details as $detail) {
        $relaxIn->details()->updateOrCreate(
            ['id' => $detail['id'] ?? null],
            [
                'original_no' => $detail['original_no'],
             
                'item_code' => $detail['item_code'],
              
                'color_code' => $detail['color_code'],
                'color_name' => $detail['color_name'],
             
                'qty' => $detail['qty'],
                'style' => $detail['style'],
                'mo_number' => $detail['mo_number'],
                'fabric_pcs' => $detail['fabric_pcs'],
                'inspec_machine_no' => $detail['inspec_machine_no'],
                'act_width_front' => $detail['act_width_front'],
                'act_width_center' => $detail['act_width_center'],
                'act_width_back' => $detail['act_width_back'],
                'panjang_actual' => $detail['panjang_actual'],
                'hasil_fabric_ins' => $detail['hasil_fabric_ins'],
                'kotor' => $detail['kotor'],
                'crease_mark' => $detail['crease_mark'],
                'knot' => $detail['knot'],
                'hole' => $detail['hole'],
                'missing_yarn' => $detail['missing_yarn'],
                'foreign_yarn' => $detail['foreign_yarn'],
                'benang_tebal' => $detail['benang_tebal'],
                'kontaminasi' => $detail['kontaminasi'],
                'shinning_others' => $detail['shinning_others'],
                'maxim_ok_point' => $detail['maxim_ok_point'],
                'pass_ng' => $detail['pass_ng'],
                'relaxing_rack_no' => $detail['relaxing_rack_no'],
                'b_roll_rack_no' => $detail['b_roll_rack_no'],
                'reason' => $detail['reason'],
                'selisih' => $detail['selisih'],
                'sambungan_di_meter' => $detail['sambungan_di_meter'],
            ]
        );
    }

    return redirect()->route('all.relaxin')->with('message', 'Relax In updated successfully');
}



public function Getrelaxinoriginal($original_no){

    $qrcode = RelaxInDetail::with(['uStockRelax','QRCode'])->where('original_no', $original_no)->first();
    if ($qrcode) {
        return response()->json([
            'material_in_detail' => $qrcode,
            'stock' => $qrcode->uStockRelax
        ]);
    } else {
        return response()->json(['message' => 'No data found'], 404);
    }

     
}



 


   
}
 
