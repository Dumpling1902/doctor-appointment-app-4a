<?php

use Illuminate\Support\Facades\Route;

Route:: redirect('/', '/admin');
//Route::get('/', function () {
  //  return view('welcome');
//});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class);
    Route::get('consultation/{appointment}', [\App\Http\Controllers\Admin\AppointmentController::class, 'consultation'])->name('consultation');
    Route::get('doctors/{doctor}/schedules', [\App\Http\Controllers\Admin\DoctorController::class, 'schedules'])->name('doctors.schedules');
});
