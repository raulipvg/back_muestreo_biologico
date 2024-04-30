<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

//API LOGIN
Route::group(['prefix'=> '/login'], function () {
    Route::post('/',[LoginController::class,'InicioNormal'])->name('login');
    Route::post('/register',[LoginController::class,'register'])->name('register');
    
    //  RUTAS DE GOOGLE
    Route::get('/google/redirect', [LoginController::class, 'redirectToGoogle']);
    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);
    
    // LOGOUT
    Route::middleware('auth:sanctum')->post('/logout',[LoginController::class,'CerrarSesion'])->name('logout');
});

