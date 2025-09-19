<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;

class CategorieController extends Controller
{
    public function Allcategory()
    {
        return view('backend.categorie.all_categorie');
    }

    public function Getcategory(Request $request){

        if ($request->ajax()) {
            $data = Categorie::latest()->get();
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
                                              class="dropdown-item editCategory" data-id="'.$row->id.'"> &nbsp; Edit</a>
                                   
                          
                                          <a href="javascript:void(0)"
                                              class="dropdown-item text-danger deleteCategory"
                                           data-id="'.$row->id.'"> &nbsp; Delete</a>
                                   

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';

                    })

                    // ->addColumn('qr_code', function($row){ return QrCode::size(30)->generate($row->code);})

                    ->rawColumns(['action'])

                    ->make(true);
                
        }

    }

    public function GetCategoryGlobal(): JsonResponse   
    {
        $categories = Categorie::select('id', 'name')->get();  // Fetch only necessary fields
        return response()->json($categories);
    }

    public function StoreCategory(Request $request)
    {
        if( $request->category_id == ""){

            $request->validate([
                'code' => 'required|unique:categories|max:200',
                'name' => 'required',
    
            ]);

            $post = Categorie::updateOrCreate([

   
                'id' => $request->category_id
        
                 ],[
                    'code' => $request->code,
                    'name' => $request->name,
        
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
                'code' => 'required|max:200',
                'name' => 'required',
    
            ]);

            $post = Categorie::updateOrCreate([

   
                'id' => $request->category_id
        
                 ],[
                    'code' => $request->code,
                    'name' => $request->name,
        
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

   

    public function EditCategory($id)
    {

        $categorys = Categorie::find($id);
        return response()->json($categorys);
    }

   

    public function Deletecategory($id)
    {
        Categorie::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
    }
}
