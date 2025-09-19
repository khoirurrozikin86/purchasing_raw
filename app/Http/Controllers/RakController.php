<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class RakController extends Controller
{
    public function Allrak()
    {
        return view('backend.raks.all_rak');
    }

    public function Getrak(Request $request){

        if ($request->ajax()) {
            $data = Rak::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                      return   '<div class="d-flex align-items-center justify-content-between flex-wrap">
                      <div class="d-flex align-items-center">
                        
                          <div class="d-flex align-items-center">
                              <div class="actions dropdown">
                                  <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                  <div class="dropdown-menu" role="menu">
                                    
                                  
                                          <a href="javascript:void(0)"
                                              class="dropdown-item editRak" data-id="'.$row->id.'"> &nbsp; Edit</a>
                                   
                          
                                          <a href="javascript:void(0)"
                                              class="dropdown-item text-danger deleteRak"
                                           data-id="'.$row->id.'"> &nbsp; Delete</a>
                                   

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

    public function Storerak(Request $request)
    {
        if( $request->rak_id == ""){

            $request->validate([
                'rak_code' => 'required|unique:raks',
                'rak_name' => 'required',
             
            ]);

            $post = rak::updateOrCreate([

   
                'id' => $request->rak_id
        
                 ],[
                    'rak_code' => $request->rak_code,
                    'rak_name' => $request->rak_name,
        
                ]);
        
        
                //return response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                    'data'    => $post,
                    'alert-type' => 'success'  
                ]);
    

        }
        else{
            $request->validate([
                'rak_code' => 'required',
                'rak_name' => 'required',
    
            ]);

            $post = rak::updateOrCreate([

   
                'id' => $request->rak_id
        
                 ],[
                    'rak_code' => $request->rak_code,
                    'rak_name' => $request->rak_name,
        
                ]);
        
        
                //return response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                    'data'    => $post,
                    'alert-type' => 'success'  
                ]);
    
        }
      
    }

    public function Editrak($id)
    {
        $raks = Rak::find($id);
        return response()->json($raks);
    }

   
     public function Deleterak($id)
     {
         Rak::findOrFail($id)->delete();
         return response()->json([
             'success' => true,
             'message' => 'Data Post Berhasil Dihapus!.',
         ]);
     }

     public function exportPDF(Request $request)
    {

         $rak = Rak::all();

        foreach ($raks as $rak) {
            $qrCode = QrCode::size(100)->generate($employee->rak_code);
            $rak->qr_code = $qrCode;

        }

        return view('backend.raks.pdf', compact('rak'));
    }

    public function Printrak()
    {
     
        // return view('backend.raks.print');

        $raks = Rak::all();

        foreach ($raks as $rak) {
            $qrCode = QrCode::size(200)->generate($rak->rak_code);
            $rak->qr_code = $qrCode;

        }

        return view('backend.raks.pdf', compact('raks'));
    }

}
