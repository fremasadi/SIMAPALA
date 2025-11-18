<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Models\Alat;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $alats = Alat::where('status', 'tersedia')->get();
    return view('welcome', compact('alats'));
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Cart Routes
    |--------------------------------------------------------------------------
    */
    
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::post('/calculate', [CartController::class, 'calculate'])->name('calculate');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    /*
    |--------------------------------------------------------------------------
    | Payment Routes (Authenticated)
    |--------------------------------------------------------------------------
    */
    
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/create/{transaksi}', [PaymentController::class, 'createPayment'])->name('create');
        Route::get('/{pembayaran}', [PaymentController::class, 'show'])->name('show');
        Route::get('/{pembayaran}/result', [PaymentController::class, 'result'])->name('result');
        Route::get('/{pembayaran}/check-status', [PaymentController::class, 'checkStatus'])->name('check-status');
        Route::post('/{pembayaran}/cancel', [PaymentController::class, 'cancel'])->name('cancel');
    });

    Route::get('/payment/get-redirect-url/{pembayaran}', [PaymentController::class, 'getRedirectUrl'])
        ->name('payment.getRedirectUrl');
});

/*
|--------------------------------------------------------------------------
| Midtrans Callback Routes (Public - No Auth Required)
|--------------------------------------------------------------------------
*/

Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/notification', [PaymentController::class, 'notification'])->name('notification');
    Route::get('/finish', [PaymentController::class, 'finish'])->name('finish');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';