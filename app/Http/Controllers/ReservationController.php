<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = FetchAPI(env('URL_API') . '/api/v1/reservations');

        return view('reservation.index', [
            'title' => 'Reservation',
            'description' => 'Halaman untuk mengelola reservasi',
            'reservations'=> $reservations,
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
        $reservation_details = FetchAPI(env('URL_API') . "/api/v1/reservations/" . $id);

        return view('reservation.show', [
            'title' => 'Reservation Details',
            'description' => 'Halaman untuk mengelola reservasi',
            'reservation_details'=> $reservation_details
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
