<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\SucursalController;

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
});
