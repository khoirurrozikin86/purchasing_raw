<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use DataTables;

class UnitController extends Controller
{
    public function Allunit()
    {
        

        return view('backend.unit.all_unit');

      
    }

    public function Getunit(Request $request){

        if ($request->ajax()) {
            $data = Unit::latest()->get();
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
                                              class="dropdown-item editunit" data-id="'.$row->id.'"> &nbsp; Edit</a>
                                   
                          
                                          <a href="javascript:void(0)"
                                              class="dropdown-item text-danger deleteunit"
                                           data-id="'.$row->id.'"> &nbsp; Delete</a>
                                   

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';

                    })

                    // ->addColumn('qr_code', function($row){ return QrCode::size(30)->generate($row->unit_code);})

                    ->rawColumns(['action'])

                    ->make(true);
                 

        }

    }


    public function GetunitGlobal(Request $request){

      
        $unit = Unit::select('id','unit_code', 'unit_name')->get();  // Fetch only necessary fields
        return response()->json($unit);

    }

   

    public function Storeunit(Request $request)
    {
        if( $request->unit_id == ""){

            $request->validate([
                'unit_code' => 'required|unique:units|max:200',
                'unit_name' => 'required',
    
            ]);

            $post = unit::updateOrCreate([

   
                'id' => $request->unit_id
        
                 ],[
                    'unit_code' => $request->unit_code,
                    'unit_name' => $request->unit_name,
        
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
                'unit_code' => 'required|max:200',
                'unit_name' => 'required',
    
            ]);

            $post = unit::updateOrCreate([

   
                'id' => $request->unit_id
        
                 ],[
                    'unit_code' => $request->unit_code,
                    'unit_name' => $request->unit_name,
        
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
    

   
    public function Editunit($id)
    {

        $units = unit::find($id);
        return response()->json($units);
    }


    public function Deleteunit($id)
    {
        unit::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
    }
}
