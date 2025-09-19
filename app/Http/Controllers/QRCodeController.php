<?php

namespace App\Http\Controllers;

use App\Models\QRCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QRCodeImport;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodex;
use PDF;

class QRCodeController extends Controller
{
    public function Allqr_code()
    {
    
        return view('backend.qr_code.all_qr_code');
      
    }

 
  

    public function Getqr_code(Request $request)
    {
        if ($request->ajax()) {
            $data =QRCode::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="actions dropdown">
                                        <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                        <div class="dropdown-menu" role="menu">
                                          
                                            <a href="javascript:void(0)" class="dropdown-item text-danger deleteQr" data-id="' . $row->id . '"> &nbsp; Delete</a>
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


    public function Importqr_codes(){
        return view('backend.qr_code.import_qr_code');
    }

    public function Importqr_code(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls',
        ]);

        $import = new QRCodeImport;

        try {
            Excel::import($import, $request->file('import_file'));

            if (!empty($import->errors)) {
                // Redirect back with validation errors
                return redirect()->route('all.qr_code')->with('message', json_encode($import->errors));
    
            }

            return redirect()->back()->with('message', 'QR Codes imported successfully.');

        } catch (QueryException $e) {
            // Handle duplicate entry exception
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withErrors(['Duplicate entry found for Original No.']);
            }

            // Handle other database exceptions
            return redirect()->back()->withErrors(['An error occurred while importing data.']);
        }
    }

    public function Printqr_code(){
        return view('backend.qr_code.print'); 
    }


    public function Getoriginal(Request $request){

        // $posisi= $request->input('posisi');

          // Fetch employee positions for the specified department
          $data = QRCode::distinct()->pluck('original_no');

          return response()->json($data);

        

    }





   
    public function exportPDF(Request $request)
    {
        // Validate the input
        $request->validate([
            'range1' => 'required|string',
            'range2' => 'required|string'
        ]);
  
        // Get the range from the request 
        $range1 = $request->input('range1');
        $range2 = $request->input('range2');

        // Fetch QR codes within the specified range
        $qrCodes = QRCode::whereBetween('original_no', [$range1, $range2])->get();

        // Generate QR codes for each record
        foreach ($qrCodes as $qrCodex) {
            $qrCodex1 = QrCodex::size(100)->generate($qrCodex->original_no);
            $qrCodex->qr_code = $qrCodex1;
        }

        return view('backend.qr_code.pdf', compact('qrCodes'));

       
        // $pdf = PDF::loadView('backend.qr_code.pdf', compact('qrCodes'));

        // return $pdf->download('qr_codes_report.pdf');
    }


    public function DeleteQrcode($id)
    {
        QRCode::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }

    public function Getqr_codein($original_no)
    {
        $qrcode = QRCode::where('original_no', $original_no)->first();

        if ($qrcode) {
            return response()->json($qrcode);
        } else {
            return response()->json(['message' => 'No data found'], 404);
        }
    }

}
