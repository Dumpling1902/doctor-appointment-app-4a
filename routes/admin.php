<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientImportController;
Route::get('/', function(){
    return view ('admin.dashboard');
})->name('dashboard');

//Gestión de Roles
Route::resource('roles', RoleController::class);

//Gestión de Usuarios
Route::resource('users', UserController::class);

//Gestión de pacientes
Route::get('patients/import', [PatientImportController::class, 'create'])->name('patients.import');
Route::post('patients/import', [PatientImportController::class, 'store'])->name('patients.import.store');
Route::resource('patients', PatientController::class);

//Gestión de doctores
Route::resource('doctors', DoctorController::class);