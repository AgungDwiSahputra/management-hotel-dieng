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
        $products = FetchAPI('https://website-hotel-dieng.test/api/v1/products');

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
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = FetchAPI('https://website-hotel-dieng.test/api/v1/products/'. $id);

        return view('calendar.show', [
            'title' => 'Ketersediaan Detail',
            'description' => 'Halaman untuk mengelola Tanggal Reservasi',
            'product'=> $product
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
}
