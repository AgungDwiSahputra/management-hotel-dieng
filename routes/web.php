<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(auth()->check()) {
        return redirect()->route('dashboard');
    }
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

Route::middleware(['auth', 'role:admin|developer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('reservation', ReservationController::class);
    Route::resource('calendar', CalendarController::class);
});