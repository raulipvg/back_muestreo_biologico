<?php

use App\Http\Controllers\FormularioController;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\NaveController;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\LugarMController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\FlotaController;
use App\Http\Controllers\PuertoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\PersonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API MANTEMIENTO FORMULARIO
Route::group(['prefix'=> '/formulario'], function () {
    Route::get('/getall',[FormularioController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[FormularioController::class,'get'])->name('GetId');
    Route::post('/update',[FormularioController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[FormularioController::class,'cambiarestado'])->name('CambiarEstado');

});

//API MANTEMIENTO ESPECIE
Route::group(['prefix'=> '/especie'], function () {
    Route::get('/getall',[EspecieController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[EspecieController::class,'get'])->name('GetId');
    Route::post('/create',[EspecieController::class,'create'])->name('Create');
    Route::post('/update',[EspecieController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[EspecieController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MANTEMIENTO NAVE
Route::group(['prefix'=> '/nave'], function () {
    Route::get('/getall',[NaveController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[NaveController::class,'get'])->name('GetId');
    Route::post('/create',[NaveController::class,'create'])->name('Create');
    Route::post('/update',[NaveController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[NaveController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MANTEMIENTO PLANTA
Route::group(['prefix'=> '/planta'], function () {
    Route::get('/getall',[PlantaController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[PlantaController::class,'get'])->name('GetId');
    Route::post('/create',[PlantaController::class,'create'])->name('Create');
    Route::post('/update',[PlantaController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[PlantaController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MANTENIMIENTO LUGARM
Route::group(['prefix'=> '/lugarm'], function () {
    Route::get('/getall',[LugarMController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[LugarMController::class,'get'])->name('GetId');
    Route::post('/create',[LugarMController::class,'create'])->name('Create');
    Route::post('/update',[LugarMController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[LugarMController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MANTENIMIENTO CLASIFICACION
Route::group(['prefix'=> '/clasificacion'], function () {
    Route::get('/getall',[ClasificacionController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[ClasificacionController::class,'get'])->name('GetId');
    Route::post('/create',[ClasificacionController::class,'create'])->name('Create');
    Route::post('/update',[ClasificacionController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[ClasificacionController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MANTENIMIENTO FLOTA
Route::group(['prefix'=> '/flota'], function () {
    Route::get('/getall',[FlotaController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[FlotaController::class,'get'])->name('GetId');
    Route::post('/create',[FlotaController::class,'create'])->name('Create');
    Route::post('/update',[FlotaController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[FlotaController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MANTENIMIENTO PUERTO 
Route::group(['prefix'=> '/puerto'], function () {
    Route::get('/getall',[PuertoController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[PuertoController::class,'get'])->name('GetId');
    Route::post('/create',[PuertoController::class,'create'])->name('Create');
    Route::post('/update',[PuertoController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[PuertoController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MANTENIMIENTO DEPARTAMENTO
Route::group(['prefix'=> '/departamento'], function () {
    Route::get('/getall',[DepartamentoController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[DepartamentoController::class,'get'])->name('GetId');
    Route::post('/create',[DepartamentoController::class,'create'])->name('Create');
    Route::post('/update',[DepartamentoController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[DepartamentoController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MATENIMIENTO PERSONA 
Route::group(['prefix'=> '/persona'], function () {
    Route::get('/getall',[PersonaController::class,'getall'])->name('GetAll');
    Route::get('/get/{id}',[PersonaController::class,'get'])->name('GetId');
    Route::post('/create',[PersonaController::class,'create'])->name('Create');
    Route::post('/update',[PersonaController::class,'update'])->name('Update');
    Route::post('/cambiarestado',[PersonaController::class,'cambiarestado'])->name('CambiarEstado');
});

//API MANTENIMIENTO RESPUESTA
Route::group(['prefix'=> '/respuesta'], function () {
    Route::get('/getall',[RespuestaController::class,'Index'])->name('GetAll');
    Route::get('/resp',[RespuestaController::class,'Index'])->name('Respuesta');
    Route::post('/ingresar',[RespuestaController::class,'IngresarRespuesta'])->name('IngresarRespuesta');
    Route::get('/query',[RespuestaController::class,'Query'])->name('Query');

});

Route::get('/resp',[RespuestaController::class,'Index']);