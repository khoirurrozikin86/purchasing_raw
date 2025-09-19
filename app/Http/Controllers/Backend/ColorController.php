<?php

namespace  App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ColorController extends Controller
{
   
    public function AllColor()
    {
        // $colors = Color::latest()->get();


        return view('backend.color.all_color');

      
    }

    public function GetColor(Request $request){

        if ($request->ajax()) {
            $data = Color::latest()->get();
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
                                              class="dropdown-item editColor" data-id="'.$row->id.'"> &nbsp; Edit</a>
                                   
                          
                                          <a href="javascript:void(0)"
                                              class="dropdown-item text-danger deleteColor"
                                           data-id="'.$row->id.'"> &nbsp; Delete</a>
                                   

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';

                    })

                    // ->addColumn('qr_code', function($row){ return QrCode::size(30)->generate($row->color_code);})

                    ->rawColumns(['action'])

                    ->make(true);
                 

        }

    }

    public function GetColorGlobal(){

        $colors = Color::all();
        return response()->json($colors);

    }



    public function GetColorGlobalx(Request $request){

        if ($request->ajax()) {
            $data = Color::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        return '<a href="javascript:void(0)" class="select-col"  data-id="'.$row->id.'" data-name="'.$row->color_name.'">Select</a>';

                    })

                    // ->addColumn('qr_code', function($row){ return QrCode::size(30)->generate($row->color_code);})

                    ->rawColumns(['action'])

                    ->make(true);
                 

        }

    }

   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function StoreColor(Request $request)
    {
        if( $request->color_id == ""){

            $request->validate([
                'color_code' => 'required|unique:colors|max:200',
                'color_name' => 'required',
    
            ]);

            $post = Color::updateOrCreate([

   
                'id' => $request->color_id
        
                 ],[
                    'color_code' => $request->color_code,
                    'color_name' => $request->color_name,
        
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
                'color_code' => 'required|max:200',
                'color_name' => 'required',
    
            ]);

            $post = Color::updateOrCreate([

   
                'id' => $request->color_id
        
                 ],[
                    'color_code' => $request->color_code,
                    'color_name' => $request->color_name,
        
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
    

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function EditColor($id)
    {

        $colors = Color::find($id);
        return response()->json($colors);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function DeleteColor($id)
    {
        Color::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
    }
}
