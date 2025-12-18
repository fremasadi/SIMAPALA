<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AlatController;
use App\Http\Controllers\Api\V1\PinjamController;
use App\Http\Controllers\Api\V1\DashboardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
     Route::post('/logout', [AuthController::class, 'logout']);
     Route::get('/dashboard', [DashboardController::class, 'index']);

     // Alat
     Route::get('/alats', [AlatController::class, 'index']);
     Route::get('/alats/{id}', [AlatController::class, 'show']);

     //sewa
     Route::post('/transaksi/pinjam', [PinjamController::class, 'pinjam']);
     Route::get('/transaksi/pinjam', [PinjamController::class, 'index']);
});
