<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

include __DIR__ . '/developer.php';

Route::get('/', function () {
    if(auth()->check()) {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole('developer')) {
            return redirect()->route('developer.dashboard');
        }
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
});