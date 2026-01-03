<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\EspecialistaController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\UsuarioController;

Route::get('test', function() {
    return response()->json(['message' => 'Funciona']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/perfil', function (Request $request) {
        return $request->user();
    });

    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UsuarioController::class, 'listar']);
        Route::post('/', [UsuarioController::class, 'guardar']);
        Route::put('/{id}', [UsuarioController::class, 'actualizar']);
        Route::delete('/{id}', [UsuarioController::class, 'eliminar']);
        Route::patch('/restaurar/{id}', [UsuarioController::class, 'restaurar']);
    });

    Route::prefix('migrations')->group(function () {
    Route::post('/run', [MigrationController::class, 'runMigrations']);
    Route::get('/status', [MigrationController::class, 'migrationStatus']);        
    Route::post('/rollback', [MigrationController::class, 'rollbackMigrations']);
    });

    Route::prefix('sucursales')->group(function () {
        Route::get('/', [SucursalController::class, 'listar']);
        Route::post('/', [SucursalController::class, 'guardar']);
        Route::put('/{id}', [SucursalController::class, 'actualizar']);
        Route::delete('/{id}', [SucursalController::class, 'eliminar']);
        Route::patch('/restaurar/{id}', [SucursalController::class, 'restaurar']);
    });

        Route::prefix('servicios')->group(function () {
        Route::get('/', [ServicioController::class, 'listar']);
        Route::post('/', [ServicioController::class, 'guardar']);
        Route::put('/{id}', [ServicioController::class, 'actualizar']);
        Route::delete('/{id}', [ServicioController::class, 'eliminar']);
        Route::patch('/restaurar/{id}', [ServicioController::class, 'restaurar']);
    });

        Route::prefix('especialistas')->group(function () {
        Route::get('/', [EspecialistaController::class, 'listar']);
        Route::post('/', [EspecialistaController::class, 'guardar']);
        Route::put('/{id}', [EspecialistaController::class, 'actualizar']);
        Route::delete('/{id}', [EspecialistaController::class, 'eliminar']);
        Route::patch('/restaurar/{id}', [EspecialistaController::class, 'restaurar']);
    });

        Route::prefix('citas')->group(function () {
        Route::get('/', [CitasController::class, 'listar']);
        Route::post('/', [CitasController::class, 'guardar']);
        Route::put('/{id}', [CitasController::class, 'actualizar']);
        Route::delete('/{id}', [CitasController::class, 'eliminar']);
        Route::patch('/restaurar/{id}', [CitasController::class, 'restaurar']);
    });

});