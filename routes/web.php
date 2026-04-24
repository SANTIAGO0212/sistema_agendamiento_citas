<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/auth/auths', [AuthController::class, 'view'])->name('auth.auths');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/dashboards/index_admin', [DashboardController::class, 'index'])->name('dashboards.index_admin');

    Route::prefix('usuarios')->group(function () {
        Route::get('/modulos/usuario', [UsuarioController::class, 'view'])->name('modulos.usuario');
        Route::get('/activo', [UsuarioController::class, 'listar_activo']);
        Route::get('/inactivo', [UsuarioController::class, 'listar_inactivo']);
        Route::post('/', [UsuarioController::class, 'guardar']);
        Route::put('/{id}', [UsuarioController::class, 'actualizar']);
        Route::delete('/{id}', [UsuarioController::class, 'eliminar']);
        Route::patch('/restaurar/{id}', [UsuarioController::class, 'restaurar']);
    });

});