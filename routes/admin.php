<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;

Route::get('/', function(){
    return view ('admin.dashboard');
})->name('dashboard');

//Gestión de Roles
Route::resource('roles', RoleController::class);

//Gestión de Usuarios
Route::resource('users', UserController::class);

//Gestión de pacientes
Route::resource('patients', PatientController::class);