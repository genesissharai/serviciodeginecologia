<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ReferecesController;
use App\Http\Controllers\ResultadosExamenesController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\MedicalReportController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\AttendanceController;
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
    $jerarquiasDoctor = \App\Models\DoctorHierarchy::all();
    return view('admin.register',["registerType"=>"registerDoctor", "loginType" => "loginDoctor", "jerarquiasDoctor" => $jerarquiasDoctor]);
})->name('registerDoctor');

Route::get('/registerPatient', function () {
    return view('admin.register',["registerType"=>"registerPatient", "loginType" => "loginPatient"]);
})->name('registerPatient');

Route::get('/registerSecretary', function () {
    return view('admin.register',["registerType"=>"registerSecretary", "loginType" => "loginSecretary"]);
})->name('registerSecretary');



Route::get('/admin/registerAdmin', [UserController::class, 'adminRegisterAdminView'])->name('admin-registerAdmin');
Route::get('/admin/registerDoctor', [UserController::class, 'adminRegisterDoctorView'])->name('admin-registerDoctor');
Route::get('/admin/registerPatient', [UserController::class, 'adminRegisterPatientView'])->name('admin-registerPatient');
Route::get('/admin/registerSecretary', [UserController::class, 'adminRegisterSecretaryView'])->name('admin-registerSecretary');



//Update
Route::get('/updateAdmin/{id}', [UserController::class, 'updateAdminView'])->middleware(['auth'])->name('updateAdmin');
Route::get('/updateDoctor/{id}', [UserController::class, 'updateDoctorView'])->middleware(['auth'])->name('updateDoctor');
Route::get('/updatePatient/{id}', [UserController::class, 'updatePatientView'])->middleware(['auth'])->name('updatePatient');
Route::get('/updateSecretary/{id}', [UserController::class, 'updateSecretaryView'])->middleware(['auth'])->name('updateSecretary');





//List
Route::get('/getAdmins', [UserController::class, 'getAdminList'])->middleware(['auth'])->name('getAdmins');
Route::get('/getDoctors', [UserController::class, 'getDoctorList'])->middleware(['auth'])->name('getDoctors');
Route::get('/getPatients', [UserController::class, 'getPatientList'])->middleware(['auth'])->name('getPatients');
Route::get('/getSecretaries', [UserController::class, 'getSecretaryList'])->middleware(['auth'])->name('getSecretaries');



Route::post('/registerAdmin', [UserController::class, 'registerAdmin']);
Route::post('/registerDoctor', [UserController::class, 'registerDoctor']);
Route::post('/registerPatient', [UserController::class, 'registerPatient']);
Route::post('/registerSecretary', [UserController::class, 'registerSecretary']);



Route::post('/admin/registerAdmin', [UserController::class, 'adminRegisterAdmin'])->middleware(['auth']);
Route::post('/admin/registerDoctor', [UserController::class, 'adminRegisterDoctor'])->middleware(['auth']);
Route::post('/admin/registerPatient', [UserController::class, 'adminRegisterPatient'])->middleware(['auth']);
Route::post('/admin/registerSecretary', [UserController::class, 'adminRegisterSecretary'])->middleware(['auth']);


Route::patch('/updateAdmin/{id}', [UserController::class, 'updateAdmin'])->middleware(['auth']);
Route::patch('/updateDoctor/{id}', [UserController::class, 'updateDoctor'])->middleware(['auth']);
Route::patch('/updatePatient/{id}', [UserController::class, 'updatePatient'])->middleware(['auth']);
Route::patch('/updateSecretary/{id}', [UserController::class, 'updateSecretary'])->middleware(['auth']);


Route::get('changeUserPassword/{id}',[UserController::class, 'changeUserPasswordView'])->middleware(['auth']);
Route::patch('changeUserPassword', [UserController::class, 'changeUserPassword'])->middleware(['auth']);
Route::delete('deleteUser', [UserController::class, 'deleteUser'])->middleware(['auth']);



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

Route::get('listaCitasPaciente/{id}', [CitasController::class, 'getSchedulesPatient'])->middleware(['auth']);
Route::get('listaCitasDoctor/{id}', [CitasController::class, 'getSchedulesDoctor'])->middleware(['auth']);
Route::get('listaCitas', [CitasController::class, 'getSchedules'])->middleware(['auth']);

