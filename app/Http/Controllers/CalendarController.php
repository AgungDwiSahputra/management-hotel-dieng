<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = getAllProducts() ?? [];

        return view('calendar.index', [
            'title' => 'Ketersediaan',
            'description' => 'Halaman untuk mengelola Tanggal Reservasi',
            'products'=> $products
        ]);
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $requestData = $request->except('_token', 'totalUnitPerDate');

        $requestData['start_date'] = date('Y-m-d', strtotime($requestData['start_date']));
        $requestData['end_date'] = date('Y-m-d', strtotime($requestData['end_date']));

        $productId = $requestData['product_id'];
        $product = getProductById($productId);

        if (!$product) {
            return redirect()->back()->withErrors([
                'error' => 'Produk tidak ditemukan.',
            ]);
        }

        // Jika jumlah unit yang diminta melebihi ketersediaan produk, maka tampilkan error
        $unitCount = $requestData['unit_count'];
        if ((int)$unitCount > (int)$requestData['unit']) {
            return redirect()->back()->withErrors([
                'error' => 'Jumlah unit yang diminta melebihi ketersediaan produk.',
            ]);
        }

        // Hitung jumlah malam
        $startDate = new \DateTime($requestData['start_date']);
        $endDate = new \DateTime($requestData['end_date']);
        $night = $startDate->diff($endDate)->days;

        // Hitung total harga
        $total = 0;
        for ($date = $startDate; $date <= $endDate; $date->modify('+1 day')) {
            // Harga weekend jika hari ini adalah hari sabtu atau minggu
            $price = date('N', strtotime($date->format('Y-m-d'))) >= 6
                ? $product['harga_weekend']
                : $product['harga_weekday'];
            // Jumlahkan total dengan mengalikan harga per hari dengan jumlah unit
            $total += $price * $unitCount;
        }

        $dataToCreate = [
            'product_id' => $productId,
            'start_date' => $requestData['start_date'],
            'end_date' => $requestData['end_date'],
            'night' => $night,
            'unit' => (int)$unitCount,
            'total' => $total,
            'name' => $requestData['name'],
            'email' => '-',
            'no_wa' => '-',
            'status' => 'success',
        ];

        $response = FetchAPIPost(env('URL_API') . '/api/v1/availability/'. $productId, $dataToCreate);

        if (isset($response['error'])) {
            return redirect()->back()->withErrors([
                'error' => $response['error'],
            ]);
        }
        return redirect()->route('calendar.show', $productId)->with([
            'success' => 'Reservasi berhasil dibuat',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = FetchAPI(env('URL_API') . '/api/v1/products/'. $id);
        $availability = FetchAPI(env('URL_API') . '/api/v1/availability/' . $id);

        // Hitung total unit berdasarkan date
        $totalUnitPerDate = [];
        foreach ($availability as $item) {
            $date = $item['date'];
            if (!isset($totalUnitPerDate[$date])) {
                $totalUnitPerDate[$date] = 0;
            }
            $totalUnitPerDate[$date] += $item['unit'];
        }

        return view('calendar.show', [
            'title' => 'Ketersediaan Detail',
            'description' => 'Halaman untuk mengelola Tanggal Reservasi',
            'product'=> $product,
            // 'availability' => $availability,
            'totalUnitPerDate' => $totalUnitPerDate,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $id; // Placeholder for deletion logic
    }

    // /**
    //  * Handle the AJAX request to update the product unit.
    //  */
    // public function updateProductUnit(Request $request, $id)
    // {
    //     $request->validate([
    //         'unit' => 'required|integer|min:0',
    //     ]);

    //     $product = FetchAPIPost(env('URL_API') . '/api/v1/products/'. $id, $request->only('unit'));
    //     if (isset($product['error'])) {
    //         return response()->json(['error' => $product['error']], 400);
    //     }

    //     return redirect()->route('calendar.show', $id)->with([
    //         'success' => 'Unit produk berhasil diperbarui',
    //     ]);
    // }
}
