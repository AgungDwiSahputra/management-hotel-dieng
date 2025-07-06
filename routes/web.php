<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

include __DIR__ . '/developer.php';
include __DIR__ . '/admin.php';

Route::get('/', function () {
    return redirect()->route('login');
});

/* Fungsi ini digunakan untuk mengenerate route untuk authentikasi
==> seperti login, register, forgot password, dan lain-lain
==> Route yang dihasilkan akan seperti ini:
==> - GET /login
==> - GET /register
==> - GET /password/reset
==> - POST /login
==> - POST /register
==> - POST /password/email
==> - POST /password/reset
*/
Auth::routes();
// ================================================

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
