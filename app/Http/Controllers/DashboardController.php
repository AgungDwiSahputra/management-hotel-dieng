<?php

  namespace App\Http\Controllers;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;

  class DashboardController extends Controller
  {
      public function index()
      {
          return view('index', [
              'title' => 'Dashboard Admin',
              'description' => 'Halaman utama untuk admin',
          ]);
      }
  }