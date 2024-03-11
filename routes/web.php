<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MorbilidadController;
use App\Http\Controllers\NewsController;
use App\Models\News;
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

Route::get('/dashboard',  [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/forbidden', function(){
    return view('admin.forbidden');
});

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
Route::get('/registrarnoticias', function () {
    return view('noticia.registrar', ['title' => 'Noticias']);
});

Route::get('/consultarmorbilidad',[MorbilidadController::class, 'consultarMorbi']);
Route::get('/consultarnoticias',[NewsController::class, 'consultnews']);
Route::get('/editmorbidity/{id}',[MorbilidadController::class, 'editarMorbi']);
Route::put('/editmorbidity/{id}',[MorbilidadController::class, 'update']);
Route::get('/editnoticias/{id}',[NewsController::class, 'editarNoticia']);
Route::put('/editnoticias/{id}',[NewsController::class, 'update']);
Route::delete('/deletemorby/{id}',[MorbilidadController::class, 'destroy']);
Route::delete('/deletenew/{id}',[NewsController::class, 'destroy']);




//Route::get('/consultarmorbilidad', function () {
  //  return view('morbilidad.consultar', ['title' => 'Morbilidad']);
//});


Route::put('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

Route::post('/loginPatient',[LoginController::class,'loginPatient']);
Route::post('/loginDoctor',[LoginController::class,'loginDoctor']);
Route::post('/loginSecretary',[LoginController::class,'loginSecretary']);
Route::post('/loginAdmin',[LoginController::class,'loginAdmin']);
Route::post('/registrarmorbilidad',[MorbilidadController::class, 'RegistrarMorbi']);
Route::post('/registrarnoticias',[NewsController::class, 'Registernew']);


//require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
