<?php

namespace App\Http\Controllers;

use App\Models\Cbd;
use App\Models\CbdDetail;
use Illuminate\Http\Request;
use App\Imports\CbdsImport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;


class CbdController extends Controller
{

    public function Allcbd()
    {
        return view('cbd.all_cbd');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new CbdsImport, $request->file('file'));

        return redirect()->route('cbds.index')->with('success', 'CBDs imported successfully.');
    }

    public function Getcbd(Request $request){

        if ($request->ajax()) {
            $data = Cbd::with('details')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){


                      return   '<div class="d-flex align-items-center justify-content-between flex-wrap">
                      <div class="d-flex align-items-center">
                        
                          <div class="d-flex align-items-center">
                              <div class="actions dropdown">
                                  <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                  <div class="dropdown-menu" role="menu">
                                     <a href="/add/purchaserequestid/'.$row->id.'" class="dropdown-item text-primary"> &nbsp; Add Purchase Request</a>
                                    <a href="javascript:void(0)" class="dropdown-item text-warning editCbd" data-id="' . $row->id . '" data-po_uq="' . $row->po_uq . '" data-po_uq_date="' . $row->po_uq_date . '"> &nbsp; Edit UQ PO</a>
                                    <a href="javascript:void(0)"class="dropdown-item text-danger deleteCbd" data-id="'.$row->id.'"> &nbsp; Delete</a>

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';

                    })

                    ->addColumn('color_code', function($row){
                        $details = '<ul>';
                        foreach ($row->details as $detail) {
                            $details .= '<li>' . $detail->color_code . '</li>';
                        }
                        $details .= '</ul>';
                        return $details;
                    })
                    ->addColumn('color', function($row){
                        $details = '<ul>';
                        foreach ($row->details as $detail) {
                            $details .= '<li>' . $detail->color . '</li>';
                        }
                        $details .= '</ul>';
                        return $details;
                    })
                    ->addColumn('size_code', function($row){
                        $details = '<ul>';
                        foreach ($row->details as $detail) {
                            $details .= '<li>' . $detail->size_code . '</li>';
                        }
                        $details .= '</ul>';
                        return $details;
                    })
                    ->addColumn('size', function($row){
                        $details = '<ul>';
                        foreach ($row->details as $detail) {
                            $details .= '<li>' . $detail->size . '</li>';
                        }
                        $details .= '</ul>';
                        return $details;
                    })
                    ->addColumn('qty', function($row){
                        $details = '<ul>';
                        foreach ($row->details as $detail) {
                            $details .= '<li>' . $detail->qty . '</li>';
                        }
                        $details .= '</ul>';
                        return $details;
                    })
         
                

                    ->rawColumns(['action', 'color_code', 'color', 'size_code', 'size', 'qty',])

                    ->make(true);
                 

        }

    }

 public function Editcbd($id)
    {
        // Mencari CBD berdasarkan ID
        $cbd = Cbd::findOrFail($id);

        // Mengembalikan data CBD ke view atau JSON response jika menggunakan API
        return response()->json([
            'success' => true,
            'data' => $cbd
        ]);
    }



    // Menyimpan perubahan pada trim_item_no dan trim_supplier
    public function Updatecbd(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'po_uq' => 'nullable|string', // Validasi untuk po_uq
            'po_uq_date' => 'nullable|date', // Validasi untuk po_uq_date
        ]);

        // Menemukan CBD berdasarkan ID
        $cbd = Cbd::findOrFail($id);

        // Memperbarui field trim_item_no dan trim_supplier
        $cbd->po_uq = $request->po_uq; // Menambahkan pembaruan untuk po_uq
        $cbd->po_uq_date = $request->po_uq_date; // Menambahkan pembaruan untuk po_uq_date
        $cbd->save(); // Menyimpan perubahan

        // Mengembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Trim Item No and Trim Supplier have been updated successfully.'
        ]);
    }




    public function Importcbds()
    {
        return view('cbd.import_cbd');
    }

    public function Importcbd(Request $request)
    {

        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv'
        ]);

    
        try {
            $import = new CbdsImport;
            Excel::import($import, $request->file('import_file'));
    
            $failures = $import->getFailures();
    
            if (count($failures) > 0) {
                $message = 'Import completed with warnings: ';
                foreach ($failures as $failure) {
                    $message .= 'Row ' . $failure->row() . ' - ' . implode(', ', $failure->errors()) . '; ';
                }
    
                $notification = array(
                    'message' => $message,
                    'alert-type' => 'warning'
                );
            } else {
                $notification = array(
                    'message' => 'Import Successfully',
                    'alert-type' => 'success'
                );
            }
    
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Import failed: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
        }
    
        return redirect()->route('all.cbd')->with($notification);
    } //end method

    public function Deletecbd($id)
    {
        $cbd = Cbd::findOrFail($id);
            $cbd->details()->delete(); // Delete associated details
            $cbd->delete(); // Delete the Cbd record
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
    }

    public function Getcbdglobal(Request $request){

     // Validate the incoming request
     $request->validate([
        'cbd_id' => 'required|integer'
    ]);

    // Retrieve the colors based on the cbd_id
    $cbdId = $request->input('cbd_id');
    $colors = Cbd::with('details')->where('id', $cbdId)->get();


    // dd($colors);

    // Return the data as JSON
    return response()->json($colors);

    }



    public function Getcbddetail(Request $request){
        
            if ($request->ajax()) {
                $data = CbdDetail::with('cbd')->get();
        
                return datatables()->of($data)
                    ->addColumn('order_no', function ($row) {
                        return $row->cbd->order_no ?? 'N/A';
                    })
                    ->addColumn('sample_code', function ($row) {
                        return $row->cbd->sample_code ?? 'N/A';
                    })
                    ->addColumn('planning_ssn', function ($row) {
                        return $row->cbd->year.'-'.$row->cbd->planning_ssn ?? 'N/A';
                    })
                    ->addColumn('color_code', function ($row) {
                        return $row->color_code ?? 'N/A';
                    })
                    ->addColumn('color', function ($row) {
                        return $row->color ?? 'N/A';
                    })
                    ->addColumn('size', function ($row) {
                        return $row->size ?? 'N/A';
                    })
                    ->make(true);
            }
        
            return response()->json(['message' => 'Invalid request'], 400);

        }

 public function Getcbddetaillimit(Request $request)
    {

        if ($request->ajax()) {
            $data = Cbd::latest()->get();

            return datatables()->of($data)
                ->addColumn('order_no', function ($row) {
                    return $row->order_no ?? 'N/A';
                })
                ->addColumn('sample_code', function ($row) {
                    return $row->sample_code ?? 'N/A';
                })


                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

}
