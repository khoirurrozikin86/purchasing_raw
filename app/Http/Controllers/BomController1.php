<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Cbd;
use Illuminate\Http\Request;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BomExport;

class BomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Allbom()
    {
        return view('bom.all_bom');
    }

    public function Addbom()
    {
        return view('bom.add_bom');
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
    public function Storebom(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'style' => 'required|string',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.item_id' => 'required|string',
            'items.*.sizes' => 'required|array',
            'items.*.sizes.*' => 'nullable', // Konsumsi boleh null
        ]);

        // Buat entri BOM di tabel `boms`
        $bom = Bom::create([
            'bom_no' => 'BOM-' . time(), // Generate BOM No unik
            'cbd_id' => $validated['cbd_id'],
            'style' => $validated['style'],
        ]);


        foreach ($validated['items'] as $item) {
            foreach ($item['sizes'] as $size => $consumption) {
                if ($consumption !== null) {
                    BomDetail::create([
                        'bom_id' => $bom->id,
                        'item_id' => $item['item_id'],
                        'size' => $size !== 'null' ? $size : null, // Tangani size null
                        'consumption' => $consumption,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'BOM created successfully!',
            'bom' => $bom,
            'details' => $bom->details,
        ], 201);
    }



    public function Getbom(Request $request)
    {
        if ($request->ajax()) {
            // Query BOM dengan relasi ke details, item, unit, dan category, serta sorting pada details
            $data = Bom::with([
                'details' => function ($query) {
                    $query->orderBy('size', 'asc'); // Urutkan size secara ascending
                },
                'details.item.unit',
                'details.item.category'
            ])->orderBy('created_at', 'desc') // Urutkan data berdasarkan created_at
                ->orderBy('style', 'asc') // Urutkan style secara ascending

                ->get();

            return Datatables::of($data)
                ->addIndexColumn() // Tambahkan kolom index
                ->addColumn('action', function ($row) {
                    // Tombol aksi (edit, delete, dll.)
                    return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center">
                                <div class="actions dropdown">
                                    <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                    <div class="dropdown-menu" role="menu">
                                        <a href="/edit/bom/' . $row->id . '" class="dropdown-item text-primary"> &nbsp; Edit</a>
                                        <a href="javascript:void(0)" class="dropdown-item text-danger deleteBom" data-id="' . $row->id . '"> &nbsp; Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                })
                ->addColumn('size', function ($row) {
                    // Gabungkan ukuran dari BOM Detail
                    $sizes = '<ul>';
                    foreach ($row->details as $detail) {
                        $sizes .= '<li>' . $detail->size . '</li>';
                    }
                    $sizes .= '</ul>';
                    return $sizes;
                })
                ->addColumn('item_code', function ($row) {
                    // Gabungkan item code dari BOM Detail
                    $itemCodes = '<ul>';
                    foreach ($row->details as $detail) {
                        $itemCodes .= '<li>' . ($detail->item->item_code ?? 'N/A') . '</li>';
                    }
                    $itemCodes .= '</ul>';
                    return $itemCodes;
                })
                ->addColumn('item_name', function ($row) {
                    // Gabungkan item name dari BOM Detail
                    $itemNames = '<ul>';
                    foreach ($row->details as $detail) {
                        $itemNames .= '<li>' . ($detail->item->item_name ?? 'N/A') . '</li>';
                    }
                    $itemNames .= '</ul>';
                    return $itemNames;
                })
                ->addColumn('unit', function ($row) {
                    // Gabungkan unit dari BOM Detail
                    $units = '<ul>';
                    foreach ($row->details as $detail) {
                        $units .= '<li>' . ($detail->item->unit->unit_code ?? 'N/A') . '</li>';
                    }
                    $units .= '</ul>';
                    return $units;
                })
                ->addColumn('category', function ($row) {
                    // Gabungkan kategori dari BOM Detail
                    $categories = '<ul>';
                    foreach ($row->details as $detail) {
                        $categories .= '<li>' . ($detail->item->category->name ?? 'N/A') . '</li>';
                    }
                    $categories .= '</ul>';
                    return $categories;
                })
                ->addColumn('consumption', function ($row) {
                    // Gabungkan konsumsi dari BOM Detail
                    $consumptions = '<ul>';
                    foreach ($row->details as $detail) {
                        $consumptions .= '<li>' . $detail->consumption . '</li>';
                    }
                    $consumptions .= '</ul>';
                    return $consumptions;
                })
                ->rawColumns(['action', 'size', 'item_code', 'item_name', 'unit', 'category', 'consumption']) // Kolom yang mengandung HTML
                ->make(true);
        }
    }


    public function Getbomall()
    {
        $boms = Bom::with('details')->get();
        return response()->json($boms);
    }


    public function Getbomdetails(Request $request)
    {
        $bomId = $request->get('bom_id');
        $cbdId = $request->get('cbd_id'); // Ambil cbd_id dari request

        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Ambil CBD dan detailnya
        $cbd = Cbd::with('details')->findOrFail($cbdId);

        // Kelompokkan BOM Details berdasarkan size
        $bomDetailsGrouped = $bom->details->groupBy('size');

        // Proses CBD Details untuk menggabungkan data BOM dan CBD
        $details = collect();

        // Iterasi semua item BOM
        foreach ($bom->details as $bomDetail) {
            if (empty($bomDetail->size)) {
                // Jika item tidak memiliki size, ambil qty global dari CBD berdasarkan warna
                foreach ($cbd->details->groupBy('color') as $color => $cbdDetailsForColor) {
                    $globalQty = $cbdDetailsForColor->sum('qty'); // Total qty global untuk warna ini
                    $details->push([
                        'item_id' => $bomDetail->item_id ?? null,
                        'item_code' => $bomDetail->item->item_code ?? '',
                        'item_name' => $bomDetail->item->item_name ?? '',
                        'unit' => $bomDetail->item->unit->unit_code ?? '',
                        'color' => $color ?? '',
                        'size' => '-', // Tandai bahwa item ini tidak memiliki size
                        'qty' => $globalQty,
                        'consumption' => $bomDetail->consumption ?? 0,
                    ]);
                }
            }
        }

        // Iterasi semua CBD Detail
        foreach ($cbd->details as $cbdDetail) {
            // Ambil semua BOM detail yang sesuai dengan size dari CBD Detail
            $bomDetailsForSize = $bomDetailsGrouped->get($cbdDetail->size, collect());

            if ($bomDetailsForSize->isNotEmpty()) {
                foreach ($bomDetailsForSize as $bomDetail) {
                    $details->push([
                        'item_id' => $bomDetail->item_id ?? null,
                        'item_code' => $bomDetail->item->item_code ?? '',
                        'item_name' => $bomDetail->item->item_name ?? '',
                        'unit' => $bomDetail->item->unit->unit_code ?? '',
                        'color' => $cbdDetail->color ?? '',
                        'size' => $cbdDetail->size ?? '',
                        'qty' => $cbdDetail->qty ?? 0,
                        'consumption' => $bomDetail->consumption ?? 0,
                    ]);
                }
            } else {
                // Jika tidak ada BOM detail untuk ukuran ini, tambahkan hanya data dari CBD Detail
                $details->push([
                    'item_id' => null,
                    'item_code' => '',
                    'item_name' => '',
                    'unit' => '',
                    'color' => $cbdDetail->color ?? '',
                    'size' => $cbdDetail->size ?? '',
                    'qty' => $cbdDetail->qty ?? 0,
                    'consumption' => 0,
                ]);
            }
        }

        // Urutkan berdasarkan item_id
        $sortedDetails = $details->sortBy('item_id')->values();

        return response()->json(['details' => $sortedDetails]); // Kembalikan data sebagai array
    }



    public function Getbomdetails5(Request $request)
    {
        $bomId = $request->get('bom_id');
        $cbdId = $request->get('cbd_id'); // Ambil cbd_id dari request

        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Ambil CBD dan detailnya
        $cbd = Cbd::with('details')->findOrFail($cbdId);

        // Kelompokkan BOM Details berdasarkan size
        $bomDetailsGrouped = $bom->details->groupBy('size');

        // Proses CBD Details untuk menggabungkan data BOM dan CBD
        $details = collect();

        foreach ($cbd->details as $cbdDetail) {
            // Ambil semua BOM detail yang sesuai dengan size dari CBD Detail
            $bomDetailsForSize = $bomDetailsGrouped->get($cbdDetail->size, collect());

            // Jika ada BOM detail untuk ukuran ini, tambahkan setiap item terkait ukuran ini
            if ($bomDetailsForSize->isNotEmpty()) {
                foreach ($bomDetailsForSize as $bomDetail) {
                    $details->push([
                        'item_id' => $bomDetail->item_id ?? null,
                        'item_code' => $bomDetail->item->item_code ?? '',
                        'item_name' => $bomDetail->item->item_name ?? '',
                        'unit' => $bomDetail->item->unit->unit_code ?? '',
                        'color' => $cbdDetail->color ?? '',
                        'size' => $cbdDetail->size ?? '',
                        'qty' => $cbdDetail->qty ?? 0,
                        'consumption' => $bomDetail->consumption ?? 0,
                    ]);
                }
            } else {
                // Jika tidak ada BOM detail untuk ukuran ini, tambahkan hanya data dari CBD Detail
                $details->push([
                    'item_id' => null,
                    'item_code' => '',
                    'item_name' => '',
                    'unit' => '',
                    'color' => $cbdDetail->color ?? '',
                    'size' => $cbdDetail->size ?? '',
                    'qty' => $cbdDetail->qty ?? 0,
                    'consumption' => 0,
                ]);
            }
        }

        // Urutkan berdasarkan item_id
        $sortedDetails = $details->sortBy('item_id')->values();

        return response()->json(['details' => $sortedDetails]); // Kembalikan data sebagai array
    }




    public function Getbomdetails4(Request $request)
    {
        $bomId = $request->get('bom_id');
        $cbdId = $request->get('cbd_id'); // Ambil cbd_id dari request

        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Ambil CBD dan detailnya
        $cbd = Cbd::with('details')->findOrFail($cbdId);

        // Kelompokkan BOM Details berdasarkan size
        $bomDetailsGrouped = $bom->details->groupBy('size');

        // Proses CBD Details untuk menggabungkan data BOM dan CBD
        $details = collect();

        foreach ($cbd->details as $cbdDetail) {
            // Ambil semua BOM detail yang sesuai dengan size dari CBD Detail
            $bomDetailsForSize = $bomDetailsGrouped->get($cbdDetail->size, collect());

            // Jika ada BOM detail untuk ukuran ini, tambahkan setiap item terkait ukuran ini
            if ($bomDetailsForSize->isNotEmpty()) {
                foreach ($bomDetailsForSize as $bomDetail) {
                    $details->push([
                        'item_id' => $bomDetail->item_id ?? null,
                        'item_code' => $bomDetail->item->item_code ?? '',
                        'item_name' => $bomDetail->item->item_name ?? '',
                        'unit' => $bomDetail->item->unit->unit_code ?? '',
                        'color' => $cbdDetail->color ?? '',
                        'size' => $cbdDetail->size ?? '',
                        'qty' => $cbdDetail->qty ?? 0,
                        'consumption' => $bomDetail->consumption ?? 0,
                    ]);
                }
            } else {
                // Jika tidak ada BOM detail untuk ukuran ini, tambahkan hanya data dari CBD Detail
                $details->push([
                    'item_id' => null,
                    'item_code' => '',
                    'item_name' => '',
                    'unit' => '',
                    'color' => $cbdDetail->color ?? '',
                    'size' => $cbdDetail->size ?? '',
                    'qty' => $cbdDetail->qty ?? 0,
                    'consumption' => 0,
                ]);
            }
        }

        return response()->json(['details' => $details->values()]); // Kembalikan data sebagai array
    }



    public function Getbomdetails3(Request $request)
    {
        $bomId = $request->get('bom_id');
        $cbdId = $request->get('cbd_id'); // Ambil cbd_id dari request

        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Ambil CBD dan detailnya
        $cbd = Cbd::with('details')->findOrFail($cbdId);

        // Kelompokkan BOM Details berdasarkan size
        $bomDetailsGrouped = $bom->details->groupBy('size');

        // Proses CBD Details untuk menggabungkan data BOM dan CBD
        $details = $cbd->details->map(function ($cbdDetail) use ($bomDetailsGrouped) {
            // Cari BOM detail yang sesuai dengan size dari CBD Detail
            $bomDetail = $bomDetailsGrouped->get($cbdDetail->size, collect())->first();

            return [
                'item_id' => $bomDetail->item_id ?? null,
                'item_code' => $bomDetail->item->item_code ?? '',
                'item_name' => $bomDetail->item->item_name ?? '',
                'unit' => $bomDetail->item->unit->unit_code ?? '',
                'color' => $cbdDetail->color ?? '',
                'size' => $cbdDetail->size ?? '',
                'qty' => $cbdDetail->qty ?? 0,
                'consumption' => $bomDetail->consumption ?? 0,
            ];
        });

        return response()->json(['details' => $details->values()]); // Kembalikan data sebagai array
    }






    public function Getbomdetails2(Request $request)
    {
        $bomId = $request->get('bom_id');
        $cbdId = $request->get('cbd_id'); // Ambil cbd_id dari request

        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Cari CBD berdasarkan cbd_id dan ambil detailnya
        $cbd = Cbd::with('details')->findOrFail($cbdId);

        // Kelompokkan CBD Details berdasarkan size
        $cbdDetailsGrouped = $cbd->details->groupBy('size');

        // Proses BOM Details dengan qty dari CBD Details
        $details = $bom->details->map(function ($detail) use ($cbdDetailsGrouped) {
            // Ambil qty dari CBD Details berdasarkan size
            $qty = $cbdDetailsGrouped->get($detail->size, collect())->pluck('qty')->sum();

            return [
                'item_id' => $detail->item_id,
                'item_code' => $detail->item->item_code ?? '',
                'item_name' => $detail->item->item_name ?? '',
                'unit' => $detail->item->unit->unit_code ?? '',
                'color' => $detail->color ?? '',
                'size' => $detail->size ?? '',
                'qty' => $qty, // Sesuaikan qty berdasarkan size
                'consumption' => $detail->consumption ?? 0,
            ];
        });

        return response()->json(['details' => $details->values()]); // Kembalikan data sebagai array
    }


    public function Getbomdetails1(Request $request)
    {
        $bomId = $request->get('bom_id');

        // Ambil BOM dengan detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Urutkan berdasarkan size (null menjadi 'No Size')
        $details = $bom->details->sortBy(function ($detail) {
            return $detail->size ?? 'No Size'; // Jika size null, jadikan 'No Size'
        })->map(function ($detail) {
            return [
                'item_id' => $detail->item_id,
                'item_code' => $detail->item->item_code ?? '', // Ganti null dengan ""
                'item_name' => $detail->item->item_name ?? '', // Ganti null dengan ""
                'unit' => $detail->item->unit->unit_code ?? '', // Ganti null dengan ""
                'color' => $detail->color ?? '', // Ganti null dengan ""
                'size' => $detail->size ?? '', // Ganti null dengan ""
                'qty' => $detail->qty ?? 0, // Ganti null dengan 0
                'consumption' => $detail->consumption ?? 0, // Ganti null dengan 0
            ];
        });

        return response()->json(['details' => $details->values()]); // Pastikan mengembalikan array
    }



    public function Getbomdetailsx(Request $request)
    {
        $bomId = $request->get('bom_id');
        $bom = Bom::with('details.item')->findOrFail($bomId);

        $details = $bom->details->map(function ($detail) {
            return [
                'item_id' => $detail->item_id,
                'item_code' => $detail->item->item_code ?? '',
                'item_name' => $detail->item->item_name ?? '',
                'unit' => $detail->item->unit->unit_code ?? '',
                'color' => $detail->color,
                'size' => $detail->size,
                'qty' => $detail->qty,
                'consumption' => $detail->consumption,
            ];
        });

        return response()->json(['details' => $details]);
    }




    public function Getbomx(Request $request)
    {
        if ($request->ajax()) {
            // Query BOM dengan relasi ke details dan item
            $data = Bom::with(['details.item.unit', 'details.item.category'])->orderBy('created_at', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn() // Tambahkan kolom index
                ->addColumn('action', function ($row) {
                    // Tombol aksi (edit, delete, dll.)
                    return '<div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center">
                                <div class="actions dropdown">
                                    <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                    <div class="dropdown-menu" role="menu">
                                        <a href="/edit/bom/' . $row->id . '" class="dropdown-item text-primary"> &nbsp; Edit</a>
                                        <a href="javascript:void(0)" class="dropdown-item text-danger deleteBom" data-id="' . $row->id . '"> &nbsp; Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                })
                ->addColumn('size', function ($row) {
                    // Gabungkan ukuran dari BOM Detail
                    $sizes = '<ul>';
                    foreach ($row->details as $detail) {
                        $sizes .= '<li>' . $detail->size . '</li>';
                    }
                    $sizes .= '</ul>';
                    return $sizes;
                })
                ->addColumn('item_code', function ($row) {
                    // Gabungkan item code dari BOM Detail
                    $itemCodes = '<ul>';
                    foreach ($row->details as $detail) {
                        $itemCodes .= '<li>' . ($detail->item->item_code ?? 'N/A') . '</li>';
                    }
                    $itemCodes .= '</ul>';
                    return $itemCodes;
                })
                ->addColumn('item_name', function ($row) {
                    // Gabungkan item name dari BOM Detail
                    $itemNames = '<ul>';
                    foreach ($row->details as $detail) {
                        $itemNames .= '<li>' . ($detail->item->item_name ?? 'N/A') . '</li>';
                    }
                    $itemNames .= '</ul>';
                    return $itemNames;
                })
                ->addColumn('unit', function ($row) {
                    // Gabungkan item name dari BOM Detail
                    $itemNames = '<ul>';
                    foreach ($row->details as $detail) {
                        $itemNames .= '<li>' . ($detail->item->unit->unit_code ?? 'N/A') . '</li>';
                    }
                    $itemNames .= '</ul>';
                    return $itemNames;
                })
                ->addColumn('unit', function ($row) {
                    // Gabungkan item name dari BOM Detail
                    $itemNames = '<ul>';
                    foreach ($row->details as $detail) {
                        $itemNames .= '<li>' . ($detail->item->unit->unit_code ?? 'N/A') . '</li>';
                    }
                    $itemNames .= '</ul>';
                    return $itemNames;
                })
                ->addColumn('category', function ($row) {
                    // Gabungkan item name dari BOM Detail
                    $itemNames = '<ul>';
                    foreach ($row->details as $detail) {
                        $itemNames .= '<li>' . ($detail->item->category->name ?? 'N/A') . '</li>';
                    }
                    $itemNames .= '</ul>';
                    return $itemNames;
                })
                ->addColumn('consumption', function ($row) {
                    // Gabungkan konsumsi dari BOM Detail
                    $consumptions = '<ul>';
                    foreach ($row->details as $detail) {
                        $consumptions .= '<li>' . $detail->consumption . '</li>';
                    }
                    $consumptions .= '</ul>';
                    return $consumptions;
                })
                ->rawColumns(['action', 'size', 'item_code', 'item_name', 'unit', 'category', 'consumption']) // Kolom yang mengandung HTML
                ->make(true);
        }
    }



    public function editBom($id)
    {
        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item.unit', 'details.item.category'])->findOrFail($id);
        // Default ukuran yang sudah ditentukan
        $defaultSizes = collect(['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL', '5XL']);

        // Ambil ukuran unik dari detail BOM
        $sizesFromDetails = $bom->details->pluck('size')->unique();

        // Ambil ukuran tambahan yang tidak ada di defaultSizes
        $additionalSizes = $sizesFromDetails->diff($defaultSizes);

        // Gabungkan ukuran default dan ukuran tambahan
        $allSizes = $defaultSizes->merge($additionalSizes);

        return view('bom.edit_bom', compact('bom', 'allSizes'));
    }

    public function Updatebom(Request $request, $id)
    {
        $request->validate([
            'style' => 'required|string|max:255',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.sizes' => 'required|array',
            'items.*.sizes.*' => 'nullable', // Konsumsi boleh null
        ]);

        try {
            \DB::beginTransaction();

            // Cari BOM
            $bom = Bom::findOrFail($id);

            // Perbarui data BOM
            $bom->update([
                'style' => $request->style,
                'cbd_id' => $request->cbd_id,
            ]);

            // Hapus semua detail lama
            $bom->details()->delete();

            // Tambahkan detail baru
            $details = [];
            foreach ($request->items as $item) {
                foreach ($item['sizes'] as $size => $consumption) {
                    // Konversi size "null" atau 0 ke null
                    if ($consumption !== null) {
                        $details[] = [
                            'bom_id' => $bom->id,
                            'item_id' => $item['item_id'],
                            'size' => ($size === 'null' || $size === 0) ? null : $size, // Tangani size null
                            'consumption' => $consumption,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

            // Batch insert untuk menyimpan detail
            if (!empty($details)) {
                BomDetail::insert($details);
            }

            \DB::commit();

            return response()->json(['message' => 'BOM updated successfully!'], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => 'Failed to update BOM!', 'error' => $e->getMessage()], 500);
        }
    }





    public function Updatebomx(xRequest $request, $id)
    {
        $request->validate([
            'style' => 'required|string|max:255',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
        ]);

        $bom = Bom::findOrFail($id);
        $bom->update([
            'style' => $request->style,
            'cbd_id' => $request->cbd_id,
        ]);

        // Hapus detail lama
        $bom->details()->delete();

        // Tambahkan detail baru
        foreach ($request->items as $item) {
            foreach ($item['sizes'] as $size => $consumption) {
                if ($consumption) {
                    $bom->details()->create([
                        'item_id' => $item['item_id'],
                        'size' => $size,
                        'consumption' => $consumption,
                    ]);
                }
            }
        }

        return response()->json(['message' => 'BOM updated successfully!'], 200);
    }

    public function exportBom()
    {
        return Excel::download(new BomExport, 'bom_export.xlsx');
    }


    public function Deletebom($id)
    {
        $bom = Bom::findOrFail($id);
        $bom->details()->delete(); // Delete associated details
        $bom->delete(); // Delete the Cbd record
        return response()->json([
            'success' => true,
            'message' => 'Data Bom Berhasil Dihapus!.',
        ]);
    }
}
