<?php

  namespace App\Http\Controllers;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;

  class DashboardController extends Controller
  {
      public function index()
      {
            $url = env('URL_API') . "/api/v1/reservations";

            $headers = array(
                "Authorization: Bearer " . env('SANCTUM_TOKEN_PREFIX', '6|3|e6bf715df350e35ecdda5b73d4dda5c0bafab902033cee003ea5e104774ebdc6jQAGz3B9E9i71hgNenc6aK0gbDUt4wibSNUcihF050c17ac0dricciR9QuFRqEOzQOauWoyiviQPtxmk3Y8YNOP16ef955f0')
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);
            
            return view('index', [
                'title' => 'Dashboard Admin',
                'description' => 'Halaman utama untuk admin',
                'reservations'=> $response
            ]);
      }
  }