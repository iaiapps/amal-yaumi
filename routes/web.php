<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MutabaahController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\SchoolController;
// use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\MutabaahItemController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('landing');
})->name('landing');

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('reset/{user}', [UserController::class, 'reset'])->name('user.reset');

        Route::get('setting', [\App\Http\Controllers\SettingController::class, 'edit'])->name('setting.index');
        Route::put('setting', [\App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');

        Route::resource('classroom', ClassroomController::class)->only(['index', 'show']);
        Route::resource('student', StudentController::class)->only(['index']);
        Route::resource('mutabaah', MutabaahController::class);
        Route::get('mutabaah-calendar', [MutabaahController::class, 'calendar'])->name('mutabaah.calendar');
        Route::get('mutabaah-calendar/{student}', [MutabaahController::class, 'studentCalendar'])->name('mutabaah.student-calendar');

        Route::resource('mutabaah-item', MutabaahItemController::class)->only(['index']);
        Route::resource('answer', AnswerController::class);



    });

    // guru
    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::resource('classroom', ClassroomController::class);
        Route::resource('student', StudentController::class);
        Route::get('mutabaah-item/reorder', [MutabaahItemController::class, 'reorder'])->name('mutabaah-item.reorder');
        Route::post('mutabaah-item/reorder', [MutabaahItemController::class, 'updateOrder'])->name('mutabaah-item.reorder.update');
        Route::resource('mutabaah-item', MutabaahItemController::class);
        Route::post('mutabaah-item/{mutabaah_item}/toggle', [MutabaahItemController::class, 'toggle'])->name('mutabaah-item.toggle');
        Route::get('mutabaah-calendar', [MutabaahController::class, 'calendar'])->name('mutabaah.calendar');
        Route::get('mutabaah-calendar/{student}', [MutabaahController::class, 'studentCalendar'])->name('mutabaah.student-calendar');
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

    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
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
