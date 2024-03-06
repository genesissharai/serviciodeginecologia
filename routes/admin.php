<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ReferecesController;
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
 * Usuarios
 *
 */
//Register
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

//Update
Route::get('/updateAdmin/{id}', [UserController::class, 'updateAdminView'])->name('updateAdmin');

Route::get('/updateDoctor/{id}', [UserController::class, 'updateDoctorView'])->name('updateDoctor');

Route::get('/updatePatient/{id}', [UserController::class, 'updatePatientView'])->name('updatePatient');

Route::get('/updateSecretary/{id}', [UserController::class, 'updateSecretaryView'])->name('updateSecretary');


//List
Route::get('/getAdmins', [UserController::class, 'getAdminList'])->name('getAdmins');

Route::get('/getDoctors', [UserController::class, 'getDoctorList'])->name('getDoctors');

Route::get('/getPatients', [UserController::class, 'getPatientList'])->name('getPatients');

Route::get('/getSecretaries', [UserController::class, 'getSecretaryList'])->name('getSecretaries');



Route::post('/registerAdmin', [UserController::class, 'registerAdmin']);
Route::post('/registerDoctor', [UserController::class, 'registerDoctor']);
Route::post('/registerPatient', [UserController::class, 'registerPatient']);
Route::post('/registerSecretary', [UserController::class, 'registerSecretary']);

Route::patch('/updateAdmin/{id}', [UserController::class, 'updateAdmin']);
Route::patch('/updateDoctor/{id}', [UserController::class, 'updateDoctor']);
Route::patch('/updatePatient/{id}', [UserController::class, 'updatePatient']);
Route::patch('/updateSecretary/{id}', [UserController::class, 'updateSecretary']);






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

Route::get('/citasPaciente',[CitasController::class, 'getPatientSchedules'])
    ->middleware(['auth'])->name('getPatientSchedules');

Route::get('/agendarCita',[CitasController::class, 'selectDoctorDateScheduling'])
    ->middleware(['auth'])->name('selectDoctorDateScheduling');

    Route::get('/agendarCita/{id}',[CitasController::class, 'dateScheduling'])
    ->middleware(['auth'])->name('dateScheduling');

Route::post('/agendarCita/{id}',[CitasController::class, 'scheduleConsultation'])
->middleware(['auth'])->name('scheduleConsultation');

Route::get('/buscarPaciente', [CitasController::class, 'searchPatients'])->middleware(['auth']);

Route::delete('/cancelarCita', [CitasController::class, 'cancelSchedule'])->middleware(['auth']);

/**
 *
 *  Referencias - Mandar a hacer los examenes
 *
 */

Route::get('/administrarExamenesPaciente/{id}', [ReferecesController::class, 'getPatientReferences'])->middleware(['auth']);
Route::get('/crearExamenPaciente/{id}', [ReferecesController::class, 'create'])->middleware(['auth']);
Route::post('/crearExamenPaciente/{id}', [ReferecesController::class, 'store'])->middleware(['auth']);
Route::get('/modificarExamenPaciente/{id}', [ReferecesController::class, 'updateView'])->middleware(['auth']);
Route::put('/modificarExamenPaciente/{id}', [ReferecesController::class, 'update'])->middleware(['auth']);
Route::delete('/eliminarExamenPaciente/{id}', [ReferecesController::class, 'delete'])->middleware(['auth']);

