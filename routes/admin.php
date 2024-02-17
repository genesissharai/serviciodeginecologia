<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin', function () {
    return view('admin.index');
});


/*****
 *
 * Registro
 *
 */

Route::get('/registerAdmin', function () {
    return view('admin.register',["registerType"=>"registerAdmin", "loginType" => "loginAdmin"]);
})->name('registerAdmin');

Route::get('/registerDoctor', function () {
    return view('admin.register',["registerType"=>"registerDoctor", "loginType" => "loginDoctor"]);
})->name('registerDoctor');

Route::get('/registerPatient', function () {
    return view('admin.register',["registerType"=>"registerPatient", "loginType" => "loginPatient"]);
})->name('registerPatient');

Route::get('/registerSecretary', function () {
    return view('admin.register',["registerType"=>"registerSecretary", "loginType" => "loginSecretary"]);
})->name('registerSecretary');

Route::post('/registerAdmin', [UserController::class, 'registerAdmin']);
Route::post('/registerDoctor', [UserController::class, 'registerDoctor']);
Route::post('/registerPatient', [UserController::class, 'registerPatient']);
Route::post('/registerSecretary', [UserController::class, 'registerSecretary']);



/******
 *
 * Citas
 *
 */

Route::get('/agendarDisponibilidad',[CitasController::class, 'selectDoctorForAvailabilityPlanning'])
    ->middleware(['auth'])->name('selectDoctorForAvailabilityPlanning');

Route::get('/agendarDisponibilidad/{id}',[CitasController::class, 'availabilityPlanning'])
    ->middleware(['auth'])->name('availabilityPlanning');

Route::post('/agendarDisponibilidad/{id}',[CitasController::class, 'scheduleAvailability'])
    ->middleware(['auth'])->name('scheduleAvailability');

Route::get('/disponibilidadDoctor/{id}',[CitasController::class, 'getDoctorAvailability'])
    ->middleware(['auth'])->name('getDoctorAvailability');

Route::get('/citasPaciente/{id}',[CitasController::class, 'getPatientSchedules'])
    ->middleware(['auth'])->name('getPatientSchedules');

Route::get('/agendarCita',[CitasController::class, 'selectDoctorDateScheduling'])
    ->middleware(['auth'])->name('selectDoctorDateScheduling');

Route::get('/agendarCita/{id}',[CitasController::class, 'dateScheduling'])
    ->middleware(['auth'])->name('dateScheduling');

Route::post('/agendarCita/{id}',[CitasController::class, 'scheduleConsultation'])
    ->middleware(['auth'])->name('scheduleConsultation');
