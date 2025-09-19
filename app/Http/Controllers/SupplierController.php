<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Allsupplier()
    {
        return view('backend.supplier.all_supplier');
    }

    public function Getsupplier(Request $request){

        if ($request->ajax()) {
            $data = Supplier::latest()->get();
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
                                              class="dropdown-item  editsupplier" data-id="'.$row->id.'"> &nbsp; Edit</a>
                                   
                          
                                          <a href="javascript:void(0)"
                                              class="dropdown-item text-danger deletesupplier"
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


    public function GetSupplierin(Request $request){
        if ($request->ajax()) {
            $data = Supplier::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
    
                        return '<a href="javascript:void(0)" class="select-sup"  data-id="'.$row->id.'" data-nama="'.$row->supplier_name.'">Select</a>';
    
                    })
                  
                    ->rawColumns(['action'])
    
                    ->make(true);
                 
    
        }
    }

    public function GetsupplierGlobal(Request $request){
        $purchaseRequestId = $request->input('idx');

        $suppliers = Supplier::latest()->get();
        return response()->json($suppliers);
    }



    
    public function Storesupplier(Request $request)
    {
        if( $request->supplier_id == ""){
            $request->validate([
                'supplier_code' => 'required|unique:suppliers|max:200',
                'supplier_name' => 'required',
                'supplier_npwp' => 'required',
                'supplier_address' => 'required',
    
                'supplier_person' => 'required',
        
    
            ]);
    
            

    
           $post = Supplier::updateOrCreate([
    
       
            'id' => $request->supplier_id
    
             ],[
                'supplier_code' => $request->supplier_code,
                'supplier_name' => $request->supplier_name,
                'supplier_npwp' => $request->supplier_npwp,
                'supplier_fax' => $request->supplier_fax,
                'supplier_address' => $request->supplier_address,
                'supplier_city' => $request->supplier_city,
                'supplier_nation' => $request->supplier_nation,
                'supplier_person' => $request->supplier_person,
                'supplier_phone' => $request->supplier_phone,
                'supplier_email' => $request->supplier_email,
                'remark' => $request->remark,
    
            ]);
    
    
            //return response
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $post,
                'alert-type' => 'success'  
            ]);
        }
        else 
        {
            $request->validate([
                'supplier_name' => 'required',
                'supplier_npwp' => 'required',
                'supplier_address' => 'required',
                'supplier_city' => 'required',
                'supplier_nation' => 'required',
                'supplier_person' => 'required',
                'supplier_phone' => 'required',
    
            ]);
    
            
    
           $post = Supplier::updateOrCreate([
    
       
            'id' => $request->supplier_id
    
             ],[
                'supplier_code' => $request->supplier_code,
                'supplier_name' => $request->supplier_name,
                'supplier_npwp' => $request->supplier_npwp,
                'supplier_fax' => $request->supplier_fax,
                'supplier_address' => $request->supplier_address,
                'supplier_city' => $request->supplier_city,
                'supplier_nation' => $request->supplier_nation,
                'supplier_person' => $request->supplier_person,
                'supplier_phone' => $request->supplier_phone,
                'supplier_email' => $request->supplier_email,
                'remark' => $request->remark,
    
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
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function Editsupplier($id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
  

    /**
     * Remove the specified resource from storage.
     */
    public function Deletesupplier($id)
    {
        // dd($id);
        Supplier::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Supplier Berhasil Dihapus!.',
        ]);
    }
}