Route::delete('/cancelarCita', [CitasController::class, 'cancelSchedule'])->middleware(['auth']);
Route::patch('/marcarCitaAsistida', [CitasController::class, 'markAsAttended'])->middleware(['auth']);
Route::patch('/marcarCitaNoAtendida', [CitasController::class, 'markAsUnattended'])->middleware(['auth']);

/**
 *
 *  Referencias y Resultado de examen - Mandar a hacer los examenes
 *
 */

Route::get('/referenciasPaciente/{id}', [ReferecesController::class, 'getPatientReferences'])->middleware(['auth']);
Route::get('/crearReferenciaPaciente/{id}', [ReferecesController::class, 'create'])->middleware(['auth']);
Route::post('/crearReferenciaPaciente/{id}', [ReferecesController::class, 'store'])->middleware(['auth']);
Route::get('/modificarReferenciaPaciente/{id}', [ReferecesController::class, 'updateView'])->middleware(['auth']);
Route::put('/modificarReferenciaPaciente/{id}', [ReferecesController::class, 'update'])->middleware(['auth']);
Route::delete('/eliminarReferenciaPaciente/{id}', [ReferecesController::class, 'delete'])->middleware(['auth']);

Route::get('/examenesPaciente/{id}', [ReferecesController::class, 'getPatientReferences'])->middleware(['auth']);

Route::get('/registrarResultadoExamenPaciente/{id}', [ResultadosExamenesController::class, 'create'])->middleware(['auth']);
Route::post('/registrarResultadoExamenPaciente/{id}', [ResultadosExamenesController::class, 'store'])->middleware(['auth']);
Route::get('/modificarResultadoExamenPaciente/{id}', [ResultadosExamenesController::class, 'updateView'])->middleware(['auth']);
Route::put('/modificarResultadoExamenPaciente/{id}', [ResultadosExamenesController::class, 'update'])->middleware(['auth']);
Route::delete('/eliminarResultadoExamenPaciente/{id}', [ResultadosExamenesController::class, 'delete'])->middleware(['auth']);


/**
 *
 *  Informe medico
 *
 */


Route::get('/informeMedicoPaciente/{id}', [MedicalReportController::class, 'getPatientMedicalReports'])->middleware(['auth']);
Route::get('/crearInformeMedicoPaciente/{id}', [MedicalReportController::class, 'create'])->middleware(['auth']);
Route::post('/crearInformeMedicoPaciente/{id}', [MedicalReportController::class, 'store'])->middleware(['auth']);
Route::post('/descargarInformeMedico', [MedicalReportController::class, 'downloadPDF'])->middleware(['auth']);
Route::get('/modificarInformeMedicoPaciente/{id}', [MedicalReportController::class, 'updateView'])->middleware(['auth']);
Route::put('/modificarInformeMedicoPaciente/{id}', [MedicalReportController::class, 'update'])->middleware(['auth']);
Route::delete('/eliminarInformeMedicoPaciente/{id}', [MedicalReportController::class, 'delete'])->middleware(['auth']);


/**
 *
 * Control de asistencias
 *
 */

Route::get('asistencia_diaria', [AttendanceController::class,'dailyAttendanceView'])->middleware(['auth']);
Route::post('asistencia_diaria', [AttendanceController::class,'storeDailyAttendance'])->middleware(['auth']);
Route::delete('asistencia_diaria', [AttendanceController::class,'deleteDailyAttendance'])->middleware(['auth']);
// Route::put('asistencia_diaria', [AttendanceController::class,''])->middleware(['auth']);

Route::get('asistencia_quirofano', [AttendanceController::class,'operatingRoomAttendanceView'])->middleware(['auth']);
Route::post('asistencia_quirofano', [AttendanceController::class,'storeOperatingRoomAttendance'])->middleware(['auth']);
Route::delete('asistencia_quirofano', [AttendanceController::class,'deleteOperatingRoomAttendance'])->middleware(['auth']);
// Route::put('asistencia_quirofano', [AttendanceController::class,''])->middleware(['auth']);



/* Historia clinica */

Route::get('/historiaClinicaPaciente/{id}', [MedicalHistoryController::class, 'updateView'])->middleware(['auth']);
Route::put('/historiaClinicaPaciente', [MedicalHistoryController::class, 'update'])->middleware(['auth']);

Route::get('/estadisticas', [StatisticsController::class, 'getGeneralStatistics'])->middleware(['auth']);
