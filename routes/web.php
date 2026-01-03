<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/auth/auths', [AuthController::class, 'view'])->name('auth.auths');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboards/index_admin', function () {
        return view('dashboards.index_admin');
    })->name('dashboards.index_admin');

});