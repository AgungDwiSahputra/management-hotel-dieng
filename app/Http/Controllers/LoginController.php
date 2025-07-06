<?php

  namespace App\Http\Controllers\Auth;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use Illuminate\Foundation\Auth\AuthenticatesUsers;

  class LoginController extends Controller
  {
      use AuthenticatesUsers;

      protected $redirectTo = '/home';

      public function __construct()
      {
          $this->middleware('guest')->except('logout');
      }

      protected function authenticated(Request $request, $user)
      {
          if ($user->hasRole('admin')) {
              return redirect()->route('admin.dashboard');
          } elseif ($user->hasRole('developer')) {
              return redirect()->route('developer.dashboard');
          }
          return redirect()->route('home');
      }
  }