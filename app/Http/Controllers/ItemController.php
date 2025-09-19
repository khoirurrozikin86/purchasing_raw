<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemsImport;
use App\Exports\ItemsExport;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Allitem()
    {
        return view('backend.item.all_item');
    }
    public function Additem()
    {
        return view('backend.item.add_item');
    }



    public function Getitem(Request $request){

        if ($request->ajax()) {     
            $items = Item::with(['category', 'unit'])->latest()->get();
            return Datatables::of($items)
                    ->addIndexColumn()
                    ->addColumn('category', function($row) {
                        return $row->category->name;
                    })
                    ->addColumn('unit', function($row) {
                        return $row->unit->unit_code;
                    })

                    ->addColumn('action', function($row){


                      return   '<div class="d-flex align-items-center justify-content-between flex-wrap">
                      <div class="d-flex align-items-center">
                        
                          <div class="d-flex align-items-center">
                              <div class="actions dropdown">
                                  <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                  <div class="dropdown-menu" role="menu">
                                    
                                  
                                          <a href="javascript:void(0)"
                                              class="dropdown-item editItem" data-id="'.$row->id.'"> &nbsp; Edit</a>
                                   
                          
                                          <a href="javascript:void(0)"
                                              class="dropdown-item text-danger deleteItem"
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



    public function GetItemCount()
    {
        // Hitung jumlah total karyawan
        $itemCount = Item::count();

        // Return the total item count as a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Total item count retrieved successfully',
            'data' => [
                'item_count' => $itemCount
            ]
        ]);
    }


    public function Checkitem(Request $request)

    {

        $id = $request->input('sku');
        $user = Item::where('code',$id)->first();

        if ($user) {                
            return response()->json($user);
        } else {
            return response()->json(['nama' => 'SKU tidak ditemukan']);
        }

        // return response()->json($user);

    }

    public function Getitemglobal(){
        $items = Item::with(['category', 'unit'])->get();
        return response()->json($items);
    }


public function storeItem(Request $request)
{
    // Validate input data
    $request->validate([
        'item_code' => 'required|string|max:5000|unique:items,item_code,' . $request->item_idx, // Check for unique item_code
        'item_name' => 'required|string|max:1000',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'unit_id' => 'required|exists:units,id',
        'remark' => 'nullable|string',
    ]);

    // Prepare data for saving
    $data = [
        'item_code' => $request->item_code,
        'item_name' => $request->item_name,
        'description' => $request->description,
        'category_id' => $request->category_id,
        'unit_id' => $request->unit_id,
        'remark' => $request->remark,
    ];

    // If item_idx is provided, update or create based on the id
    $item = Item::updateOrCreate(
        ['id' => $request->item_idx], // If the item already exists (update)
        $data // Otherwise, create a new item
    );

    // Return success response
    return response()->json([
        'success' => true,
        'message' => 'Data Berhasil Disimpan!',
        'data'    => $item,
        'alert-type' => 'success',
    ]);
}





    public function StoreItem0(Request $request)
    {
        if( $request->item_idx == ""){

            $request->validate([
                'item_code' => 'required|string|max:50',
                'item_name' => 'required|string|max:100',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'unit_id' => 'required|exists:units,id',
                'remark' => 'nullable|string',
           
    
            ]);

            $post = Item::updateOrCreate([

   
                'id' => $request->item_idx
        
                 ],[
                    'item_code' => $request->item_code,
                    'item_name' => $request->item_name,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'unit_id' => $request->unit_id,
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
        else{
            $request->validate([
                'item_code' => 'required|string|max:50',
                'item_name' => 'required|string|max:100',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'unit_id' => 'required|exists:units,id',
                'remark' => 'nullable|string',
    
            ]);

            $post = Item::updateOrCreate([

   
                'id' => $request->item_idx
        
                 ],[
                    'item_code' => $request->item_code,
                    'item_name' => $request->item_name,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'unit_id' => $request->unit_id,
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

  


    public function Edititem($id)
    {
        $items = item::find($id);
        return response()->json($items);
    }

   

    public function DeleteItem($id)
    {
        Item::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
    }

    public function Printitem()
    {
     
        return view('backend.item.print');
    }

    
    public function GetPosisi(Request $request){

        // $posisi= $request->input('posisi');

          // Fetch employee positions for the specified department
          $data = Item::distinct()->pluck('posisi');

          return response()->json($data);

        

    }


    public function exportPDF(Request $request)
    {

           // Validate the input
           $request->validate([
            'unit' => 'required|string'
        ]);

         // Get the position from the request
         $position = $request->input('posisi');

         // Fetch employees with the specified position
         $items = Item::where('posisi', $position)->get();


        foreach ($items as $item) {
            $qrCode = QrCode::size(100)->generate($item->code);
            $item->qr_code = $qrCode;

        }

        return view('backend.item.pdf', compact('items'));
    }


    public function Importitems()
    {
        return view('backend.item.import_item');
    }

    public function Importitem(Request $request)
    {
        $cek = Excel::import(new itemsImport, $request->file('import_file'));

    
            $notification = array(
                'message' => 'Import Successfully',
                'alert-type' => 'success'
            );
   
    
        return redirect()->route('all.item')->with($notification);
    } //end method


    public function Exportitem()
    {
        return Excel::download(new ItemsExport, 'items.xlsx');
    }




    
}
