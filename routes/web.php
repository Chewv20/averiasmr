<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AveriasController;

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
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('averias',AveriasController::class);
    Route::post('/averias/getL',[AveriasController::class,'getL']);
    Route::post('/averias/get',[AveriasController::class,'get_estaciones']);
    Route::post('/averias/getm',[AveriasController::class,'get_motrices']);
    Route::post('/averias/getp',[AveriasController::class,'getPlantilla']);
    Route::post('/averias/getr',[AveriasController::class,'getReporte']);
    Route::post('/averias/geta',[AveriasController::class,'get'])->name('getAll');
    Route::get('/averias/delete/{id}',[AveriasController::class, 'delete']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

require __DIR__.'/auth.php';
