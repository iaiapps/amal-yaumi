<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;



Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/coba', function () {
        return view('coba');
    });
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
