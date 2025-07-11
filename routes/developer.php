<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Developer\PageController as DeveloperController;

Route::middleware(['auth', 'role:developer'])->group(function () {
    Route::get('/developer/dashboard', [DeveloperController::class, 'index'])->name('dashboard');
});