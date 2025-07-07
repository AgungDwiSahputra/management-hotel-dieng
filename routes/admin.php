<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PageController as AdminController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
});