<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = getAllProducts();

        // filter data array product hanya 'name, unit, harga_weekday, harga_weekend'
        $products = array_map(function ($product) {
            if(GetUser()->isPartner()) {
                return [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'unit' => $product['unit'],
                ];
            }else {
                return [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'unit' => $product['unit'],
                    'harga_weekday' => $product['harga_weekday'],
                    'harga_weekend' => $product['harga_weekend'],
                ];
            }
        }, $products);

        return view('product.index', [
            'title' => 'Products',
            'description' => 'Halaman untuk mengelola produk',
            'products'=> $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create', [
            'title' => 'Create Product',
            'description' => 'Halaman untuk membuat produk baru',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|integer|min:1',
            'harga_weekday' => 'required|numeric|min:0',
            'harga_weekend' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'unit.required' => 'Jumlah unit harus diisi.',
            'unit.integer' => 'Jumlah unit harus berupa angka.',
            'unit.min' => 'Jumlah unit minimal adalah 1.',
            'harga_weekday.required' => 'Harga weekday harus diisi.',
            'harga_weekday.numeric' => 'Harga weekday harus berupa angka.',
            'harga_weekday.min' => 'Harga weekday minimal adalah 0.',
            'harga_weekend.required' => 'Harga weekend harus diisi.',
            'harga_weekend.numeric' => 'Harga weekend harus berupa angka.',
            'harga_weekend.min' => 'Harga weekend minimal adalah 0.',
        ]);
        $datas = $request->except([
            '_token',
            '_method',
        ]);
        // Tambahkan beberapa field tambahan yang kurang
        $datas['category_id'] = 'cd12155b-fca6-4418-8515-a2e9dacc97e3'; // Default category ID
        $datas['owner'] = GetUser()->email;
        $datas['slug'] = substr(strtolower(str_replace(' ', '-', $request->name)), 0, 200);
        $datas['kamar'] = $request->unit;
        $datas['orang'] = $request->unit; // Default orang sama dengan unit
        $datas['maks_orang'] = $request->maks_orang ?? 2;
        $datas['lokasi'] = $request->lokasi ?? 'Lokasi tidak ditentukan';
        $datas['label'] = null; // Default label null
        $datas['urutan'] = 0; // Default urutan
        $datas['status'] = 'draft'; // Default status draft

        $product = FetchAPIPost(env('URL_API') . '/api/v1/products', $datas);

        if (isset($product['error'])) {
            return back()->withInput()->with(['error' => $product['error']]);
        }

        return redirect()->route('product.index')->with([
            'success' => 'Unit produk berhasil dibuat',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = getProductById($id);

        return view('product.show', [
            'title' => 'Product Details',
            'description' => 'Halaman untuk mengelola product',
            'product'=> $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = getProductById($id);

        return view('product.show', [
            'title' => 'Product Details',
            'description' => 'Halaman untuk mengelola product',
            'product'=> $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|integer|min:1',
            'harga_weekday' => 'required|numeric|min:0',
            'harga_weekend' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'unit.required' => 'Jumlah unit harus diisi.',
            'unit.integer' => 'Jumlah unit harus berupa angka.',
            'unit.min' => 'Jumlah unit minimal adalah 1.',
            'harga_weekday.required' => 'Harga weekday harus diisi.',
            'harga_weekday.numeric' => 'Harga weekday harus berupa angka.',
            'harga_weekday.min' => 'Harga weekday minimal adalah 0.',
            'harga_weekend.required' => 'Harga weekend harus diisi.',
            'harga_weekend.numeric' => 'Harga weekend harus berupa angka.',
            'harga_weekend.min' => 'Harga weekend minimal adalah 0.',
        ]);

        $product = FetchAPIUpdate(env('URL_API') . '/api/v1/products/'. $id, $request->except([
            '_token',
            '_method',
        ]));

         // Tambahkan beberapa field tambahan yang kurang
        if (isset($product['error'])) {
            return response()->json(['error' => $product['error']], 400);
        }

        return redirect()->route('product.index')->with([
            'success' => 'Unit produk berhasil diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Panggil API untuk menghapus produk
        $deletedProduct = FetchAPIDelete(env('URL_API') . '/api/v1/products/' . $id);

        // Jika terjadi error saat menghapus produk, tampilkan pesan error
        if (isset($deletedProduct['error'])) {
            return response()->json(['error' => $deletedProduct['error']], 400);
        }

        // Dapatkan nama rute sebelumnya
        $previousRouteName = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();

        // Periksa apakah rute sebelumnya berada dalam daftar rute yang diizinkan
        $allowedPreviousRoutes = ['product.edit', 'product.show', 'product.index'];

        // Jika rute sebelumnya tidak diizinkan, balik ke halaman sebelumnya
        if (!in_array($previousRouteName, $allowedPreviousRoutes)) {
            return back()->with(['success' => 'Product unit deleted successfully']);
        }

        // Jika rute sebelumnya diizinkan, balik ke halaman index
        return redirect()->route('product.index')->with(['success' => 'Product unit deleted successfully']);
    }
}
