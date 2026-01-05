<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MutabaahController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Profile (untuk semua user yang login)
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // admin
    Route::middleware('role:admin')->group(function () {
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('reset/{user}', [UserController::class, 'reset'])->name('user.reset');

        Route::get('school/edit', [SchoolController::class, 'edit'])->name('school.edit');
        Route::put('school', [SchoolController::class, 'update'])->name('school.update');

        Route::resource('student', StudentController::class);
        Route::resource('mutabaah', MutabaahController::class);
        Route::resource('answer', AnswerController::class);

        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/student/{id}/pdf', [ReportController::class, 'studentPdf'])->name('reports.student.pdf');
        Route::get('reports/all/pdf', [ReportController::class, 'allPdf'])->name('reports.all.pdf');
        Route::get('reports/students/export', [ReportController::class, 'exportStudents'])->name('reports.students.export');
        Route::get('reports/mutabaah/export', [ReportController::class, 'exportMutabaah'])->name('reports.mutabaah.export');

        // Import
        Route::get('import', [ImportController::class, 'index'])->name('import.index');
        Route::get('import/template', [ImportController::class, 'template'])->name('import.template');
        Route::post('import', [ImportController::class, 'import'])->name('import.store');
    });

    Route::middleware('role:siswa')->group(function () {
        // catatan, sebenarnya ini bisa pakai controller-resource cuman beda handle di view. memakai 'if'. Dibedakan dengan role
        Route::get('amalyaumi', [MutabaahController::class, 'amalIndex'])->name('amal.index');
        Route::get('amalyaumi/create', [MutabaahController::class, 'amalCreate'])->name('amal.create');
        Route::post('amalyaumi', [MutabaahController::class, 'amalStore'])->name('amal.store');
        Route::get('amalyaumi/{mutabaah}/edit', [MutabaahController::class, 'amalEdit'])->name('amal.edit');
        Route::get('amalyaumi/{mutabaah}', [MutabaahController::class, 'amalShow'])->name('amal.show');
        Route::put('amalyaumi/{mutabaah}', [MutabaahController::class, 'amalUpdate'])->name('amal.update');
        Route::delete('amalyaumi/{mutabaah}', [MutabaahController::class, 'amalDestroy'])->name('amal.destroy');
    });
});
