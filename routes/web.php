<?php

use App\Http\Controllers\AveriasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LineaController;
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
});

Route::resource('averias',AveriasController::class);
Route::resource('linea',LineaController::class);
Route::post('/averias/get',[AveriasController::class,'get_estaciones']);
Route::post('/averias/getm',[AveriasController::class,'get_motrices']);
Route::post('/averias/getp',[AveriasController::class,'getPlantilla']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth'); 
