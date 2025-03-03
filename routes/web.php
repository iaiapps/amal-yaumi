<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MutabaahController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // admin
    Route::middleware('role:admin')->group(function () {
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('reset/{user}', [UserController::class, 'reset'])->name('user.reset');

        Route::resource('student', StudentController::class);
        Route::resource('mutabaah', MutabaahController::class);
        Route::resource('answer', AnswerController::class);
    });
});
