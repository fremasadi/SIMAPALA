<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;

use Illuminate\Support\Facades\Route;
use App\Models\Alat;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $alats = Alat::all()
        ->groupBy('nama_alat')
        ->map(function ($group) {
            $tersedia = $group->filter(fn ($a) => $a->status === 'tersedia' && $a->stok > 0);
            $first    = $group->first();
            return (object) [
                'kode_alat'       => $first->kode_alat,
                'nama_alat'       => $first->nama_alat,
                'ukuran'          => $first->ukuran,
                'bahan'           => $first->bahan,
                'image'           => $first->image,
                'harga_sewa'      => $first->harga_sewa,
                'total_tersedia'  => $tersedia->sum('stok'),
                'available_id'    => $tersedia->first()?->id,
                'status'          => $tersedia->isNotEmpty() ? 'tersedia' : 'tidak_tersedia',
            ];
        })
        ->values();

    return view('welcome', compact('alats'));
})->name('home');

/*
|--------------------------------------------------------------------------
| Midtrans Webhook & Finish — PUBLIC, harus SEBELUM route {id}
| Jika diletakkan setelah /payment/{id}, Laravel akan mencocokkan
| /payment/finish ke show('finish') bukan finish() — menyebabkan 403/404
|--------------------------------------------------------------------------
*/

Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');

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
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    // Payment (routes dengan {id} harus SETELAH static routes /finish dan /callback)
    Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/payment/check/{id}', [PaymentController::class, 'checkStatus'])->name('payment.check');
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');

    // Transaction History
    Route::get('/my-transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/my-transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::post('/my-transactions/{id}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');

});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
