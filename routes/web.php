<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MorbilidadController;



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

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/dashboard', function () {
    return view('admin.dashboard', ['title' => 'Dashboard']);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/loginAdmin', function(){
    return view('admin.login',["loginType" => "loginAdmin", "registerType" => "registerAdmin"]);
})->name('loginAdmin');
Route::get('/loginDoctor', function(){
    return view('admin.login',["loginType" => "loginDoctor", "registerType" => "registerDoctor"]);
})->name('loginDoctor');
Route::get('/loginPatient', function(){
    return view('admin.login',["loginType" => "loginPatient", "registerType" => "registerPatient"]);
})->name('loginPatient');
Route::get('/loginSecretary', function(){
    return view('admin.login',["loginType" => "loginSecretary", "registerType" => "registerSecretary"]);
})->name('loginSecretary');
Route::get('/registrarmorbilidad', function () {
    return view('morbilidad.registrar', ['title' => 'Morbilidad']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

Route::post('/loginPatient',[LoginController::class,'loginPatient']);
Route::post('/loginDoctor',[LoginController::class,'loginDoctor']);
Route::post('/loginSecretary',[LoginController::class,'loginSecretary']);
Route::post('/loginAdmin',[LoginController::class,'loginAdmin']);
Route::post('/registrarmorbilidad',[MorbilidadController::class, 'RegistrarMorbi']);


//require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
