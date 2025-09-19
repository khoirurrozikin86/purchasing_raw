<?php

namespace App\Http\Controllers;

use App\Models\Consumption;
use App\Models\ConsumptionDetail;
use App\Models\CbdDetail;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use DataTables;

class ConsumptionController extends Controller
{
    public function AllConsumption()
    {
    
        return view('backend.consumption.all_consumption');
      
    }



    public function Getconsumption(Request $request)
    {
      
        if ($request->ajax()) {
            $data = Consumption::with(['cbdDetail', 'cbdDetail.cbd'])
            ->get();

           

           
    
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('order_no', function ($row) {
                    return $row->cbdDetail->order_no ?? 'N/A';
                })
                ->addColumn('seasion', function ($row) {
                    return $row->cbdDetail->cbd->year.'-'.$row->cbdDetail->cbd->planning_ssn ?? 'N/A';
                })
                ->addColumn('sample_code', function ($row) {
                    return $row->cbdDetail->cbd->sample_code ?? 'N/A';
                })
                ->addColumn('color_code', function ($row) {
                    return $row->cbdDetail->color_code ?? 'N/A';
                })
                ->addColumn('color', function ($row) {
                    return $row->cbdDetail->color ?? 'N/A';
                })
                ->addColumn('size', function ($row) {
                    return $row->cbdDetail->size ?? 'N/A';
                })
                ->addColumn('width_fabric', function ($row) {
                    return $row->width ?? 'N/A';
                })
                ->addColumn('consumption', function ($row) { 
                    return $row->consumption ?? 'N/A';
                })

                ->addColumn('consumption_detail', function ($row) {
                    $consumptionDetails = $row->details->map(function ($detail) {
                        return '<li>' . $detail->type . ': ' . $detail->amount . '</li>';
                    })->implode('');
    
                    return $consumptionDetails ? '<ul>' . $consumptionDetails . '</ul>' : 'N/A';
                })
 

                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="actions dropdown">
                                        <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                        <div class="dropdown-menu" role="menu">
                                            <a href="/edit/consumption/'.$row->id.'" class="dropdown-item editConsumption"> &nbsp; Edit</a>
                                            <a href="javascript:void(0)" class="dropdown-item text-danger deleteConsumption" data-id="' . $row->id . '"> &nbsp; Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                })
                ->rawColumns(['consumption_detail','action'])
                ->make(true); 
    
            }
    }


    public function Addconsumption() {

        return view('backend.consumption.add_consumption');

    }


    public function Storeconsumption(Request $request)
    {
        $request->validate([
            'cbd_id' => 'required|integer',
            'width' => 'required|string|max:255',
            'total_amount' => 'required|numeric',
            'details' => 'required|array',
            'details.*.type' => 'required|string|max:255',
            'details.*.amount' => 'required|numeric',
        ]);

    
            // Create the main Consumption record
            $consumption = Consumption::create([
                'cbd_detail_id' => $request->cbd_id,
                'cbd_name' => $request->cbd_name,
                'width' => $request->width,
                'consumption' => $request->total_amount,
                'remark' => '',
            ]);

            // Create the related ConsumptionDetail records
            foreach ($request->details as $detail) {
                ConsumptionDetail::create([
                    'consumption_id' => $consumption->id,
                    'type' => $detail['type'],
                    'amount' => $detail['amount'],
                ]);
            }
     

            return redirect()->route('all.consumption')->with('message', 'Data berhasil disimpan.');
            
    }


      // Method to show the edit form
      public function Editconsumption($id)
      {
          $consumption = Consumption::findOrFail($id);
          $details = $consumption->details; // Get related details

          $cbdDetailIds = $consumption->cbd_detail_id;


          $cbdDetails = CbdDetail::with('cbd')->where('id', $cbdDetailIds)->get();

        
  
          return view('backend.consumption.edit_consumption', compact('consumption', 'details', 'cbdDetails'));
      }
  
      // Method to update the data
      public function Updateconsumption(Request $request, $id)
      {
          $request->validate([
              'cbd_id' => 'required|integer',
              'cbd_name' => 'required|string|max:255',
              'width' => 'required|string|max:255',
              'total_amount' => 'required|numeric',
              'details' => 'required|array',
              'details.*.type' => 'required|string|max:255',
              'details.*.amount' => 'required|numeric',
          ]);
  
          // Find the existing Consumption record
          $consumption = Consumption::findOrFail($id);
  
          // Update the Consumption record
          $consumption->update([
              'cbd_id' => $request->cbd_id,
              'cbd_name' => $request->cbd_name,
              'width' => $request->width,
              'consumption' => $request->total_amount,
              'remark' => '',
          ]);
  
          // Remove old details
          $consumption->details()->delete();
  
          // Create or update related ConsumptionDetail records
          foreach ($request->details as $detail) {
              ConsumptionDetail::create([
                  'consumption_id' => $consumption->id,
                  'type' => $detail['type'],
                  'amount' => $detail['amount'],
              ]);
          }
  
          return redirect()->route('all.consumption', $id)->with('message', 'Consumption details updated successfully!');
      }



      public function Deleteconsumption(Request $request, $id)
        {
            if ($request->has('detail_id')) {
                // Hapus detail berdasarkan ID detail
                $detail = ConsumptionDetail::findOrFail($request->input('detail_id'));
                $detail->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Dihapus!.',
                ]);
            } else {
                // Hapus Purchase Request beserta detailnya
                $consumption = Consumption::findOrFail($id);
                $consumption->details()->delete();
                $consumption->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Dihapus!.',
                ]);
            }
        } 

  
}
