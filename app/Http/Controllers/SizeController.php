<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use DataTables;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
     public function AllSize()
     {
         return view('backend.size.all_size');
     }

    /**
     * Show the form for creating a new resource.
     */
  
     public function Getsize(Request $request){

        if ($request->ajax()) {
            $data = Size::latest()->get();
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
                                              class="dropdown-item editsize" data-id="'.$row->id.'"> &nbsp; Edit</a>
                                   
                          
                                          <a href="javascript:void(0)"
                                              class="dropdown-item text-danger deletesize"
                                           data-id="'.$row->id.'"> &nbsp; Delete</a>
                                   

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';

                    })

                    // ->addColumn('qr_code', function($row){ return QrCode::size(30)->generate($row->size_code);})

                    ->rawColumns(['action'])

                    ->make(true);
                 

        }

    }

    public function GetSizeGlobal(){

        $size = Size::all();
        return response()->json($size);

    }


    public function Storesize(Request $request)
    {
        if( $request->size_id == ""){

            $request->validate([
                'size_code' => 'required|unique:sizes|max:200',
                'size_name' => 'required',
    
            ]);

            $post = Size::updateOrCreate([

   
                'id' => $request->size_id
        
                 ],[
                    'size_code' => $request->size_code,
                    'size_name' => $request->size_name,
        
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
                'size_code' => 'required|max:200',
                'size_name' => 'required',
    
            ]);

            $post = size::updateOrCreate([

   
                'id' => $request->size_id
        
                 ],[
                    'size_code' => $request->size_code,
                    'size_name' => $request->size_name,
        
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


    public function Editsize($id)
    {

        $sizes = Size::find($id);
        return response()->json($sizes);
    }

    public function Deletesize($id)
    {
        Size::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
    }
}
