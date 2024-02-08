<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
