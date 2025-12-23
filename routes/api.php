<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AlatController;
use App\Http\Controllers\Api\V1\PinjamController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\KasBulananController;
use App\Http\Controllers\Api\V1\KasPembayaranController;

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

     Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // Kas Bulanan
    Route::get('/kas-bulanan', [KasBulananController::class, 'index']);
    Route::get('/kas-bulanan/{id}', [KasBulananController::class, 'show']);
    Route::get('/kas-bulanan/total/summary', [KasBulananController::class, 'totalKas']);

    // Kas Pembayaran
    Route::get('/kas-pembayaran', [KasPembayaranController::class, 'index']);
    Route::post('/kas-pembayaran', [KasPembayaranController::class, 'store']);
    Route::get('/kas-pembayaran/{id}', [KasPembayaranController::class, 'show']);
});
