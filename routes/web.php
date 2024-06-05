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

//Redireccionar hacia Google
//Route::get('/google/redirect',[LoginController::class, 'redirectToGoogle']);
//Recibir la data desde el front
//Route::get('/google/callback',[LoginController::class, 'handleGoogleCallback']);
