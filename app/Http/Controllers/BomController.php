<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Cbd;
use Illuminate\Http\Request;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BomExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $validated = $request->validate([
            'style' => 'required|string',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.item_id' => 'required|string',
            'items.*.colors' => 'nullable|array',
            'items.*.colors.*.color' => 'nullable|string',
            'items.*.colors.*.sizes' => 'nullable|array',
            'items.*.colors.*.sizes.*' => 'nullable',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Buat entri BOM
                $bom = Bom::create([
                    'cbd_id' => $validated['cbd_id'],
                    'style' => $validated['style'],
                    'bom_no' => 'BOM-' . time(),
                ]);

                // Proses data items
                foreach ($validated['items'] as $item) {
                    foreach ($item['colors'] as $color) {
                        foreach ($color['sizes'] as $size => $consumption) {
                            if ($consumption !== null) {
                                // Cek jika data sudah ada
                                $exists = BomDetail::where([
                                    'bom_id' => $bom->id,
                                    'item_id' => $item['item_id'],
                                    'size' => $size !== 'null' ? $size : null,
                                    'remark1' => $color['color'] === 'NO COLOR' ? null : $color['color'],
                                ])->exists();

                                if (!$exists) {
                                    // Simpan detail BOM jika belum ada
                                    BomDetail::create([
                                        'bom_id' => $bom->id,
                                        'item_id' => $item['item_id'],
                                        'size' => $size !== 'null' ? $size : null,
                                        'remark1' => $color['color'] === 'NO COLOR' ? null : $color['color'],
                                        'consumption' => $consumption,
                                    ]);
                                }
                            }
                        }
                    }
                }
            });

            return response()->json([
                'message' => 'BOM created successfully!',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create BOM.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

   public function StorebomXXX(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'style' => 'required|string',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.item_id' => 'required|string',
            'items.*.colors' => 'nullable|array',
            'items.*.colors.*.color' => 'nullable|string',
            'items.*.colors.*.sizes' => 'nullable|array',
            'items.*.colors.*.sizes.*' => 'nullable',
        ]);

        try {
            // Gunakan transaksi database untuk memastikan konsistensi data
            DB::transaction(function () use ($validated) {
                // Cari atau buat entri BOM
                $bom = Bom::firstOrCreate(
                    [
                        'cbd_id' => $validated['cbd_id'],
                        'style' => $validated['style'],
                    ],
                    [
                        'bom_no' => 'BOM-' . time(), // Generate nomor BOM unik
                    ]
                );

                // Proses data items
                foreach ($validated['items'] as $item) {
                    foreach ($item['colors'] as $color) {
                        foreach ($color['sizes'] as $size => $consumption) {
                            if ($consumption !== null) {
                                // Simpan atau update detail BOM
                                BomDetail::updateOrCreate(
                                    [
                                        'bom_id' => $bom->id,
                                        'item_id' => $item['item_id'],
                                        'size' => $size !== 'null' ? $size : null,
                                        'remark1' => $color['color'] === 'NO COLOR' ? null : $color['color'],
                                    ],
                                    [
                                        'consumption' => $consumption,
                                    ]
                                );
                            }
                        }
                    }
                }
            });

            return response()->json([
                'message' => 'BOM created successfully!',
            ], 201);
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan
            return response()->json([
                'message' => 'Failed to create BOM.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function StorebomXX(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'style' => 'required|string',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.item_id' => 'required|string',
            'items.*.colors' => 'nullable|array',
            'items.*.colors.*.color' => 'nullable|string',
            'items.*.colors.*.sizes' => 'nullable|array',
            'items.*.colors.*.sizes.*' => 'nullable',
        ]);

        try {
            // Gunakan transaksi database untuk memastikan konsistensi data
            DB::transaction(function () use ($validated) {
                // Cari atau buat entri BOM
                $bom = Bom::firstOrCreate(
                    [
                        'cbd_id' => $validated['cbd_id'],
                        'style' => $validated['style'],
                    ],
                    [
                        'bom_no' => 'BOM-' . time(), // Generate nomor BOM unik
                    ]
                );

                // Proses data items
                foreach ($validated['items'] as $item) {
                    foreach ($item['colors'] as $color) {
                        foreach ($color['sizes'] as $size => $consumption) {
                            if ($consumption !== null) {
                                // Simpan atau update detail BOM
                                BomDetail::updateOrCreate(
                                    [
                                        'bom_id' => $bom->id,
                                        'item_id' => $item['item_id'],
                                        'size' => $size !== 'null' ? $size : null,
                                        'remark1' => $color['color'] === 'NO COLOR' ? null : $color['color'],
                                    ],
                                    [
                                        'consumption' => $consumption,
                                    ]
                                );
                            }
                        }
                    }
                }
            });

            return response()->json([
                'message' => 'BOM created successfully!',
            ], 201);
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan
            return response()->json([
                'message' => 'Failed to create BOM.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function Storebom1(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'style' => 'required|string',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.item_id' => 'required|string',
            'items.*.colors' => 'nullable|array',
            'items.*.colors.*.color' => 'nullable|string',
            'items.*.colors.*.sizes' => 'nullable|array',
            'items.*.colors.*.sizes.*' => 'nullable',
        ]);

        // Buat entri BOM di tabel `boms`
        $bom = Bom::create([
            'bom_no' => 'BOM-' . time(), // Generate BOM No unik
            'cbd_id' => $validated['cbd_id'],
            'style' => $validated['style'],
        ]);

        // Loop melalui setiap item
        foreach ($validated['items'] as $item) {
            // Loop melalui setiap warna
            foreach ($item['colors'] as $color) {
                // Loop melalui setiap ukuran dan konsumsi
                foreach ($color['sizes'] as $size => $consumption) {
                    if ($consumption !== null) {
                        BomDetail::create([
                            'bom_id' => $bom->id,
                            'item_id' => $item['item_id'],
                            'size' => $size !== 'null' ? $size : null, // Tangani size null
                            'consumption' => $consumption,
                            'remark1' => $color['color'] === 'NO COLOR' ? null : $color['color'], // Tangani warna "NO COLOR" sebagai null
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'BOM created successfully!',
            'bom' => $bom,
            'details' => $bom->details,
        ], 201);
    }





    public function Storebomz(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'style' => 'required|string',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.item_id' => 'required|string',
            'items.*.colors' => 'required|array',
            'items.*.colors.*.color' => 'required|string',
            'items.*.colors.*.sizes' => 'required|array',
            'items.*.colors.*.sizes.*' => 'nullable', // Konsumsi boleh null
        ]);

        // Buat entri BOM di tabel `boms`
        $bom = Bom::create([
            'bom_no' => 'BOM-' . time(), // Generate BOM No unik
            'cbd_id' => $validated['cbd_id'],
            'style' => $validated['style'],
        ]);

        // Loop melalui setiap item
        foreach ($validated['items'] as $item) {
            // Loop melalui setiap warna
            foreach ($item['colors'] as $color) {
                // Loop melalui setiap ukuran dan konsumsi
                foreach ($color['sizes'] as $size => $consumption) {
                    if ($consumption !== null) {
                        BomDetail::create([
                            'bom_id' => $bom->id,
                            'item_id' => $item['item_id'],
                            'size' => $size !== 'null' ? $size : null, // Tangani size null
                            'consumption' => $consumption,
                            'remark1' => $color['color'], // Simpan warna ke kolom `remark1`
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'BOM created successfully!',
            'bom' => $bom,
            'details' => $bom->details,
        ], 201);
    }


    public function Storebomx(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'style' => 'required|string',
            'cbd_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.item_id' => 'required|string',
            'items.*.color' => 'nullable|string', // Tambahkan validasi untuk color
            'items.*.sizes' => 'required|array',
            'items.*.sizes.*' => 'nullable', // Konsumsi boleh null
        ]);

        // Buat entri BOM di tabel `boms`
        $bom = Bom::create([
            'bom_no' => 'BOM-' . time(), // Generate BOM No unik
            'cbd_id' => $validated['cbd_id'],
            'style' => $validated['style'],
        ]);

        // Simpan detail BOM
        foreach ($validated['items'] as $item) {
            foreach ($item['sizes'] as $size => $consumption) {
                if ($consumption !== null) {
                    BomDetail::create([
                        'bom_id' => $bom->id,
                        'item_id' => $item['item_id'],
                        'size' => $size !== 'null' ? $size : null, // Tangani size null
                        'consumption' => $consumption,
                        'remark1' => $item['color'] ?? null, // Simpan color di kolom remark1
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

    public function StorebomNosize(Request $request)
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

                ->addColumn('remark1', function ($row) {
                    // Gabungkan ukuran dari BOM Detail
                    $remark1 = '<ul>';
                    foreach ($row->details as $detail) {
                        $remark1 .= '<li>' . $detail->remark1 . '</li>';
                    }
                    $remark1 .= '</ul>';
                    return $remark1;
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
                ->rawColumns(['action', 'size', 'remark1', 'item_code', 'item_name', 'unit', 'category', 'consumption']) // Kolom yang mengandung HTML
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

        // Proses data
        $details = collect();
        $uniqueKeys = []; // Array untuk menyimpan kombinasi unik size dan color

        foreach ($bom->details as $bomDetail) {
            // 1. Jika remark1 (color) dan size kosong di BOM, tambahkan global quantity
            if (empty($bomDetail->size) && empty($bomDetail->color) && empty($bomDetail->remark1)) {
                // Hitung total global qty dari seluruh data CBD
                $globalQty = $cbd->details->sum('qty');

                // Pastikan hanya menambahkan sekali
                $key = 'global-' . $bomDetail->item_id;
                if (in_array($key, $uniqueKeys)) {
                    continue; // Lewati jika kombinasi sudah ada
                }
                $uniqueKeys[] = $key;

                $details->push([
                    'item_id' => $bomDetail->item_id ?? null,
                    'item_code' => $bomDetail->item->item_code ?? '',
                    'item_name' => $bomDetail->item->item_name ?? '',
                    'unit' => $bomDetail->item->unit->unit_code ?? '',
                    'color' => '-', // Tampilkan sebagai global
                    'size' => '-',  // Tampilkan sebagai global
                    'qty' => $globalQty,
                    'consumption' => $bomDetail->consumption ?? 0,
                ]);

                continue; // Lewati iterasi berikutnya
            }

              // 2. Jika size ada di BOM, tetapi remark1 (color) kosong, cocokkan size dengan CBD
            if (!empty($bomDetail->size) && empty($bomDetail->remark1)) {
                foreach ($cbd->details as $cbdDetail) {
                    // Normalisasi data size untuk pencocokan yang lebih akurat
                    $bomSize = strtolower(trim($bomDetail->size));
                    $cbdSize = strtolower(trim($cbdDetail->size));

                    // Cek jika size di BOM cocok dengan size di CBD
                    if ($bomSize === $cbdSize) {
                        $key = $cbdSize . '-' . strtolower(trim($cbdDetail->color)); // Gabungkan size dan color sebagai key untuk unik

                        // Tidak lagi melompati kombinasi yang sudah ada
                        // Jika kombinasi sudah ada, kita tetap menambahkannya
                        if (!in_array($key, $uniqueKeys)) {
                            $uniqueKeys[] = $key;
                        }

                        // Log tambahan untuk memastikan BLACK diproses
                        \Log::info("Adding: Size={$bomDetail->size}, Color={$cbdDetail->color}, Qty={$cbdDetail->qty}");

                        // Menambahkan semua item dengan ukuran yang sesuai
                        $details->push([
                            'item_id' => $bomDetail->item_id ?? null,
                            'item_code' => $bomDetail->item->item_code ?? '',
                            'item_name' => $bomDetail->item->item_name ?? '',
                            'unit' => $bomDetail->item->unit->unit_code ?? '',
                            'color' => $cbdDetail->color ?? '-',  // Tampilkan color jika ada di CBD
                            'size' => $cbdDetail->size ?? '',    // Tampilkan size
                            'qty' => $cbdDetail->qty ?? 0,
                            'consumption' => $bomDetail->consumption ?? 0,
                        ]);
                    }
                }
                continue; // Lewati iterasi berikutnya
            }

// 3. Jika size dan remark1 (color) ada di BOM, cocokkan dengan size dan color di CBD
if (!empty($bomDetail->size) && !empty($bomDetail->remark1)) {
    foreach ($cbd->details as $cbdDetail) {
        // Normalisasi ukuran dan warna
        $bomSize = strtolower(trim($bomDetail->size));  // Size BOM dalam huruf kecil dan tanpa spasi
        $cbdSize = strtolower(trim($cbdDetail->size));  // Size CBD dalam huruf kecil dan tanpa spasi

        // Normalisasi warna BOM dan CBD dengan menghapus spasi berlebih
        $bomColor = strtolower(trim(preg_replace('/\s+/', ' ', $bomDetail->remark1)));  // Warna BOM
        $cbdColor = strtolower(trim(preg_replace('/\s+/', ' ', $cbdDetail->color)));  // Warna CBD

        // Log data yang dibandingkan untuk debugging
        \Log::info("Comparing BOM Size: {$bomSize} with CBD Size: {$cbdSize}");
        \Log::info("Comparing BOM Color: {$bomColor} with CBD Color: {$cbdColor}");

        // Cek jika size dan color di BOM cocok dengan size dan color di CBD
        if ($bomSize === $cbdSize && $bomColor === $cbdColor) {
            // Tampilkan warna sesuai yang ada di CBD, bukan hasil normalisasi
            $details->push([
                'item_id' => $bomDetail->item_id ?? null,
                'item_code' => $bomDetail->item->item_code ?? '',
                'item_name' => $bomDetail->item->item_name ?? '',
                'unit' => $bomDetail->item->unit->unit_code ?? '',
                'color' => $cbdDetail->color ?? '',  // Tampilkan warna asli dari CBD
                'size' => $cbdDetail->size ?? '',    // Tampilkan ukuran asli dari CBD
                'qty' => $cbdDetail->qty ?? 0,
                'consumption' => $bomDetail->consumption ?? 0,
            ]);
        }
    }
    continue; // Lewati iterasi berikutnya
}

            // 5. Jika remark1 (color) ada di BOM, tampilkan hanya untuk color yang sesuai di CBD
if (!empty($bomDetail->remark1)) {
    $normalizedBomColor = strtolower(trim(preg_replace('/\s+/', ' ', $bomDetail->remark1)));

    foreach ($cbd->details->groupBy('color') as $color => $cbdDetailsForColor) {
        $normalizedCbdColor = strtolower(trim(preg_replace('/\s+/', ' ', $color)));

        if ($normalizedBomColor === $normalizedCbdColor || 
            str_contains($normalizedCbdColor, $normalizedBomColor) || 
            str_contains($normalizedBomColor, $normalizedCbdColor) || 
            levenshtein($normalizedBomColor, $normalizedCbdColor) <= 2) {

            $globalQty = $cbdDetailsForColor->sum('qty');

            // Format ulang warna menjadi huruf besar semua
            $formattedColor = strtoupper(str_replace(' ', '', $color));

            $details->push([
                'item_id' => $bomDetail->item_id ?? null,
                'item_code' => $bomDetail->item->item_code ?? '',
                'item_name' => $bomDetail->item->item_name ?? '',
                'unit' => $bomDetail->item->unit->unit_code ?? '',
                'color' => $formattedColor, // Warna huruf besar semua
                'size' => '-', // Tampilkan ukuran global jika tidak ada ukuran
                'qty' => $globalQty,
                'consumption' => $bomDetail->consumption ?? 0,
            ]);

            break;
        }
    }
    continue;
}




        }

        // Urutkan berdasarkan item_id
        $sortedDetails = $details->sortBy('item_id')->values();

        return response()->json(['details' => $sortedDetails]); // Kembalikan data sebagai array
    }


    public function Getbomdetailshampir(Request $request)
    {
        $bomId = $request->get('bom_id');
        $cbdId = $request->get('cbd_id'); // Ambil cbd_id dari request

        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Ambil CBD dan detailnya
        $cbd = Cbd::with('details')->findOrFail($cbdId);

        // Proses data
        $details = collect();
        $uniqueKeys = []; // Array untuk menyimpan kombinasi unik size dan color

        foreach ($bom->details as $bomDetail) {
            // 1. Jika remark1 (color) dan size kosong di BOM, tambahkan global quantity
            if (empty($bomDetail->size) && empty($bomDetail->color) && empty($bomDetail->remark1)) {
                // Hitung total global qty dari seluruh data CBD
                $globalQty = $cbd->details->sum('qty');

                // Pastikan hanya menambahkan sekali
                $key = 'global-' . $bomDetail->item_id;
                if (in_array($key, $uniqueKeys)) {
                    continue; // Lewati jika kombinasi sudah ada
                }
                $uniqueKeys[] = $key;

                $details->push([
                    'item_id' => $bomDetail->item_id ?? null,
                    'item_code' => $bomDetail->item->item_code ?? '',
                    'item_name' => $bomDetail->item->item_name ?? '',
                    'unit' => $bomDetail->item->unit->unit_code ?? '',
                    'color' => '-', // Tampilkan sebagai global
                    'size' => '-',  // Tampilkan sebagai global
                    'qty' => $globalQty,
                    'consumption' => $bomDetail->consumption ?? 0,
                ]);

                continue; // Lewati iterasi berikutnya
            }

            // 2. Jika size ada di BOM, tetapi remark1 (color) kosong, cocokkan size dengan CBD
            if (!empty($bomDetail->size) && empty($bomDetail->remark1)) {
                foreach ($cbd->details as $cbdDetail) {
                    if ($bomDetail->size === $cbdDetail->size) {
                        $key = strtolower($cbdDetail->size . $cbdDetail->color);
                        if (in_array($key, $uniqueKeys)) {
                            continue; // Lewati jika kombinasi sudah ada
                        }
                        $uniqueKeys[] = $key;

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
                }
                continue; // Lewati iterasi berikutnya
            }

            // 3. Jika size dan remark1 (color) ada di BOM, cocokkan dengan size dan color di CBD
           // 3. Jika size dan remark1 (color) ada di BOM, cocokkan dengan size dan color di CBD
            if (!empty($bomDetail->size) && !empty($bomDetail->remark1)) {
                foreach ($cbd->details as $cbdDetail) {
                    if (
                        $bomDetail->size === $cbdDetail->size &&
                        strtolower(trim($bomDetail->remark1)) === strtolower(trim($cbdDetail->color))
                    ) {
                        $key = strtolower($cbdDetail->size . $cbdDetail->color);
                        if (in_array($key, $uniqueKeys)) {
                            continue; // Lewati jika kombinasi sudah ada
                        }
                        $uniqueKeys[] = $key;

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
                }
                continue; // Lewati iterasi berikutnya
            }

            // 4. Jika size ada di BOM, tetapi tidak ada di CBD, jangan tambahkan
            if (!empty($bomDetail->size)) {
                $sizeExistsInCBD = $cbd->details->contains('size', $bomDetail->size);
                if (!$sizeExistsInCBD) {
                    continue; // Jangan tambahkan jika size tidak cocok di CBD
                }
            }

           // Jika remark1 (color) ada di BOM, tampilkan hanya untuk color yang sesuai di CBD
if (!empty($bomDetail->remark1)) {
    // Normalisasi warna di BOM (hapus spasi ekstra dan ubah ke huruf kecil)
    $normalizedBomColor = strtolower(trim(preg_replace('/\s+/', ' ', $bomDetail->remark1)));

    // Group CBD details by color
    foreach ($cbd->details->groupBy('color') as $color => $cbdDetailsForColor) {
        // Normalisasi warna di CBD
        $normalizedCbdColor = strtolower(trim(preg_replace('/\s+/', ' ', $color)));

        // Cek apakah warna di BOM mirip dengan warna di CBD (bisa menggunakan metode lain seperti levenshtein)
        if ($normalizedBomColor === $normalizedCbdColor || str_contains($normalizedCbdColor, $normalizedBomColor) || str_contains($normalizedBomColor, $normalizedCbdColor)) {
            // Hitung total qty untuk warna yang cocok
            $globalQty = $cbdDetailsForColor->sum('qty');

            // Tambahkan ke dalam hasil
            $details->push([
                'item_id' => $bomDetail->item_id ?? null,
                'item_code' => $bomDetail->item->item_code ?? '',
                'item_name' => $bomDetail->item->item_name ?? '',
                'unit' => $bomDetail->item->unit->unit_code ?? '',
                'color' => $color ?? '',
                'size' => '-', // Ukuran ditampilkan sebagai global untuk warna ini
                'qty' => $globalQty,
                'consumption' => $bomDetail->consumption ?? 0,
            ]);
        }
    }
    continue; // Lewati iterasi berikutnya jika warna sudah cocok
}

        }
        

        // Urutkan berdasarkan item_id
        $sortedDetails = $details->sortBy('item_id')->values();

        return response()->json(['details' => $sortedDetails]); // Kembalikan data sebagai array
    }



    public function Getbomdetailsbisatapibelum(Request $request)
    {
        $bomId = $request->get('bom_id');
        $cbdId = $request->get('cbd_id'); // Ambil cbd_id dari request

        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Ambil CBD dan detailnya
        $cbd = Cbd::with('details')->findOrFail($cbdId);

        // Proses data
        $details = collect();
        $uniqueKeys = []; // Array untuk menyimpan kombinasi unik size dan color

        foreach ($bom->details as $bomDetail) {
            // 1. Jika remark1, color, dan size kosong, tambahkan global quantity
            if (empty($bomDetail->size) && empty($bomDetail->color) && empty($bomDetail->remark1)) {
                // Hitung total global qty dari seluruh data CBD
                $globalQty = $cbd->details->sum('qty');

                // Pastikan hanya menambahkan sekali
                $key = 'global-' . $bomDetail->item_id;
                if (in_array($key, $uniqueKeys)) {
                    continue; // Lewati jika kombinasi sudah ada
                }
                $uniqueKeys[] = $key;

                $details->push([
                    'item_id' => $bomDetail->item_id ?? null,
                    'item_code' => $bomDetail->item->item_code ?? '',
                    'item_name' => $bomDetail->item->item_name ?? '',
                    'unit' => $bomDetail->item->unit->unit_code ?? '',
                    'color' => '-', // Tampilkan sebagai global
                    'size' => '-',  // Tampilkan sebagai global
                    'qty' => $globalQty,
                    'consumption' => $bomDetail->consumption ?? 0,
                ]);

                continue; // Lewati iterasi berikutnya
            }

            // 2. Jika size ada, tetapi remark1 (color) kosong, cocokkan size dengan CBD
            if (!empty($bomDetail->size) && empty($bomDetail->color) && empty($bomDetail->remark1)) {
                foreach ($cbd->details as $cbdDetail) {
                    if ($bomDetail->size === $cbdDetail->size) {
                        $key = strtolower($cbdDetail->size . $cbdDetail->color);
                        if (in_array($key, $uniqueKeys)) {
                            continue; // Lewati jika kombinasi sudah ada
                        }
                        $uniqueKeys[] = $key;

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
                }
                continue; // Lewati iterasi berikutnya
            }

            // 3. Jika ada size di BOM, tetapi tidak ada di CBD, jangan tambahkan
            if (!empty($bomDetail->size)) {
                $sizeExistsInCBD = $cbd->details->contains('size', $bomDetail->size);
                if (!$sizeExistsInCBD) {
                    continue; // Jangan tambahkan jika size tidak cocok di CBD
                }
            }

            // 4. Jika remark1 (color) ada di BOM, tampilkan hanya untuk color yang sesuai di CBD
            if (!empty($bomDetail->remark1)) {
                foreach ($cbd->details->groupBy('color') as $color => $cbdDetailsForColor) {
                    if (strtolower($bomDetail->remark1) === strtolower($color)) {
                        $globalQty = $cbdDetailsForColor->sum('qty'); // Hitung total qty untuk warna ini

                        $key = strtolower('-' . $color);
                        if (in_array($key, $uniqueKeys)) {
                            continue; // Lewati jika kombinasi sudah ada
                        }
                        $uniqueKeys[] = $key;

                        $details->push([
                            'item_id' => $bomDetail->item_id ?? null,
                            'item_code' => $bomDetail->item->item_code ?? '',
                            'item_name' => $bomDetail->item->item_name ?? '',
                            'unit' => $bomDetail->item->unit->unit_code ?? '',
                            'color' => $color ?? '',
                            'size' => '-', // Tampilkan sebagai global untuk warna ini
                            'qty' => $globalQty,
                            'consumption' => $bomDetail->consumption ?? 0,
                        ]);
                    }
                }
                continue; // Lewati iterasi berikutnya
            }
        }

        // Urutkan berdasarkan item_id
        $sortedDetails = $details->sortBy('item_id')->values();

        return response()->json(['details' => $sortedDetails]); // Kembalikan data sebagai array
    }




    public function Getbomdetailscolor(Request $request)
    {
        $bomId = $request->get('bom_id');
        $cbdId = $request->get('cbd_id'); // Ambil cbd_id dari request

        // Ambil BOM beserta detailnya
        $bom = Bom::with(['details.item'])->findOrFail($bomId);

        // Ambil nilai remark1 (warna yang diminta) dari BOM
        $remarkColor = strtolower(trim($bom->remark1 ?? ''));

        // Ambil CBD dan detailnya
        $cbd = Cbd::with('details')->findOrFail($cbdId);

        // Kelompokkan BOM Details berdasarkan size
        $bomDetailsGrouped = $bom->details->groupBy('size');

        // Proses CBD Details untuk menggabungkan data BOM dan CBD
        $details = collect();
        $uniqueKeys = []; // Array untuk menyimpan kombinasi unik size dan color

        // Iterasi semua item BOM
        foreach ($bom->details as $bomDetail) {
            // Jika warna di remark1 tidak sesuai, lewati data ini
            if ($remarkColor && strtolower($bomDetail->color ?? '') !== $remarkColor) {
                continue; // Lewati jika warna tidak cocok dengan remark1
            }

            if (empty($bomDetail->size)) {
                // Jika item tidak memiliki size, ambil qty global dari CBD berdasarkan warna
                foreach ($cbd->details->groupBy('color') as $color => $cbdDetailsForColor) {
                    if ($remarkColor && strtolower($color) !== $remarkColor) {
                        continue; // Lewati jika warna tidak cocok dengan remark1
                    }

                    $key = '-' . strtolower($color); // Kombinasi unik untuk item tanpa size
                    if (in_array($key, $uniqueKeys)) {
                        continue; // Lewati jika kombinasi sudah ada
                    }
                    $uniqueKeys[] = $key; // Tambahkan ke daftar kombinasi unik

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
                    // Jika warna di remark1 tidak sesuai, lewati data ini
                    if ($remarkColor && strtolower($bomDetail->color ?? '') !== $remarkColor) {
                        continue; // Lewati jika warna tidak cocok dengan remark1
                    }

                    $key = strtolower($cbdDetail->size . $cbdDetail->color); // Kombinasi unik untuk size dan color
                    if (in_array($key, $uniqueKeys)) {
                        continue; // Lewati jika kombinasi sudah ada
                    }
                    $uniqueKeys[] = $key; // Tambahkan ke daftar kombinasi unik

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
                $key = strtolower($cbdDetail->size . $cbdDetail->color); // Kombinasi unik untuk size dan color
                if (in_array($key, $uniqueKeys)) {
                    continue; // Lewati jika kombinasi sudah ada
                }
                $uniqueKeys[] = $key; // Tambahkan ke daftar kombinasi unik

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




    public function Getbomdetailsoke(Request $request)
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


    public function updateBom(Request $request, $bomId)
    {
        try {
            // Ambil data JSON dari request
            $data = $request->json()->all();

            // Validasi data yang diterima
            $validator = Validator::make($data, [
                'bom_id' => 'required|exists:boms,id',
                'style' => 'required|string|max:255',
                'items' => 'required|array',
                'items.*.item_id' => 'required|integer|exists:items,id',
                'items.*.sizes' => 'required|array',
                'items.*.sizes.*' => 'nullable|numeric|min:0', // Validasi konsumsi sebagai angka
                'items.*.color' => 'nullable|string|max:255', // Validasi warna
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Ambil BOM berdasarkan ID
            $bom = Bom::findOrFail($bomId);

            // Update data BOM
            $bom->style = $data['style'];
            $bom->save();

            // Hapus detail lama untuk BOM ini
            $bom->details()->delete();

            // Simpan detail baru untuk BOM
            foreach ($data['items'] as $itemData) {
                // Pastikan data item memiliki ukuran (size) dan konsumsi (consumption)
                foreach ($itemData['sizes'] as $size => $consumption) {
                    // Simpan hanya jika konsumsi tidak kosong dan lebih besar dari 0
                    if (!empty($consumption) && is_numeric($consumption) && $consumption > 0) {
                        BomDetail::create([
                            'bom_id' => $bom->id,
                            'item_id' => $itemData['item_id'],
                            'size' => $size === 'No Size' ? null : $size, // Handle "No Size" sebagai null
                            'consumption' => $consumption,
                            'remark1' => $itemData['color'] ?? null, // Masukkan warna ke remark1
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'BOM updated successfully.',
            ]);
        } catch (Exception $e) {
            // Tangani error dan kembalikan response JSON
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the BOM.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }





    public function updateBomCC(Request $request, $bomId)
    {
        try {
            $data = $request->json()->all();

            // Validasi data
            $validator = Validator::make($data, [
                'bom_id' => 'required|exists:boms,id',
                'style' => 'required|string|max:255',
                'items' => 'required|array',
                'items.*.item_id' => 'required|integer|exists:items,id',
                'items.*.sizes' => 'required|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Ambil BOM berdasarkan ID
            $bom = Bom::findOrFail($bomId);

            // Update BOM
            $bom->style = $data['style'];
            $bom->save();

            // Hapus detail lama
            $bom->details()->delete();

            // Simpan detail baru
            foreach ($data['items'] as $itemData) {
                foreach ($itemData['sizes'] as $size => $consumption) {
                    if (!empty($consumption)) {
                        BomDetail::create([
                            'bom_id' => $bom->id,
                            'item_id' => $itemData['item_id'],
                            'size' => $size === 'No Size' ? null : $size,
                            'consumption' => $consumption,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'BOM updated successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }





    public function updateBomxx(Request $request, $bomId)
    {
        try {
            // Validasi data input
            $validatedData = $request->validate([
                'bom_id' => 'required|exists:boms,id',
                'style' => 'required|string|max:255',
                'items' => 'required|array',
                'items.*.item_id' => 'required|integer|exists:items,id',

                'items.*.color' => 'nullable|string|max:255',

            ]);

            // Ambil BOM berdasarkan ID
            $bom = Bom::findOrFail($bomId);

            // Perbarui data BOM
            $bom->style = $request->input('style');
            $bom->save();

            // Hapus semua detail BOM lama
            $bom->details()->delete();

            // Tambahkan detail BOM baru
            foreach ($validatedData['items'] as $itemData) {
                $itemId = $itemData['item_id'];


                $color = $itemData['color'] ?? null;

                foreach ($validatedData['items'] as $item) {
                    foreach ($item['colors'] as $color) {
                        foreach ($color['sizes'] as $size => $consumption) {
                            if ($consumption !== null) {
                                // Simpan atau update detail BOM
                                BomDetail::updateOrCreate(
                                    [
                                        'bom_id' => $bom->id,
                                        'item_id' => $item['item_id'],
                                        'size' => $size !== 'null' ? $size : null,
                                        'remark1' => $color['color'] === 'NO COLOR' ? null : $color['color'],
                                    ],
                                    [
                                        'consumption' => $consumption,
                                    ]
                                );
                            }
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'BOM updated successfully.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the BOM.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function Updatebomwork(Request $request, $id)
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





    public function Updatebomx(Request $request, $id)
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
