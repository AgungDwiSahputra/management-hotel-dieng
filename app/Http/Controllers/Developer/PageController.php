<?php

  namespace App\Http\Controllers\Developer;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;

  class PageController extends Controller
  {
      public function index(Request $request)
      {
          return "INI HALAMAN UTAMA DEVELOPER";
      }
  }