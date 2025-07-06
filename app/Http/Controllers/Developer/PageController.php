<?php

  namespace App\Http\Controllers\Developer;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;

  class PageController extends Controller
  {
      public function index(Request $request)
      {
          return view('developer.index', [
              'title' => 'Dashboard Developer',
              'description' => 'Halaman utama untuk developer',
          ]);
      }
  }