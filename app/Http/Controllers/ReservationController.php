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
        $url = "https://website-hotel-dieng.test/api/v1/reservations";

        $headers = array(
            "Authorization: Bearer " . env('SANCTUM_TOKEN_PREFIX', '6|3|e6bf715df350e35ecdda5b73d4dda5c0bafab902033cee003ea5e104774ebdc6jQAGz3B9E9i71hgNenc6aK0gbDUt4wibSNUcihF050c17ac0dricciR9QuFRqEOzQOauWoyiviQPtxmk3Y8YNOP16ef955f0')
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return view('reservation.index', [
            'title' => 'Reservation',
            'description' => 'Halaman untuk mengelola reservasi',
            'reservations'=> $response
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
        $url = "https://website-hotel-dieng.test/api/v1/reservations/" . $id;

        $headers = array(
            "Authorization: Bearer " . env('SANCTUM_TOKEN_PREFIX', '6|3|e6bf715df350e35ecdda5b73d4dda5c0bafab902033cee003ea5e104774ebdc6jQAGz3B9E9i71hgNenc6aK0gbDUt4wibSNUcihF050c17ac0dricciR9QuFRqEOzQOauWoyiviQPtxmk3Y8YNOP16ef955f0')
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return view('reservation.show', [
            'title' => 'Reservation Details',
            'description' => 'Halaman untuk mengelola reservasi',
            'reservation_details'=> $response
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
